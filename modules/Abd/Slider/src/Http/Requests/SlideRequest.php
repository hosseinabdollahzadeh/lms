<?php

namespace Abd\Slider\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SlideRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            "image" => "required|file|image",
            "priority" => "nullable|numeric|min:0",
            "status" => "required|boolean",
            "link" => "nullable|string|max:200"
        ];

        if(request()->method === 'PATCH'){
            $rules['image'] = 'nullable|file|image';
        }

        return $rules;
    }
}
