<?php

namespace Abd\Payment\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettlementRequest extends FormRequest
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
            "name" => "required",
            "card" => "required|numeric|digits:16",
            "amount" => "required|numeric|max:". auth()->user()->balance
        ];
    }

    public function attributes()
    {
        return [
            "card" => "شماره کارت",
            "amount" => "مبلغ تسویه حساب"
        ];
    }
}
