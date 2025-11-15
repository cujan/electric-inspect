<?php

use App\Http\Controllers\Settings;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('dashboard', function () {
    $user = auth()->user();

    if ($user->isSuperAdmin()) {
        $stats = [
            'customers' => \App\Models\Customer::count(),
            'equipment' => \App\Models\Equipment::count(),
            'inspections' => \App\Models\Inspection::count(),
            'upcoming' => \App\Models\Inspection::where('inspection_date', '>', now())
                ->where('status', 'scheduled')
                ->count(),
        ];
    } elseif ($user->isTechnician()) {
        // Technicians only see their assigned inspections
        $stats = [
            'customers' => \App\Models\Customer::where('organization_id', $user->organization_id)->count(),
            'equipment' => \App\Models\Equipment::where('organization_id', $user->organization_id)->count(),
            'inspections' => \App\Models\Inspection::where('inspector_id', $user->id)->count(),
            'upcoming' => \App\Models\Inspection::where('inspector_id', $user->id)
                ->where('inspection_date', '>', now())
                ->where('status', 'scheduled')
                ->count(),
        ];
    } else {
        // Organization admins see all organization inspections
        $stats = [
            'customers' => \App\Models\Customer::where('organization_id', $user->organization_id)->count(),
            'equipment' => \App\Models\Equipment::where('organization_id', $user->organization_id)->count(),
            'inspections' => \App\Models\Inspection::where('organization_id', $user->organization_id)->count(),
            'upcoming' => \App\Models\Inspection::where('organization_id', $user->organization_id)
                ->where('inspection_date', '>', now())
                ->where('status', 'scheduled')
                ->count(),
        ];
    }

    return view('dashboard', compact('stats'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'tenant'])->group(function () {
    // Customer routes
    Route::resource('customers', App\Http\Controllers\CustomerController::class);

    // Equipment routes
    Route::resource('equipment', App\Http\Controllers\EquipmentController::class);

    // Inspection routes
    Route::resource('inspections', App\Http\Controllers\InspectionController::class);
    Route::delete('inspections/{inspection}/files/{file}', [App\Http\Controllers\InspectionController::class, 'deleteFile'])
        ->name('inspections.files.delete');

    // Inspection export routes
    Route::get('inspections/{inspection}/export-pdf', [App\Http\Controllers\InspectionController::class, 'exportPdf'])
        ->name('inspections.export.pdf');
    Route::get('inspections/{inspection}/preview-pdf', [App\Http\Controllers\InspectionController::class, 'previewPdf'])
        ->name('inspections.preview.pdf');
    Route::get('inspections-export/excel', [App\Http\Controllers\InspectionController::class, 'exportExcel'])
        ->name('inspections.export.excel');
    Route::get('inspections-export/summary-pdf', [App\Http\Controllers\InspectionController::class, 'exportSummaryPdf'])
        ->name('inspections.export.summary.pdf');

    // User/Technician management routes (only for admins)
    Route::resource('users', App\Http\Controllers\UserController::class);
});

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', [Settings\ProfileController::class, 'edit'])->name('settings.profile.edit');
    Route::put('settings/profile', [Settings\ProfileController::class, 'update'])->name('settings.profile.update');
    Route::delete('settings/profile', [Settings\ProfileController::class, 'destroy'])->name('settings.profile.destroy');
    Route::get('settings/password', [Settings\PasswordController::class, 'edit'])->name('settings.password.edit');
    Route::put('settings/password', [Settings\PasswordController::class, 'update'])->name('settings.password.update');
    Route::get('settings/appearance', [Settings\AppearanceController::class, 'edit'])->name('settings.appearance.edit');

    // Organization settings (only for admins)
    Route::get('settings/organization', [Settings\OrganizationController::class, 'edit'])->name('settings.organization.edit');
    Route::put('settings/organization', [Settings\OrganizationController::class, 'update'])->name('settings.organization.update');
    Route::delete('settings/organization/logo', [Settings\OrganizationController::class, 'deleteLogo'])->name('settings.organization.logo.delete');
});

require __DIR__.'/auth.php';
