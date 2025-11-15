<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class OrganizationController extends Controller
{
    /**
     * Show the form for editing the organization.
     */
    public function edit()
    {
        $user = auth()->user();

        // Only organization admins and super admins can access
        if ($user->isTechnician()) {
            abort(403, 'Unauthorized action.');
        }

        $organization = $user->organization;

        return view('settings.organization', compact('organization'));
    }

    /**
     * Update the organization information.
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        // Only organization admins and super admins can access
        if ($user->isTechnician()) {
            abort(403, 'Unauthorized action.');
        }

        $organization = $user->organization;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($organization->logo) {
                Storage::disk('public')->delete($organization->logo);
            }

            $logoPath = $request->file('logo')->store('logos', 'public');
            $validated['logo'] = $logoPath;
        }

        // Generate slug if name changed
        if ($validated['name'] !== $organization->name) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $organization->update($validated);

        return redirect()->route('settings.organization.edit')
            ->with('success', 'Organization information updated successfully.');
    }

    /**
     * Remove the organization logo.
     */
    public function deleteLogo()
    {
        $user = auth()->user();

        // Only organization admins and super admins can access
        if ($user->isTechnician()) {
            abort(403, 'Unauthorized action.');
        }

        $organization = $user->organization;

        if ($organization->logo) {
            Storage::disk('public')->delete($organization->logo);
            $organization->update(['logo' => null]);
        }

        return redirect()->route('settings.organization.edit')
            ->with('success', 'Logo removed successfully.');
    }
}
