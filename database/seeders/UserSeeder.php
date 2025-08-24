<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create an Admin User
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'), // Use a secure password
        ]);
        // Assign the 'admin' role to the user
        $admin->assignRole('admin');

        // Create a Donatur (Donor) User
        $donatur = User::create([
            'name' => 'Donatur',
            'email' => 'donatur@gmail.com',
            'password' => Hash::make('password'), // Use a secure password
        ]);
        // Assign the 'donatur' role to the user
        $donatur->assignRole('donatur');
    }
}
