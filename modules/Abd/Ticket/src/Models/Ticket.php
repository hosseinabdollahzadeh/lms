<?php

namespace Abd\Ticket\Models;

use Abd\User\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    const STATUS_OPEN = 'open';
    const STATUS_CLOSE = 'close';
    const STATUS_PENDING = 'pending';
    const STATUS_REPLIED = 'replied';

    public static $statuses=[
        self::STATUS_OPEN,
        self::STATUS_CLOSE,
        self::STATUS_PENDING,
        self::STATUS_REPLIED
    ];
    protected $guarded = [];
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function ticketable()
    {
       return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
