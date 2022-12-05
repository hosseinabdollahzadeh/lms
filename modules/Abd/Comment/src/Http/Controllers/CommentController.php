<?php
namespace Abd\Comment\Http\Controllers;

use Abd\Comment\Http\Requests\CommentRequest;
use Abd\Comment\Models\Comment;
use Abd\Comment\Repositories\CommentRepo;
use Abd\Common\Responses\AjaxResponses;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    public function index(CommentRepo $repo)
    {
        $comments = $repo->paginateParents();
        return view("Comments::index", compact('comments'));
    }

    public function show($id)
    {
        $comment = Comment::query()->where("id", $id)->with("commentable", "user", "comments")->firstOrFail();
        return view('Comments::show', compact('comment'));
    }
    public function store(CommentRequest $request, CommentRepo $repo)
    {
        $commentable = $request->commentable_type::findOrFail($request->commentable_id);
        $repo->store($request->all());
        newFeedback("عملیات موفقیت آمیز", "نظر شما ثبت شد.");
        return redirect($commentable->path());
    }

    public function accept($id, CommentRepo $repo)
    {
        if ($repo->updateStatus($id, Comment::STATUS_APPROVED)) {
            return AjaxResponses::SuccessResponse();
        } else {
            return AjaxResponses::FailedResponse();
        }
    }

    public function reject($id, CommentRepo $repo)
    {
        if ($repo->updateStatus($id, Comment::STATUS_REJECTED)) {
            return AjaxResponses::SuccessResponse();
        } else {
            return AjaxResponses::FailedResponse();
        }
    }

    public function destroy($id, CommentRepo $repo)
    {
        $comment = $repo->findOrFail($id);
        $comment->delete();
        AjaxResponses::SuccessResponse();
    }
}
