<?php

namespace Abd\User\Repositories;

use Abd\User\Models\User;

class UserRepo
{
    public function findByEmail($email)
    {
        return User::query()->where('email',$email)->firstOrFail();
    }

    public function getTeachers()
    {
        return User::permission('teach')->get();
    }

    public function findById($id)
    {
        return User::findOrFail($id);
    }
}
