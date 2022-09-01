<?php

namespace Abd\User\Http\Controllers;

use Abd\Common\Responses\AjaxResponses;
use Abd\Media\Services\MediaFileService;
use Abd\RolePermissions\Repositories\RoleRepo;
use Abd\User\Http\Requests\AddRoleRequest;
use Abd\User\Http\Requests\UserUpdateRequest;
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

    public function edit($userId)
    {
        $this->authorize('edit', User::class);
        $user = $this->userRepo->findById($userId);
        return view('User::Admin.edit', compact('user'));
    }

    public function update($userId, UserUpdateRequest $request)
    {
        $this->authorize('edit', User::class);
        $user = $this->userRepo->findById($userId);
        if ($request->hasFile('image')) {
            $request->request->add(['image_id' => MediaFileService::upload($request->file('image'))->id]);
            if ($user->image) {
                $user->image->delete();
            }
        } else {
            $request->request->add(['image_id' => $user->image_id]);
        }
        $this->userRepo->update($userId, $request);
        newFeedback();
        return redirect()->back();
    }

    public function destroy($userId)
    {
        $this->authorize('delete', User::class);
        $user = $this->userRepo->findById($userId);
        $user->delete();
        return AjaxResponses::SuccessResponse();
    }

    public function manualVerify($userId)
    {
        $this->authorize('manualVerify', User::class);
        $user = $this->userRepo->findById($userId);
        $user->markEmailAsVerified();
        return AjaxResponses::SuccessResponse();
    }
}
