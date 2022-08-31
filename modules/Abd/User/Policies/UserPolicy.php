<?php

namespace Abd\User\Policies;

use Abd\RolePermissions\Models\Permission;
use Illuminate\Auth\Access\HandlesAuthorization;
use phpDocumentor\Reflection\Types\True_;

class UserPolicy
{
    use HandlesAuthorization;

    public function index($user)
    {
        if($user->hasPermissionTo(Permission::PERMISSION_MANAGE_USERS)){
            return true;
        }
    }
    public function addRole($user)
    {
        if($user->hasPermissionTo(Permission::PERMISSION_MANAGE_USERS)){
            return true;
        }
    }
}
