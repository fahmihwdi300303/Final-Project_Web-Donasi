<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        DB::table('users')->insert([
            'name' => 'akbar admin',
            'email' => 'admin@lksa.org',
            'password' => Hash::make('admin123'), // ubah sesuai kebutuhan
            'role_id' => 1, // role_id = admin
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Donatur
        DB::table('users')->insert([
            'name' => 'Donatur puja',
            'email' => 'donatur@lksa.org',
            'password' => Hash::make('donatur123'), // ubah sesuai kebutuhan
            'role_id' => 2, // role_id = donatur
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
