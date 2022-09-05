<?php

namespace Abd\User\Http\Requests;

use Abd\RolePermissions\Models\Permission;
use Abd\User\Rules\ValidMobile;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileInformationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() == true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            "name" => 'required|min:3|max:190',
            "email" => 'required|email|min:3|max:190|unique:users,email,'.auth()->id(),
            "username" => 'nullable|min:3|max:190|unique:users,username,'.auth()->id(),
            "mobile" => ['nullable', 'min:9', 'max:14', 'unique:users,mobile,'.auth()->id(), new ValidMobile()],
            "password" => ['nullable', new ValidMobile()]
        ];
        if(auth()->user()->hasPermissionTo(Permission::PERMISSION_TEACH)){
            $rules += [
                "card_number" => 'required|string|size:16',
                "shaba" => "required|string|size:24",
                "headline" => "required|string|min:3|max:60",
                "bio" => "required",
            ];
            $rules["username"] = 'required|min:3|max:190|unique:users,username,'.auth()->id();
        }
        return $rules;
    }

    public function attributes()
    {
        return [
            "name" => "نام و نام خانوادگی",
            "email" => "ایمیل",
            "username" => "نام کاربری",
            "password" => "رمز عبور جدید",
            "mobile" => "موبایل",
            "card_number" => "شماره کارت بانکی",
            "shaba" => "شماره شبای بانکی",
            "headline" => "عنوان",
            "bio" => "بیو",
        ];
    }
}
