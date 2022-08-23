<?php

namespace Abd\RolePermissions\Repositories;

use Spatie\Permission\Models\Permission;

class PermissionRepo
{
    public static function all()
    {
        return Permission::all();
    }
}
