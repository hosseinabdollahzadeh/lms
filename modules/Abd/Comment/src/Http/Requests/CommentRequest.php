<?php

namespace Abd\Comment\Http\Requests;

use Abd\Comment\Rules\ApprovedCommentRule;
use Abd\Comment\Rules\CommentableRule;
use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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
            'body' => 'required',
            'commentable_id' => 'required',
            'comment_id' => ["nullable", new ApprovedCommentRule()],
            'commentable_type' => ['required', new CommentableRule()],
        ];
    }
}
