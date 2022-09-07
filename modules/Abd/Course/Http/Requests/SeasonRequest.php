<?php

namespace Abd\Course\Http\Requests;

use Abd\Course\Rules\ValidTeacher;
use Abd\Course\Models\Course;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SeasonRequest extends FormRequest
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
            "title" => 'required|min:3|max:190',
            "number" => 'nullable|numeric|min:0|max:250',
        ];
    }

    public function attributes()
    {
        return[
            "title" => "عنوان فصل",
            "number" => "شماره فصل",
        ];
    }
}
