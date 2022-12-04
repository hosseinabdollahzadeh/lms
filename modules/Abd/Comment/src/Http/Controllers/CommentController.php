<?php
namespace Abd\Comment\Http\Controllers;

use Abd\Comment\Http\Requests\CommentRequest;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    public function store(CommentRequest $request)
    {
        $commentable = $request->commentable_type::findOrFail($request->commentable_id);
        return $commentable;
    }
}
