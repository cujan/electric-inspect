<?php

namespace App\Services;

use App\Exports\InspectionsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class ExcelExportService
{
    /**
     * Export inspections to Excel
     */
    public function exportInspections($query = null, array $filters = []): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $filename = sprintf(
            'inspections-export-%s.xlsx',
            now()->format('Y-m-d-His')
        );

        return Excel::download(new InspectionsExport($query, $filters), $filename);
    }

    /**
     * Store inspections export to storage
     */
    public function storeInspectionsExport($query = null, array $filters = [], string $path = 'exports'): string
    {
        $filename = sprintf(
            'inspections-export-%s.xlsx',
            now()->format('Y-m-d-His')
        );

        $fullPath = $path . '/' . $filename;

        Excel::store(new InspectionsExport($query, $filters), $fullPath, 'public');

        return $fullPath;
    }

    /**
     * Export inspections to CSV
     */
    public function exportInspectionsToCSV($query = null, array $filters = []): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $filename = sprintf(
            'inspections-export-%s.csv',
            now()->format('Y-m-d-His')
        );

        return Excel::download(
            new InspectionsExport($query, $filters),
            $filename,
            \Maatwebsite\Excel\Excel::CSV
        );
    }
}
