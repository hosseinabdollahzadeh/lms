<?php

namespace Abd\Slider\Policies;

use Abd\RolePermissions\Models\Permission;
use Abd\User\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SlidePolicy
{
    use HandlesAuthorization;

    public function manage($user)
    {
        if($user->hasPermissionTo(Permission::PERMISSION_MANAGE_SLIDES)) return true;
    }
}
