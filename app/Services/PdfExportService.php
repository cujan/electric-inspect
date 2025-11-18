<?php

namespace App\Services;

use App\Models\Inspection;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class PdfExportService
{
    /**
     * Generate a PDF report for a single inspection
     */
    public function generateInspectionReport(Inspection $inspection): \Barryvdh\DomPDF\PDF
    {
        $inspection->load(['customer', 'equipment', 'inspector', 'files', 'organization', 'parameterValues.parameter']);

        $data = [
            'inspection' => $inspection,
            'customer' => $inspection->customer,
            'equipment' => $inspection->equipment,
            'inspector' => $inspection->inspector,
            'organization' => $inspection->organization,
            'parameterValues' => $inspection->parameterValues,
            'generatedAt' => now(),
        ];

        return Pdf::loadView('pdf.inspection-report', $data)
            ->setPaper('a4', 'portrait')
            ->setOption('margin-top', 10)
            ->setOption('margin-right', 10)
            ->setOption('margin-bottom', 10)
            ->setOption('margin-left', 10);
    }

    /**
     * Download inspection report as PDF
     */
    public function downloadInspectionReport(Inspection $inspection): \Illuminate\Http\Response
    {
        $pdf = $this->generateInspectionReport($inspection);

        $filename = sprintf(
            'inspection-report-%s-%s.pdf',
            $inspection->customer->customer_id,
            $inspection->inspection_date->format('Y-m-d')
        );

        return $pdf->download($filename);
    }

    /**
     * Stream (preview) inspection report as PDF
     */
    public function streamInspectionReport(Inspection $inspection): \Illuminate\Http\Response
    {
        $pdf = $this->generateInspectionReport($inspection);

        return $pdf->stream();
    }

    /**
     * Save inspection report to storage
     */
    public function saveInspectionReport(Inspection $inspection, string $path = 'reports/inspections'): string
    {
        $pdf = $this->generateInspectionReport($inspection);

        $filename = sprintf(
            'inspection-report-%s-%s.pdf',
            $inspection->customer->customer_id,
            $inspection->inspection_date->format('Y-m-d')
        );

        $fullPath = $path . '/' . $filename;

        Storage::disk('public')->put($fullPath, $pdf->output());

        return $fullPath;
    }

    /**
     * Generate a summary report for multiple inspections
     */
    public function generateSummaryReport($inspections, array $filters = []): \Barryvdh\DomPDF\PDF
    {
        $data = [
            'inspections' => $inspections,
            'filters' => $filters,
            'generatedAt' => now(),
            'organization' => auth()->user()->organization,
        ];

        return Pdf::loadView('pdf.inspections-summary', $data)
            ->setPaper('a4', 'landscape')
            ->setOption('margin-top', 10)
            ->setOption('margin-right', 10)
            ->setOption('margin-bottom', 10)
            ->setOption('margin-left', 10);
    }

    /**
     * Download summary report
     */
    public function downloadSummaryReport($inspections, array $filters = []): \Illuminate\Http\Response
    {
        $pdf = $this->generateSummaryReport($inspections, $filters);

        $filename = sprintf(
            'inspections-summary-%s.pdf',
            now()->format('Y-m-d-His')
        );

        return $pdf->download($filename);
    }
}
