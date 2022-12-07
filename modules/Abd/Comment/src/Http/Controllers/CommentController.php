<?php
namespace Abd\Comment\Http\Controllers;

use Abd\Comment\Events\CommentApprovedEvent;
use Abd\Comment\Events\CommentRejectedEvent;
use Abd\Comment\Events\CommentSubmittedEvent;
use Abd\Comment\Http\Requests\CommentRequest;
use Abd\Comment\Models\Comment;
use Abd\Comment\Repositories\CommentRepo;
use Abd\Common\Responses\AjaxResponses;
use Abd\Course\Models\Course;
use Abd\RolePermissions\Models\Permission;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    public function index(CommentRepo $repo)
    {
        $this->authorize('index', Comment::class);
        $comments = $repo
            ->searchBody(request("body"))
            ->searchEmail(request("email"))
            ->searchName(request("name"))
            ->searchStatus(request("status"));
//        if(!auth()->user()->hasAnyPermission([Permission::PERMISSION_MANAGE_COMMENTS, Permission::PERMISSION_SUPER_ADMIN])){ // this line OR bellow line
        if(!auth()->user()->can(Permission::PERMISSION_MANAGE_COMMENTS)){
            $comments->query->whereHasMorph('commentable', [Course::class], function ($query){
                return $query->where('teacher_id', auth()->id());
            })->where("status", Comment::STATUS_APPROVED);
        }
        $comments = $comments->paginateParents();
        return view("Comments::index", compact('comments'));
    }

    public function show($id)
    {
        $comment = Comment::query()->where("id", $id)->with("commentable", "user", "comments")->firstOrFail();
        $this->authorize('view', $comment);
        return view('Comments::show', compact('comment'));
    }
    public function store(CommentRequest $request, CommentRepo $repo)
    {
        $comment = $repo->store($request->all());
        event(new CommentSubmittedEvent($comment));
        newFeedback("عملیات موفقیت آمیز", "نظر شما ثبت شد.");
        return back();
    }

    public function accept($id, CommentRepo $repo)
    {
        $this->authorize('manage', Comment::class);
        $comment = $repo->findOrFail($id);
        if ($repo->updateStatus($id, Comment::STATUS_APPROVED)) {
            CommentApprovedEvent::dispatch($comment);
            return AjaxResponses::SuccessResponse();
        } else {
            return AjaxResponses::FailedResponse();
        }
    }

    public function reject($id, CommentRepo $repo)
    {
        $this->authorize('manage', Comment::class);
        $comment = $repo->findOrFail($id);
        if ($repo->updateStatus($id, Comment::STATUS_REJECTED)) {
            CommentRejectedEvent::dispatch($comment);
            return AjaxResponses::SuccessResponse();
        } else {
            return AjaxResponses::FailedResponse();
        }
    }

    public function destroy($id, CommentRepo $repo)
    {
        $this->authorize('manage', Comment::class);
        $comment = $repo->findOrFail($id);
        $comment->delete();
        return AjaxResponses::SuccessResponse();
    }
}
