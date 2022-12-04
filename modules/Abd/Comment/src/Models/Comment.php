<?php

namespace Abd\Comment\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    const STATUS_NEW = "new";
    const STATUS_APPROVED = "approved";
    const STATUS_REJECTED = "rejected";
    public static $statuses = [
        self::STATUS_NEW,
        self::STATUS_APPROVED,
        self::STATUS_REJECTED
    ];

    public function commentable()
    {
        return $this->morphTo();
    }
}
