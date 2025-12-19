<?php

namespace App\Exports;

use App\Models\Inspection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Collection;

class InspectionsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle, WithColumnWidths
{
    protected $query;
    protected $filters;

    public function __construct($query = null, array $filters = [])
    {
        $this->query = $query;
        $this->filters = $filters;
    }

    /**
     * @return Collection
     */
    public function collection()
    {
        if ($this->query) {
            return $this->query->with(['customer', 'equipment', 'inspector'])->get();
        }

        return Inspection::with(['customer', 'equipment', 'inspector'])->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            __('Inspection ID'),
            __('Inspection Type'),
            __('Customer ID'),
            __('Customer Name'),
            __('Equipment Type'),
            __('Equipment Location'),
            __('Inspector'),
            __('Inspection Date'),
            __('Inspection Time'),
            __('Status'),
            __('Result'),
            __('Notes'),
            __('Created At'),
        ];
    }

    /**
     * @param Inspection $inspection
     * @return array
     */
    public function map($inspection): array
    {
        return [
            $inspection->id,
            $inspection->inspection_type,
            $inspection->customer->customer_id,
            $inspection->customer->company_name,
            $inspection->equipment->equipment_type,
            $inspection->equipment->location,
            $inspection->inspector->name,
            $inspection->inspection_date->format('Y-m-d'),
            $inspection->inspection_time ? date('H:i', strtotime($inspection->inspection_time)) : '',
            ucfirst(str_replace('_', ' ', $inspection->status)),
            $inspection->result,
            $inspection->notes ?? '',
            $inspection->created_at->format('Y-m-d H:i:s'),
        ];
    }

    /**
     * @param Worksheet $sheet
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 12],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4F46E5']
                ],
                'font' => ['color' => ['rgb' => 'FFFFFF'], 'bold' => true],
            ],
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return __('Inspections');
    }

    /**
     * @return array
     */
    public function columnWidths(): array
    {
        return [
            'A' => 12,  // Inspection ID
            'B' => 25,  // Inspection Type
            'C' => 15,  // Customer ID
            'D' => 30,  // Customer Name
            'E' => 25,  // Equipment Type
            'F' => 25,  // Equipment Location
            'G' => 20,  // Inspector
            'H' => 15,  // Inspection Date
            'I' => 12,  // Inspection Time
            'J' => 12,  // Status
            'K' => 20,  // Result
            'L' => 40,  // Notes
            'M' => 20,  // Created At
        ];
    }
}
