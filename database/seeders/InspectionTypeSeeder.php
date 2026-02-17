<?php

namespace Database\Seeders;

use App\Models\InspectionKind;
use App\Models\InspectionKindField;
use App\Models\InspectionType;
use App\Models\Organization;
use Illuminate\Database\Seeder;

class InspectionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get first organization or create default
        $organization = Organization::first() ?? Organization::create([
            'name' => 'Default Organization',
            'slug' => 'default',
            'is_active' => true,
        ]);

        // Elektrická revízia
        $electrical = InspectionType::create([
            'organization_id' => $organization->id,
            'name' => 'Elektrická revízia',
            'description' => 'Revízia elektrických zariadení a vedení',
            'icon' => 'fa-bolt',
            'color' => '#FFD700',
            'order' => 1,
        ]);

        // Elektrická > Základná
        $this->createBasicElectricalKind($electrical);

        // Elektrická > Podrobná
        $this->createDetailedElectricalKind($electrical);

        // Elektrická > Bezpečnostná
        $this->createSafetyElectricalKind($electrical);

        // Mechanická revízia
        $mechanical = InspectionType::create([
            'organization_id' => $organization->id,
            'name' => 'Mechanická revízia',
            'description' => 'Mechanická a vizuálna kontrola',
            'icon' => 'fa-tools',
            'color' => '#FF6347',
            'order' => 2,
        ]);

        // Mechanická > Vizuálna
        $this->createVisualMechanicalKind($mechanical);
    }

    private function createBasicElectricalKind($inspectionType)
    {
        $kind = InspectionKind::create([
            'inspection_type_id' => $inspectionType->id,
            'name' => 'Základná elektrická skúška',
            'description' => 'Bezpečnostná kontrola a základné merania',
            'order' => 1,
        ]);

        $fields = [
            [
                'name' => 'tester_name',
                'label' => 'Meno testera',
                'field_type' => 'text',
                'is_required' => true,
                'order' => 1,
                'placeholder' => 'Skúšajúci',
            ],
            [
                'name' => 'measurement_device',
                'label' => 'Meracie zariadenie',
                'field_type' => 'text',
                'is_required' => true,
                'order' => 2,
                'placeholder' => 'napr. Fluke 1507',
            ],
            [
                'name' => 'humidity',
                'label' => 'Vlhkosť',
                'field_type' => 'number',
                'is_required' => false,
                'order' => 3,
                'placeholder' => '0-100',
            ],
            [
                'name' => 'temperature',
                'label' => 'Teplota',
                'field_type' => 'number',
                'is_required' => false,
                'order' => 4,
                'placeholder' => '°C',
            ],
            [
                'name' => 'equipment_condition',
                'label' => 'Stav zariadenia',
                'field_type' => 'select',
                'is_required' => true,
                'order' => 5,
                'options' => json_encode([
                    'good' => 'Dobrý stav',
                    'acceptable' => 'Akceptovateľný',
                    'poor' => 'Zlý stav',
                ]),
            ],
        ];

        foreach ($fields as $field) {
            $field['inspection_kind_id'] = $kind->id;
            InspectionKindField::create($field);
        }
    }

    private function createDetailedElectricalKind($inspectionType)
    {
        $kind = InspectionKind::create([
            'inspection_type_id' => $inspectionType->id,
            'name' => 'Podrobná elektrická skúška',
            'description' => 'Komprehenzívna analýza s meraniami',
            'order' => 2,
        ]);

        $fields = [
            [
                'name' => 'tester_name',
                'label' => 'Meno testera',
                'field_type' => 'text',
                'is_required' => true,
                'order' => 1,
            ],
            [
                'name' => 'measurement_device',
                'label' => 'Meracie zariadenie',
                'field_type' => 'text',
                'is_required' => true,
                'order' => 2,
            ],
            [
                'name' => 'humidity',
                'label' => 'Vlhkosť',
                'field_type' => 'number',
                'is_required' => true,
                'order' => 3,
            ],
            [
                'name' => 'temperature',
                'label' => 'Teplota',
                'field_type' => 'number',
                'is_required' => true,
                'order' => 4,
            ],
            [
                'name' => 'isolation_value',
                'label' => 'Hodnota izolácie',
                'field_type' => 'number',
                'is_required' => true,
                'order' => 5,
            ],
            [
                'name' => 'continuity',
                'label' => 'Kontinuita',
                'field_type' => 'number',
                'is_required' => true,
                'order' => 6,
            ],
        ];

        foreach ($fields as $field) {
            $field['inspection_kind_id'] = $kind->id;
            InspectionKindField::create($field);
        }
    }

    private function createSafetyElectricalKind($inspectionType)
    {
        $kind = InspectionKind::create([
            'inspection_type_id' => $inspectionType->id,
            'name' => 'Bezpečnostná kontrola elektrických zariadení',
            'description' => 'Bezpečnostná inšpekcia podľa STN noriem',
            'order' => 3,
        ]);

        $fields = [
            [
                'name' => 'tester_name',
                'label' => 'Meno testera',
                'field_type' => 'text',
                'is_required' => true,
                'order' => 1,
            ],
            [
                'name' => 'norm_standard',
                'label' => 'Norma',
                'field_type' => 'text',
                'is_required' => true,
                'order' => 2,
                'placeholder' => 'napr. STN 33 2150',
            ],
            [
                'name' => 'safety_check_result',
                'label' => 'Výsledok bezpečnostnej kontroly',
                'field_type' => 'select',
                'is_required' => true,
                'order' => 3,
                'options' => json_encode([
                    'pass' => 'Vyhovuje',
                    'fail' => 'Nevyhovuje',
                    'conditional' => 'Podmienečne',
                ]),
            ],
        ];

        foreach ($fields as $field) {
            $field['inspection_kind_id'] = $kind->id;
            InspectionKindField::create($field);
        }
    }

    private function createVisualMechanicalKind($inspectionType)
    {
        $kind = InspectionKind::create([
            'inspection_type_id' => $inspectionType->id,
            'name' => 'Vizuálna kontrola',
            'description' => 'Vizuálna inšpekcia bez meraní',
            'order' => 1,
        ]);

        $fields = [
            [
                'name' => 'inspector_name',
                'label' => 'Meno inšpektora',
                'field_type' => 'text',
                'is_required' => true,
                'order' => 1,
            ],
            [
                'name' => 'damage_found',
                'label' => 'Nájdené poškodenie',
                'field_type' => 'textarea',
                'is_required' => false,
                'order' => 2,
                'placeholder' => 'Opíšte všetky viditeľné poškodenia',
            ],
            [
                'name' => 'cleanliness',
                'label' => 'Čistota',
                'field_type' => 'select',
                'is_required' => true,
                'order' => 3,
                'options' => json_encode([
                    'clean' => 'Čisté',
                    'dusty' => 'Prašné',
                    'dirty' => 'Špinavé',
                ]),
            ],
        ];

        foreach ($fields as $field) {
            $field['inspection_kind_id'] = $kind->id;
            InspectionKindField::create($field);
        }
    }
}
