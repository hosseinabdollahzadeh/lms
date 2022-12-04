<?php

namespace Abd\Comment\Repositories;

use Abd\Comment\Models\Comment;
use Abd\RolePermissions\Models\Permission;

class CommentRepo
{

    public function store($data)
    {
        return Comment::query()->create([
            "user_id" => auth()->id(),
            "status" => (auth()->user()->can(Permission::PERMISSION_MANAGE_COMMENTS) ||
                auth()->user()->can(Permission::PERMISSION_TEACH))
                ?
                Comment::STATUS_APPROVED
                :
                Comment::STATUS_NEW,
            "comment_id" => array_key_exists("comment_id", $data) ? $data['comment_id'] : null,
            "body" => $data["body"],
            "commentable_id" => $data["commentable_id"],
            "commentable_type" => $data["commentable_type"],
        ]);
    }

    public function findApproved($id)
    {
        return Comment::query()
            ->where("id", $id)
            ->where("status", Comment::STATUS_APPROVED)
            ->first();
    }

    public function findOrFail($id)
    {
        return Comment::query()->findOrFail($id);
    }

    public function paginate()
    {
        return Comment::query()->latest()->paginate();
    }


    public function paginateParents()
    {
        return Comment::query()->whereNull('comment_id')->withCount("notApprovedComments")->latest()->paginate();
    }
}
