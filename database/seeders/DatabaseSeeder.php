<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call the seeder for Spatie roles and permissions first
        $this->call(RolePermissionSeeder::class);

        // Then call the seeder that creates users and assigns them roles
        $this->call(UserSeeder::class);
    }
}
