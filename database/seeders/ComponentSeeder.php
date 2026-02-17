<?php

namespace Database\Seeders;

use App\Models\Component;
use App\Models\ComponentParameter;
use App\Models\Organization;
use Illuminate\Database\Seeder;

class ComponentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get first organization
        $organization = Organization::first();
        if (!$organization) {
            return;
        }

        // Transformátor
        $transformer = Component::create([
            'organization_id' => $organization->id,
            'name' => 'Transformátor',
            'description' => 'Elektromagnetický menič napätí a prúdov',
            'icon' => 'fa-magnet',
            'order' => 1,
        ]);

        $transformerParams = [
            [
                'name' => 'impedancia',
                'label' => 'Impedancia',
                'field_type' => 'number',
                'is_required' => true,
                'unit' => 'Ω',
                'order' => 1,
                'help_text' => 'Merajte impedanciu na primárnej strane',
            ],
            [
                'name' => 'pomernapati',
                'label' => 'Pomer napätí',
                'field_type' => 'number',
                'is_required' => true,
                'unit' => 'U1/U2',
                'order' => 2,
            ],
            [
                'name' => 'primaarne_napatie',
                'label' => 'Primárne napätie',
                'field_type' => 'number',
                'is_required' => true,
                'unit' => 'V',
                'order' => 3,
            ],
            [
                'name' => 'sekundarne_napatie',
                'label' => 'Sekundárne napätie',
                'field_type' => 'number',
                'is_required' => true,
                'unit' => 'V',
                'order' => 4,
            ],
        ];

        foreach ($transformerParams as $param) {
            $param['component_id'] = $transformer->id;
            ComponentParameter::create($param);
        }

        // Vedenie
        $cable = Component::create([
            'organization_id' => $organization->id,
            'name' => 'Vedenie',
            'description' => 'Elektrické vedenie/kábel',
            'icon' => 'fa-code-branch',
            'order' => 2,
        ]);

        $cableParams = [
            [
                'name' => 'odpor',
                'label' => 'Odpor',
                'field_type' => 'number',
                'is_required' => true,
                'unit' => 'Ω',
                'order' => 1,
            ],
            [
                'name' => 'izolancia',
                'label' => 'Izolančný odpor',
                'field_type' => 'number',
                'is_required' => true,
                'unit' => 'MΩ',
                'order' => 2,
            ],
            [
                'name' => 'kapacita',
                'label' => 'Kapacita',
                'field_type' => 'number',
                'is_required' => false,
                'unit' => 'pF/m',
                'order' => 3,
            ],
        ];

        foreach ($cableParams as $param) {
            $param['component_id'] = $cable->id;
            ComponentParameter::create($param);
        }

        // Rozvodnica
        $switchboard = Component::create([
            'organization_id' => $organization->id,
            'name' => 'Rozvodnica',
            'description' => 'Elektrická rozvodnica',
            'icon' => 'fa-sliders-h',
            'order' => 3,
        ]);

        $switchboardParams = [
            [
                'name' => 'napatie',
                'label' => 'Napätie',
                'field_type' => 'number',
                'is_required' => true,
                'unit' => 'V',
                'order' => 1,
            ],
            [
                'name' => 'prud',
                'label' => 'Prúd',
                'field_type' => 'number',
                'is_required' => true,
                'unit' => 'A',
                'order' => 2,
            ],
            [
                'name' => 'frekvencia',
                'label' => 'Frekvencia',
                'field_type' => 'number',
                'is_required' => true,
                'unit' => 'Hz',
                'order' => 3,
            ],
        ];

        foreach ($switchboardParams as $param) {
            $param['component_id'] = $switchboard->id;
            ComponentParameter::create($param);
        }
    }
}
