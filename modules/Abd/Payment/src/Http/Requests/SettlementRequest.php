<?php

namespace Abd\Payment\Http\Requests;

use Abd\Payment\Models\Settlement;
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
        $min = 10000;
        if (request()->getMethod() === "PATCH") {
            return[
                "from.name" => 'required_if:status,'.Settlement::STATUS_SETTLED,
                "from.card" => 'required_if:status,'.Settlement::STATUS_SETTLED,
                "to.name" => 'required_if:status,'.Settlement::STATUS_SETTLED,
                "to.card" => 'required_if:status,'.Settlement::STATUS_SETTLED,
                "amount" => "required|numeric|min:{$min}"
            ];
        }
        return [
            "name" => "required",
            "card" => "required|numeric|digits:16",
            "amount" => "required|numeric|min:{$min}|max:" . auth()->user()->balance
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
