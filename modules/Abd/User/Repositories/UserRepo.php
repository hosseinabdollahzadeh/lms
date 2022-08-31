<?php

namespace Abd\User\Repositories;

use Abd\RolePermissions\Models\Permission;
use Abd\User\Models\User;

class UserRepo
{
    public function findByEmail($email)
    {
        return User::query()->where('email',$email)->first();
    }

    public function getTeachers()
    {
        return User::permission(Permission::PERMISSION_TEACH)->get();
    }

    public function findById($id)
    {
        return User::findOrFail($id);
    }

    public function paginate()
    {
        return User::paginate();
    }
}
