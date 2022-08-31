<?php

namespace Abd\User\Http\Controllers;

use Abd\RolePermissions\Repositories\RoleRepo;
use Abd\User\Repositories\UserRepo;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    private UserRepo $userRepo;

    public function __construct(UserRepo $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function index(RoleRepo $roleRepo)
    {
        $users = $this->userRepo->paginate();
        $roles = $roleRepo->all();
        return view('User::Admin.index', compact('users', 'roles'));
    }

}
