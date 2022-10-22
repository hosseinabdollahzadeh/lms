<?php

namespace Abd\Course\Policies;

use Abd\RolePermissions\Models\Permission;
use Illuminate\Auth\Access\HandlesAuthorization;

class LessonPolicy
{
    use HandlesAuthorization;

    public function edit($user, $lesson)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES) ||
            ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES) && $lesson->course->teacher_id == $user->id)
        ) {
            return true;
        }
    }

    public function delete($user, $lesson)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES) ||
            ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES) && $lesson->course->teacher_id == $user->id)
        ) {
            return true;
        }
    }

    public function download($user, $lesson)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES) ||
            $user->id === $lesson->course->teacher_id ||
            $lesson->course->hasStudent($user->id) ||
            $lesson->is_free
        )
            return true;
        return false;
    }
}
