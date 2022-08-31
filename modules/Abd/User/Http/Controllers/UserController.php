<?php

namespace Abd\User\Http\Controllers;

use Abd\Common\Responses\AjaxResponses;
use Abd\RolePermissions\Repositories\RoleRepo;
use Abd\User\Http\Requests\AddRoleRequest;
use Abd\User\Models\User;
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
        $this->authorize('index', User::class);
        $users = $this->userRepo->paginate();
        $roles = $roleRepo->all();
        return view('User::Admin.index', compact('users', 'roles'));
    }

    public function addRole(AddRoleRequest $request, User $user)
    {
        $this->authorize('addRole', User::class);
        $user->assignRole($request->role);
        newFeedback("عملیات موفقیت آمیز", "نقش کاربری $request->role به کاربر $user->name داده شد.", "success");
        return back();
    }
    public function removeRole($userId, $role)
    {
        $this->authorize('removeRole', User::class);
        $user = $this->userRepo->findById($userId);
        $user->removeRole($role);
        return AjaxResponses::SuccessResponse();
    }
}
