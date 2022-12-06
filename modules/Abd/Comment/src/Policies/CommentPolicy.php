<?php

namespace Abd\Comment\Policies;

use Abd\RolePermissions\Models\Permission;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    public function manage($user)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COMMENTS)) return true;
    }

    public function index($user)
    {
        if ($user->hasAnyPermission(Permission::PERMISSION_MANAGE_COMMENTS, Permission::PERMISSION_TEACH)) return true;
    }

    public function view($user, $comment)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COMMENTS) ||
            $user->id == $comment->commentable->teacher_id) return true;
    }
}
