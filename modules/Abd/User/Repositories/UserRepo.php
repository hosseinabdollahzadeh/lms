<?php

namespace Abd\User\Repositories;

use Abd\RolePermissions\Models\Permission;
use Abd\User\Models\User;

class UserRepo
{
    public function findByEmail($email)
    {
        return User::query()->where('email', $email)->first();
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

    public function update($userId, $values)
    {
        $update = [
            'name' => $values->name,
            'email' => $values->email,
            'username' => $values->username,
            'mobile' => $values->mobile,
            'headline' => $values->headline,
            'telegram' => $values->telegram,
            'status' => $values->status,
            'image_id' => $values->image_id,
            'bio' => $values->bio,
        ];
        if (!is_null($values->password)) {
            $update['password'] = bcrypt($values->password);
        }

        $user = $this->findById($userId);
        $user->syncRoles([]);
        if ($values['role'])
            $user->assignRole($values['role']);
        return User::where('id', $userId)->update($update);
    }

    public function updateProfile($request)
    {
        auth()->user()->name = $request->name;
        auth()->user()->mobile = $request->mobile;
        if (auth()->user()->hasPermissionTo(Permission::PERMISSION_TEACH)) {
            auth()->user()->username = $request->username;
            auth()->user()->card_number = $request->card_number;
            auth()->user()->shaba = $request->shaba;
            auth()->user()->headline = $request->headline;
            auth()->user()->bio = $request->bio;
        }
        if ($request->password) {
            auth()->user()->password = bcrypt($request->password);
        }
        if (auth()->user()->email != $request->email) {
            auth()->user()->email = $request->email;
            auth()->user()->email_verified_at = null;
        }
        return auth()->user()->save();
    }

    public function findByIdFullInfo($id)
    {
        return User::query()
            ->with("settlements", "payments", "courses", "purchases")
            ->findOrFail($id);
    }
}
