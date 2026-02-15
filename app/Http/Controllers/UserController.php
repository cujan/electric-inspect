<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Display a listing of technicians.
     */
    public function index()
    {
        $user = auth()->user();

        // Only organization admins and super admins can access
        if ($user->isTechnician()) {
            abort(403, 'Unauthorized action.');
        }

        // Get technicians for the organization
        if ($user->isSuperAdmin()) {
            $technicians = User::where('role', 'technician')
                ->with('organization')
                ->orderBy('name')
                ->paginate(15);
        } else {
            $technicians = User::where('organization_id', $user->organization_id)
                ->where('role', 'technician')
                ->orderBy('name')
                ->paginate(15);
        }

        return view('users.index', compact('technicians'));
    }

    /**
     * Show the form for creating a new technician.
     */
    public function create()
    {
        $user = auth()->user();

        // Only organization admins and super admins can access
        if ($user->isTechnician()) {
            abort(403, 'Unauthorized action.');
        }

        return view('users.create');
    }

    /**
     * Store a newly created technician in storage.
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        // Only organization admins and super admins can access
        if ($user->isTechnician()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'certificate_number' => ['nullable', 'string', 'max:255', 'unique:users'],
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['organization_id'] = $user->organization_id;
        $validated['role'] = 'technician';

        User::create($validated);

        return redirect()->route('users.index')
            ->with('success', __('Technician created successfully.'));
    }

    /**
     * Display the specified technician.
     */
    public function show(User $user)
    {
        $currentUser = auth()->user();

        // Only organization admins and super admins can access
        if ($currentUser->isTechnician()) {
            abort(403, 'Unauthorized action.');
        }

        // Ensure admin can only view their organization's technicians
        if (!$currentUser->isSuperAdmin() && $user->organization_id !== $currentUser->organization_id) {
            abort(403, 'Unauthorized action.');
        }

        // Get inspection statistics for the technician
        $stats = [
            'total_inspections' => $user->inspections()->count(),
            'completed' => $user->inspections()->where('status', 'completed')->count(),
            'in_progress' => $user->inspections()->where('status', 'in_progress')->count(),
            'upcoming' => $user->inspections()
                ->where('status', 'scheduled')
                ->where('inspection_date', '>', now())
                ->count(),
        ];

        return view('users.show', compact('user', 'stats'));
    }

    /**
     * Show the form for editing the specified technician.
     */
    public function edit(User $user)
    {
        $currentUser = auth()->user();

        // Only organization admins and super admins can access
        if ($currentUser->isTechnician()) {
            abort(403, 'Unauthorized action.');
        }

        // Ensure admin can only edit their organization's technicians
        if (!$currentUser->isSuperAdmin() && $user->organization_id !== $currentUser->organization_id) {
            abort(403, 'Unauthorized action.');
        }

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified technician in storage.
     */
    public function update(Request $request, User $user)
    {
        $currentUser = auth()->user();

        // Only organization admins and super admins can access
        if ($currentUser->isTechnician()) {
            abort(403, 'Unauthorized action.');
        }

        // Ensure admin can only update their organization's technicians
        if (!$currentUser->isSuperAdmin() && $user->organization_id !== $currentUser->organization_id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'certificate_number' => ['nullable', 'string', 'max:255', 'unique:users,certificate_number,' . $user->id],
        ]);

        // Only update password if provided
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('users.index')
            ->with('success', __('Technician updated successfully.'));
    }

    /**
     * Remove the specified technician from storage.
     */
    public function destroy(User $user)
    {
        $currentUser = auth()->user();

        // Only organization admins and super admins can access
        if ($currentUser->isTechnician()) {
            abort(403, 'Unauthorized action.');
        }

        // Ensure admin can only delete their organization's technicians
        if (!$currentUser->isSuperAdmin() && $user->organization_id !== $currentUser->organization_id) {
            abort(403, 'Unauthorized action.');
        }

        // Prevent deleting if technician has inspections
        if ($user->inspections()->count() > 0) {
            return redirect()->route('users.index')
                ->with('error', __('Cannot delete technician with existing inspections.'));
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', __('Technician deleted successfully.'));
    }
}
