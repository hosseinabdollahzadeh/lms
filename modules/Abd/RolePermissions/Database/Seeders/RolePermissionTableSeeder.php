<?php

namespace Abd\RolePermissions\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::findOrCreate('manage categories');
        Permission::findOrCreate('manage role_permissions');
        Permission::findOrCreate('teach');

        Role::findOrCreate('teacher')->givePermissionTo('teach');
    }
}
