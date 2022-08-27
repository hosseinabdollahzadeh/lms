<?php

namespace Abd\Course\Http\Requests;

use Abd\Course\Rules\ValidTeacher;
use Abd\Course\Models\Course;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CourseRequest extends FormRequest
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
            "title" => 'required|min:3|max:190',
            "slug" => 'required|min:3|max:190|unique:courses,slug',
            "priority" => 'nullable|numeric',
            "price" => 'required|numeric|min:0|max:10000000',
            "percent" => 'required|numeric|max:100',
            "teacher_id" => ['required','exists:users,id', new ValidTeacher()],
            "type" => ["required", Rule::in(Course::$types)],
            "status" => ["required", Rule::in(Course::$statuses)],
            "category_id" => 'required|exists:categories,id',
            "image" => 'required|mimes:jpg,png,jpeg',
        ];
        if(request()->method === 'PATCH'){
            $rules['slug'] = 'required|min:3|max:190|unique:courses,slug,'.request()->route('course');
            $rules['image'] = 'nullable|mimes:jpg,png,jpeg';
        }
        return $rules;
    }

    public function attributes()
    {
        return[
            "title" => "عنوان دوره",
            "slug" => "عنوان انگلیسی دوره",
            "priority" => "ردیف دوره",
            "price" => "قیمت",
            "percent" => "درصد مدرس",
            "teacher_id" => "مدرس",
            "type" => "نوع",
            "status" => "وضعیت",
            "category_id" => "دستهب بندی",
            "image" => "بنر دوره",
            "body" => "توضیحات"
        ];
    }

    public function messages()
    {
        return[

        ];
    }
}
