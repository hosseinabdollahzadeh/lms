<?php

namespace Abd\Payment\Models;

use Abd\User\Models\User;
use Illuminate\Database\Eloquent\Model;

class Settlement extends Model
{
    protected $guarded = [];

    const STATUS_PENDING = 'pending';
    const STATUS_SETTLED = 'settled';
    const STATUS_REJECTED = 'rejected';
    const STATUS_CANCELLED = 'cancelled';

    public static $statuses = [
        self::STATUS_PENDING,
        self::STATUS_SETTLED,
        self::STATUS_REJECTED,
        self::STATUS_CANCELLED
    ];

    protected $casts =[
        "to" => "json",
        "from" => "json"
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
