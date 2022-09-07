<?php

namespace Abd\Course\Models;

use Abd\User\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    use HasFactory;
    const CONFIRMATION_STATUS_ACCEPTED = 'accepted';
    const CONFIRMATION_STATUS_REJECTED= 'rejected';
    const CONFIRMATION_STATUS_PENDING = 'pending';
    static $confirmationStatuses = [self::CONFIRMATION_STATUS_ACCEPTED, self::CONFIRMATION_STATUS_PENDING, self::CONFIRMATION_STATUS_REJECTED];

    protected $guarded=[];
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
