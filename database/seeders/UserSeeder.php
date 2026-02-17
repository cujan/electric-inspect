<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create default organization
        $organization = Organization::firstOrCreate([
            'name' => 'Default Organization',
        ], [
            'slug' => 'default',
            'is_active' => true,
        ]);

        // Create super admin user (no organization)
        if (!User::where('email', 'admin@test.sk')->exists()) {
            User::create([
                'organization_id' => null,
                'name' => 'Super Admin',
                'email' => 'admin@test.sk',
                'password' => bcrypt('password123'),
                'role' => 'super_admin',
                'certificate_number' => 'ADMIN001',
            ]);
        }

        // Create organization admin user
        if (!User::where('email', 'test@test.sk')->exists()) {
            User::create([
                'organization_id' => $organization->id,
                'name' => 'Testovací Užívateľ',
                'email' => 'test@test.sk',
                'password' => bcrypt('password123'),
                'role' => 'organization_admin',
                'certificate_number' => 'TEST001',
            ]);
        }

        // Create technician user
        if (!User::where('email', 'technician@test.sk')->exists()) {
            User::create([
                'organization_id' => $organization->id,
                'name' => 'Technik',
                'email' => 'technician@test.sk',
                'password' => bcrypt('password123'),
                'role' => 'technician',
                'certificate_number' => 'TECH001',
            ]);
        }
    }
}
