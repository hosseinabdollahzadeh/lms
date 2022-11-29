<?php

namespace Abd\Ticket\Policies;

use Abd\RolePermissions\Models\Permission;
use Illuminate\Auth\Access\HandlesAuthorization;

class TicketPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        //
    }

    public function show($user, $ticket)
    {
        if (($user->id == $ticket->user_id) ||
            ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_TICKETS))) return true;
    }

    public function delete($user, $ticket)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_TICKETS)) return true;
    }
}
