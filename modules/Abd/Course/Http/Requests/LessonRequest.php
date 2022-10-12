<?php

namespace Abd\Course\Http\Requests;

use Abd\Course\Rules\ValidSeason;
use Abd\Media\Services\MediaFileService;
use Illuminate\Foundation\Http\FormRequest;

class LessonRequest extends FormRequest
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
            "slug" => 'nullable|min:3|max:190',
            "number" => 'nullable|numeric',
            "time" => 'required|numeric|min:0|max:255',
            "season_id" => [new ValidSeason()],
            "is_free" => "required|boolean",
            "lesson_file" => "required|file|mimes:".MediaFileService::getExtensions()

        ];
        if(request()->method === 'PATCH'){
            $rules['slug'] = 'nullable|min:3|max:190|unique:lessons,slug,'.request()->route('lesson');
            $rules['lesson_file'] = "nullable|file|mimes:".MediaFileService::getExtensions();
        }
        return $rules;
    }

    public function attributes()
    {
        return[
            "title" => 'عنوان درس',
            "slug" => 'عنوان انگلیسی درس',
            "number" => 'شماره ی درس',
            "time" => 'مدت زمان درس',
            "season_id" => 'شماره ی سرفصل',
            "free" => 'رایگان',
            "lesson_file" => 'فایل درس',
            "body" => 'توضیحات درس',
        ];
    }
}
