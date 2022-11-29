<?php

namespace Abd\Ticket\Http\Requests;

use Abd\Course\Rules\ValidSeason;
use Abd\Media\Services\MediaFileService;
use Illuminate\Foundation\Http\FormRequest;

class TicketRequest extends FormRequest
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
            "body" => "required",
            "attachment" => "nullable|file|mimes:avi,mkv,mp4,zip,rar|max:102400"

        ];
    }

    public function attributes()
    {
        return[
            "title" => 'عنوان درس',
            "body" => 'متن تیکت',
            "attachment" => 'فایل پیوست',
        ];
    }
}
