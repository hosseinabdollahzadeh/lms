<?php

namespace Abd\Discount\Policies;

use Abd\RolePermissions\Models\Permission;
use Abd\User\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DiscountPolicy
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

    public function manage(User $user)
    {
        if($user->hasPermissionTo(Permission::PERMISSION_MANAGE_DISCOUNTS)) return true;
    }
}
