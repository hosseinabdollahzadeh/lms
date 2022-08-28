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
        foreach (\Abd\RolePermissions\Models\Permission::$permissions as $permission){
        Permission::findOrCreate($permission);
        }

        foreach (\Abd\RolePermissions\Models\Role::$roles as $name=>$permission){

        Role::findOrCreate($name)->givePermissionTo($permission);
        }
    }
}
