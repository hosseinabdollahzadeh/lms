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
}
