<?php

namespace Abd\User\Repositories;

use Abd\User\Models\User;

class UserRepo
{
    public function findByEmail($email)
    {
        return User::query()->where('email',$email)->first();
    }

    public function getTeachers()
    {
        return User::permission('teach')->get();
    }
}
