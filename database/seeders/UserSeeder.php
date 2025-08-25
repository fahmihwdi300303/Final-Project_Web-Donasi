<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create the Admin user
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@lksa.org',
            'password' => Hash::make('admin123'),
        ]);
        // Assign the 'admin' role using the Spatie package
        $admin->assignRole('admin');

        // Create a Donatur (Donor) user for testing
        $donatur = User::create([
            'name' => 'Donatur',
            'email' => 'donatur@lksa.org',
            'password' => Hash::make('donatur123'),
        ]);
        // Assign the 'donatur' role using the Spatie package
        $donatur->assignRole('donatur');
    }
}
