<?php

namespace Abd\User\Http\Requests;

use Abd\User\Rules\ValidPassword;
use Abd\User\Services\VerifyCodeService;
use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
            'password' => ['required', new ValidPassword(), 'confirmed']
        ];
    }
}
