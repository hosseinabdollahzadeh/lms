<?php

namespace Abd\Course\Policies;

use Abd\RolePermissions\Models\Permission;
use Abd\User\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SeasonPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function edit($user, $season)
    {
        if($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES)){
            return true;
        }
        if(($user->hasPermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES) && $season->course->teacher_id == $user->id)){
            return true;
        }
    }

    public function delete($user, $season)
    {
        if($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES)){
            return true;
        }
        if(($user->hasPermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES) && $season->course->teacher_id == $user->id)){
            return true;
        }
    }
    public function change_confirmation_status($user)
    {
        if($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES)){
            return true;
        }
    }
}
