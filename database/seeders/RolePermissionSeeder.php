<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Permissions
        Permission::create(['name' => 'view-dashboard']);
        Permission::create(['name' => 'manage-donations']);
        Permission::create(['name' => 'manage-users']);

        // Create Roles and assign existing permissions
        $donaturRole = Role::create(['name' => 'donatur']);
        $donaturRole->givePermissionTo([
            'view-dashboard',
            'manage-donations'
        ]);

        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo([
            'view-dashboard',
            'manage-donations',
            'manage-users'
        ]);
    }
}
