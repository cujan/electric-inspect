# 🔄 Migračná Stratégia - Implementácia Nového Modelu

## 📋 Súhrn Zmien

Aplikácia sa mení z **stringového `inspection_type`** na **hierarchický systém**:

- `inspection_types` (Elektrická, Mechanická)
- `inspection_kinds` (Základná, Podrobná, Bezpečnostná)
- `components` (Transformátor, Vedenie)
- Dynamické `inspection_kind_fields` a `component_parameters`

## ✅ Už Implementované

### 1. Migrácie (8 nových tabuliek)

```
✓ inspection_types
✓ inspection_kinds
✓ inspection_kind_fields
✓ components
✓ component_parameters
✓ inspection_components
✓ inspection_component_values
✓ inspection_kind_values
✓ inspections (aktualizácia - nový `inspection_kind_id`)
```

### 2. Eloquent Modely

```
✓ InspectionType
✓ InspectionKind
✓ InspectionKindField
✓ InspectionKindValue
✓ Component
✓ ComponentParameter
✓ InspectionComponent
✓ InspectionComponentValue
✓ Inspection (aktualizovaný so vzťahmi)
```

### 3. Seeders

- **InspectionTypeSeeder**: Elektrická, Mechanická revízia s polami
- **ComponentSeeder**: Transformátor, Vedenie, Rozvodnica s parametrami
- Zaregistrované v `DatabaseSeeder.php`

## 🔧 Ďalšie Kroky na Spustenie

### 1. Spustenie Migrácií

```bash
php artisan migrate
```

### 2. Seedovanie Testovacích Dát

```bash
php artisan db:seed
```

### 3. Migrácia Existujúcich Inspektácií (MANUAL)

Existujúce inspekcie majú `inspection_type` ako STRING. Musíme ich mapovať na nový systém:

```bash
# Pravidlo: Starý `inspection_type` → nový `inspection_kind_id`
# Príklady:
# "electrical" → InspectionKind::where('name', 'like', '%elektric%')->first()
# "mechanical" → InspectionKind::where('name', 'like', '%mecanic%')->first()
```

**Odporúčaný prístup:**

- Vytvorí sa artisanový príkaz: `php artisan inspect:migrate-types`
- Alebo MANUAL update v DB migácii

### 4. Aktualizácia Viewov a Formov

Budú potrebovať zmeny:

- ✓ Formy pre vytvorovanie inspekcie (Select: InspectionType → InspectionKind)
- ✓ Dynamické polia podľa `InspectionKind`
- ✓ Pridanie / odobranie komponentov
- ✓ Formulár na meranie parametrov komponentov

## 📊 Príkladný Workflow

```
1. Vytvorím novú inšpekciu
   ├─ Vyberiem typ: "Elektrická revízia"
   ├─ Vyberiem druh: "Podrobná elektrická skúška"
   │
   ├─ Vyplním polia pre "Podrobná":
   │  ├─ Meno testera
   │  ├─ Meracie zariadenie
   │  ├─ Vlhkosť (POVINNÉ)
   │  ├─ Teplota (POVINNÉ)
   │  ├─ Izolančný odpor (POVINNÉ)
   │  └─ Kontinuita (POVINNÉ)
   │
   └─ Pridam komponenty:
      ├─ Transformátor
      │  ├─ Impedancia: 12.5 Ω
      │  ├─ Primárne napätie: 230 V
      │  ├─ Sekundárne napätie: 50 V
      │  └─ Pomer: 4.6
      │
      ├─ Vedenie
      │  ├─ Odpor: 0.5 Ω
      │  └─ Izolancia: 2.5 MΩ
      │
      └─ Rozvodnica
         ├─ Napätie: 230 V
         ├─ Prúd: 16 A
         └─ Frekvencia: 50 Hz
```

## 🎯 Hotové - Čo Chýba

### ✅ Database Layer

- Migrácie
- Modely
- Seeders

### ❌ Application Layer (TODO)

- [ ] Controllers na správu typov a druhov revízií
- [ ] Controllers na správu komponentov
- [ ] API endpointy
- [ ] Validation Rules
- [ ] Factories pre testing

### ❌ Frontend Layer (TODO)

- [ ] Formy na vytvorenie inšpekcie
- [ ] Dynamické polia podľa druhu revízie
- [ ] UI na pridávanie/odoberanie komponentov
- [ ] UI na meranie parametrov

### ❌ Migration Layer (TODO)

- [ ] Artisanový príkaz na migráciu starých `inspection_type` stringov
- [ ] Data validation pre migráciu

## 🚀 Adresár Novej Štruktúry

```
app/Models/
├── InspectionType.php              ✓ Nový
├── InspectionKind.php              ✓ Nový
├── InspectionKindField.php         ✓ Nový
├── InspectionKindValue.php         ✓ Nový
├── Component.php                   ✓ Nový
├── ComponentParameter.php          ✓ Nový
├── InspectionComponent.php         ✓ Nový
├── InspectionComponentValue.php    ✓ Nový
├── Inspection.php                  ✓ Aktualizovaný
└── ...ostatné

database/migrations/
├── 2026_02_17_100000_create_inspection_types_table.php           ✓
├── 2026_02_17_100001_create_inspection_kinds_table.php           ✓
├── 2026_02_17_100002_create_inspection_kind_fields_table.php     ✓
├── 2026_02_17_100003_create_components_table.php                 ✓
├── 2026_02_17_100004_create_component_parameters_table.php       ✓
├── 2026_02_17_100005_create_inspection_components_table.php      ✓
├── 2026_02_17_100006_create_inspection_component_values_table.php ✓
├── 2026_02_17_100007_update_inspections_add_inspection_kind.php  ✓
├── 2026_02_17_100008_create_inspection_kind_values_table.php     ✓
└── ...ostatné

database/seeders/
├── InspectionTypeSeeder.php        ✓ Nový
├── ComponentSeeder.php             ✓ Nový
└── DatabaseSeeder.php              ✓ Aktualizovaný
```

## ⚠️ Poznámky

1. **Staré `inspection_type` pole**: Zostane v DB pre backward compatibility, ale bude ignorované
2. **Format dát (JSON)**: Polia `options` v tabuľkách sú JSON - flexibilné pre budúce typy polí
3. **Validation**: Je potrebné nastaviť pravidlá pre validáciu zadávaných hodnôt

## 📞 Support

- 📝 Viď [DB_ANALYSIS.md](DB_ANALYSIS.md) pre detailnú analýzu modelu
- 🔍 Viď seedery pre príklady dátových štruktúr
