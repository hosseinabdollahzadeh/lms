<?php

namespace Abd\User\Http\Requests;

use Abd\Course\Rules\ValidTeacher;
use Abd\User\Models\User;
use Abd\User\Rules\ValidMobile;
use Abd\User\Rules\ValidPassword;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
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
        return [
            "name" => 'required|min:3|max:190',
            "email" => 'required|email|min:3|max:190|unique:users,email,'.request()->route('user'),
            "username" => 'nullable|min:3|max:190|unique:users,username,'.request()->route('user'),
            "mobile" => ['nullable', 'min:9', 'max:14', 'unique:users,mobile,'.request()->route('user'), new ValidMobile()],
            "status" => ["required", Rule::in(User::$statuses)],
            "image" => 'nullable|mimes:jpg,png,jpeg',
//            "password" =>['nullable', 'string', new ValidPassword()],
        ];
    }

    public function attributes()
    {
        return[
            "name" => "نام",
            "email" => "ایمیل",
            "username" => "نام کاربری",
            "mobile" => "موبایل",
            "password" => "پسورد",
            "headline" => "عنوان کاربر",
            "image" => "عکس پروفایل",
            "bio" => "بایو"
        ];
    }

}
