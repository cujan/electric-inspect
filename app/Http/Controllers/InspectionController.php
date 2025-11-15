<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Equipment;
use App\Models\Inspection;
use App\Models\InspectionFile;
use App\Services\PdfExportService;
use App\Services\ExcelExportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InspectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Inspection::with(['customer', 'equipment', 'inspector']);

        // Filter by inspector for technicians
        if (auth()->user()->isTechnician()) {
            $query->where('inspector_id', auth()->id());
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('inspection_type', 'like', "%{$search}%")
                  ->orWhereHas('customer', function ($q) use ($search) {
                      $q->where('company_name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('equipment', function ($q) use ($search) {
                      $q->where('equipment_type', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by result
        if ($request->filled('result')) {
            $query->where('result', $request->result);
        }

        // Filter by customer
        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        $inspections = $query->latest('inspection_date')->paginate(15);
        $customers = Customer::orderBy('company_name')->get();

        return view('inspections.index', compact('inspections', 'customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::orderBy('company_name')->get();
        $equipment = Equipment::with('customer')->orderBy('equipment_type')->get();

        // Get technicians for assignment (only for admins)
        $technicians = null;
        if (!auth()->user()->isTechnician()) {
            $technicians = \App\Models\User::where('organization_id', auth()->user()->organization_id)
                ->where('role', 'technician')
                ->orderBy('name')
                ->get();
        }

        return view('inspections.create', compact('customers', 'equipment', 'technicians'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'equipment_id' => 'required|exists:equipment,id',
            'inspection_type' => 'required|string|max:255',
            'inspection_date' => 'required|date',
            'inspection_time' => 'nullable',
            'result' => 'required|string|max:255',
            'status' => 'required|in:scheduled,in_progress,completed,cancelled',
            'notes' => 'nullable|string',
            'inspector_id' => 'nullable|exists:users,id',
            'files.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        $validated['organization_id'] = auth()->user()->organization_id;

        // Assign inspector: use selected technician for admins, current user for technicians
        if (auth()->user()->isTechnician() || !$request->filled('inspector_id')) {
            $validated['inspector_id'] = auth()->id();
        }

        $inspection = Inspection::create($validated);

        // Handle file uploads
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('inspections', 'public');

                InspectionFile::create([
                    'fileable_id' => $inspection->id,
                    'fileable_type' => Inspection::class,
                    'file_name' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'file_type' => $file->getClientOriginalExtension(),
                    'mime_type' => $file->getMimeType(),
                    'file_size' => $file->getSize(),
                    'uploaded_by' => auth()->id(),
                ]);
            }
        }

        return redirect()->route('inspections.show', $inspection)
            ->with('success', 'Inspection created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Inspection $inspection)
    {
        $inspection->load(['customer', 'equipment', 'inspector', 'files']);

        return view('inspections.show', compact('inspection'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inspection $inspection)
    {
        $customers = Customer::orderBy('company_name')->get();
        $equipment = Equipment::with('customer')->orderBy('equipment_type')->get();

        // Get technicians for assignment (only for admins)
        $technicians = null;
        if (!auth()->user()->isTechnician()) {
            $technicians = \App\Models\User::where('organization_id', auth()->user()->organization_id)
                ->where('role', 'technician')
                ->orderBy('name')
                ->get();
        }

        return view('inspections.edit', compact('inspection', 'customers', 'equipment', 'technicians'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inspection $inspection)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'equipment_id' => 'required|exists:equipment,id',
            'inspection_type' => 'required|string|max:255',
            'inspection_date' => 'required|date',
            'inspection_time' => 'nullable',
            'result' => 'required|string|max:255',
            'status' => 'required|in:scheduled,in_progress,completed,cancelled',
            'notes' => 'nullable|string',
            'inspector_id' => 'nullable|exists:users,id',
            'files.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        // Handle inspector assignment for admins
        if (!auth()->user()->isTechnician() && $request->filled('inspector_id')) {
            // Admins can reassign
            $validated['inspector_id'] = $request->inspector_id;
        } else {
            // Technicians keep their assignment, don't change inspector_id
            unset($validated['inspector_id']);
        }

        $inspection->update($validated);

        // Handle file uploads
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('inspections', 'public');

                InspectionFile::create([
                    'fileable_id' => $inspection->id,
                    'fileable_type' => Inspection::class,
                    'file_name' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'file_type' => $file->getClientOriginalExtension(),
                    'mime_type' => $file->getMimeType(),
                    'file_size' => $file->getSize(),
                    'uploaded_by' => auth()->id(),
                ]);
            }
        }

        return redirect()->route('inspections.show', $inspection)
            ->with('success', 'Inspection updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inspection $inspection)
    {
        // Delete associated files
        foreach ($inspection->files as $file) {
            Storage::disk('public')->delete($file->file_path);
            $file->delete();
        }

        $inspection->delete();

        return redirect()->route('inspections.index')
            ->with('success', 'Inspection deleted successfully.');
    }

    /**
     * Delete a specific file from an inspection.
     */
    public function deleteFile(Inspection $inspection, InspectionFile $file)
    {
        // Ensure the file belongs to the inspection
        if ($file->fileable_id !== $inspection->id) {
            abort(404);
        }

        Storage::disk('public')->delete($file->file_path);
        $file->delete();

        return back()->with('success', 'File deleted successfully.');
    }

    /**
     * Export single inspection report as PDF
     */
    public function exportPdf(Inspection $inspection, PdfExportService $pdfService)
    {
        return $pdfService->downloadInspectionReport($inspection);
    }

    /**
     * Preview inspection report as PDF
     */
    public function previewPdf(Inspection $inspection, PdfExportService $pdfService)
    {
        return $pdfService->streamInspectionReport($inspection);
    }

    /**
     * Export inspections to Excel
     */
    public function exportExcel(Request $request, ExcelExportService $excelService)
    {
        $query = Inspection::with(['customer', 'equipment', 'inspector']);

        // Filter by inspector for technicians
        if (auth()->user()->isTechnician()) {
            $query->where('inspector_id', auth()->id());
        }

        // Apply same filters as index
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('inspection_type', 'like', "%{$search}%")
                  ->orWhereHas('customer', function ($q) use ($search) {
                      $q->where('company_name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('equipment', function ($q) use ($search) {
                      $q->where('equipment_type', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('result')) {
            $query->where('result', $request->result);
        }

        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        $filters = $request->only(['search', 'status', 'result', 'customer_id']);

        return $excelService->exportInspections($query, $filters);
    }

    /**
     * Export inspections summary as PDF
     */
    public function exportSummaryPdf(Request $request, PdfExportService $pdfService)
    {
        $query = Inspection::with(['customer', 'equipment', 'inspector']);

        // Filter by inspector for technicians
        if (auth()->user()->isTechnician()) {
            $query->where('inspector_id', auth()->id());
        }

        // Apply same filters as index
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('inspection_type', 'like', "%{$search}%")
                  ->orWhereHas('customer', function ($q) use ($search) {
                      $q->where('company_name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('equipment', function ($q) use ($search) {
                      $q->where('equipment_type', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('result')) {
            $query->where('result', $request->result);
        }

        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        $inspections = $query->latest('inspection_date')->get();
        $filters = $request->only(['search', 'status', 'result', 'customer_id']);

        return $pdfService->downloadSummaryReport($inspections, $filters);
    }
}
