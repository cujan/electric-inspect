# Analýza Databázového Modelu - Zmena Filozofie Aplikácie

## 📋 Aktuálny Stav

```
┌─────────────────────────────────────────────────────────┐
│ AKTUÁLNA ŠTRUKTÚRA                                      │
└─────────────────────────────────────────────────────────┘

Inspection
├── inspection_type (STRING) ❌ - len text bez štruktúry
├── equipment_id → Equipment
│   └── equipment_type_id → EquipmentType
│       └── EquipmentTypeParameter[] (parametre na meranie)
└── InspectionParameterValue[] (vyplnené hodnoty)

PROBLÉM:
- inspection_type je len string - bez hierarchie
- Každá revízia má rovnaké základné údaje
- Parametre sú viazané na typ vybavenia (EquipmentType)
  a nie na typ/druh revízie
```

## 🎯 Čo Chceš Dosiahnuť

```
┌─────────────────────────────────────────────────────────┐
│ ŽELANÁ ŠTRUKTÚRA                                        │
└─────────────────────────────────────────────────────────┘

1️⃣ VÝBER TYPU REVÍZIE
   ┌─ Elektrická revízia
   │  ├─ Základná elektrická skúška
   │  ├─ Podrobná elektrická skúška
   │  └─ Bezpečnostná kontrola
   │
   └─ Mechanická revízia
      ├─ Vizuálna kontrola
      └─ Termosnímanie

2️⃣ ZÁKLADNÉ ÚDAJE
   - Podľa vybraného TYPU a DRUHU sa vyplňujú rôzne polia
   - Napr. "Elektrická > Základná" má iné údaje ako "Mechanická > Vizuálna"

3️⃣ KOMPONENTY
   - Podľa typu revízie si vyberiem, ktoré komponenty sa budú merať
   - Každý komponent má VLASTNÉ parametre na meranie
   - Napr. pri "Elektrickej revízii" merame:
     * Transformátor (parametre: poměr, impedancia, uhľadenie...)
     * Vedenie (parametre: odpor, izolancia, kapacita...)
     * Rozvodnica (parametre: napätie, prúd, frekvencia...)

```

## 📊 Aktuálne Tabuľky

| Tabuľka                       | Popis                                | FK                                         |
| ----------------------------- | ------------------------------------ | ------------------------------------------ |
| `inspections`                 | Hlavné záznamy revízií               | equipment_id                               |
| `equipment`                   | Vybavenie                            | customer_id, equipment_type_id             |
| `equipment_types`             | Typy vybavenia (napr. Transformátor) | organization_id                            |
| `equipment_type_parameters`   | Parametre typu vybavenia             | equipment_type_id                          |
| `inspection_parameter_values` | Vyplnené hodnoty                     | inspection_id, equipment_type_parameter_id |

## ✅ NÁVRH NOVÝCH TABUĽIEK

### 1. `inspection_types` - Typy revízií

```sql
id, organization_id, name, description, icon?, color?, created_at, updated_at
```

Príklady: "Elektrická", "Mechanická", "Termografická"

### 2. `inspection_kinds` - Druhy revízií v rámci typu

```sql
id, inspection_type_id, name, description, order, created_at, updated_at
```

Príklady:

- Elektrická -> "Základná", "Podrobná", "Bezpečnostná"
- Mechanická -> "Vizuálna", "Detailná"

### 3. `inspection_kind_fields` - Základné údaje pre druh revízie

```sql
id, inspection_kind_id, name, label, field_type, is_required, order, created_at, updated_at
```

Príklady:

- Elektrická/Základná -> "testerName", "measurementDevice", "humidity", "temperature"
- Elektrická/Podrobná -> všetky z Základnej + "isolationValue", "continuity"

### 4. `components` - Druhy komponentov

```sql
id, organization_id, name, description, icon?, created_at, updated_at
```

Príklady: "Transformátor", "Vedenie", "Rozvodnica", "Spínač"

### 5. `component_parameters` - Parametre komponentov

```sql
id, component_id, name, label, field_type, is_required, unit?, order, created_at, updated_at
```

### 6. `inspection_components` - Komponenty v inspekácii

```sql
id, inspection_id, component_id, created_at, updated_at
```

### 7. `inspection_component_values` - Namerané hodnoty komponentov

```sql
id, inspection_component_id, component_parameter_id, value, unit?, created_at, updated_at
```

## 🔗 Nový Workflow

```
1. Vytvorím INSPECTION
   ↓
2. Vyberiem INSPECTION_TYPE (napr. "Elektrická")
   ↓
3. Vyberiem INSPECTION_KIND (napr. "Podrobná elektrická skúška")
   ↓
4. Vyplním INSPECTION_KIND_FIELDS
   (napr. testerName, device, equipment condition, ...)
   ↓
5. Vyberiem COMPONENTS, ktoré sa budú merať
   (napr. Transformátor, Vedenie)
   ↓
6. Pre každý komponent vyplním COMPONENT_PARAMETERS
   (napr. pre Transformátor:
    - primárne napätie
    - sekundárne napätie
    - impedancia, atď.)
```

## 📈 Zmeny v Inspection Modeli

**Stara štruktúra:**

```php
Inspection {
    inspection_type: string,      // ❌ STARÝ
    equipment_id: ForeignKey,
    inspector_id: ForeignKey,
    result: enum,
    status: enum,
    findings: text,
}
```

**Nová štruktúra:**

```php
Inspection {
    inspection_type_id: ForeignKey,      // ✅ NOVÝ
    inspection_kind_id: ForeignKey,      // ✅ NOVÝ
    customer_id: ForeignKey,             // Zákazník s prístrojmi
    inspector_id: ForeignKey,
    inspection_date: date,
    result: enum,
    status: enum,
    notes: text,

    // Zastarané:
    // equipment_id (bude v inspection_components)
    // inspection_type (string)
}
```

## ⚠️ DÔLEŽITÉ ROZHODNUTIA

- ✅ **Komponenty\*** sú UNIVERSÁLNE (nie viazané na typ vybavenia)
- ✅ **Základné údaje** sú ŠPECIFICKÉ pre typ+druh revízie
- ✅ **Equipment položka** už nemusí byť priamo vo Inspekácii (alebo ostane ako referencia, ale komenty budú univerzálne)
- ⚠️ **Migračná stratégia**: Existujúce inspekcie sa budú musieť migrovať
