<?php

namespace Abd\User\Http\Controllers;

use Abd\Common\Responses\AjaxResponses;
use Abd\Media\Models\Media;
use Abd\Media\Services\MediaFileService;
use Abd\RolePermissions\Repositories\RoleRepo;
use Abd\User\Http\Requests\AddRoleRequest;
use Abd\User\Http\Requests\UpdateProfileInformationRequest;
use Abd\User\Http\Requests\UpdateUserPhotoRequest;
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

    public function info($userId, UserRepo $repo)
    {
        $this->authorize('index', User::class);
        $user = $repo->findByIdFullInfo($userId);
        return view('User::Admin.info', compact('user'));
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

    public function edit($userId, RoleRepo $roleRepo)
    {
        $this->authorize('edit', User::class);
        $user = $this->userRepo->findById($userId);
        $roles = $roleRepo->all();
        return view('User::Admin.edit', compact('user', 'roles'));
    }

    public function update($userId, UserUpdateRequest $request)
    {
        $this->authorize('edit', User::class);
        $user = $this->userRepo->findById($userId);
        if ($request->hasFile('image')) {
            $request->request->add(['image_id' => MediaFileService::publicUpload($request->file('image'))->id]);
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

    public function updatePhoto(UpdateUserPhotoRequest $request)
    {
        $this->authorize('editProfile', User::class);
        $media = MediaFileService::publicUpload($request->file('userPhoto'));
        if(auth()->user()->image) auth()->user()->image->delete();
        auth()->user()->image_id = $media->id;
        auth()->user()->save();

        newFeedback();
        return back();
    }

    public function profile()
    {
        $this->authorize('editProfile', User::class);
        return view('User::Admin.profile');
    }

    public function updateProfile(UpdateProfileInformationRequest $request)
    {
        $this->authorize('editProfile', User::class);
        $this->userRepo->updateProfile($request);
        newFeedback();
        return back();
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
