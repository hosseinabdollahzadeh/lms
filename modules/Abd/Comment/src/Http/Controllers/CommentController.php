<?php
namespace Abd\Comment\Http\Controllers;

use Abd\Comment\Http\Requests\CommentRequest;
use Abd\Comment\Repositories\CommentRepo;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    public function index(CommentRepo $repo)
    {
        $comments = $repo->paginate();
        return view("Comments::index", compact('comments'));
    }
    public function store(CommentRequest $request, CommentRepo $repo)
    {
        $commentable = $request->commentable_type::findOrFail($request->commentable_id);
        $repo->store($request->all());
        newFeedback("عملیات موفقیت آمیز", "نظر شما ثبت شد.");
        return redirect($commentable->path());
    }
}
