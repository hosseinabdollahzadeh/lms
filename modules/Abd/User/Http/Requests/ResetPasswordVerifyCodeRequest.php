<?php

namespace Abd\User\Http\Requests;

use Abd\User\Services\VerifyCodeService;
use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordVerifyCodeRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'verify_code'=> VerifyCodeService::getRul(),
            'email' => 'required|email'
        ];
    }
}
