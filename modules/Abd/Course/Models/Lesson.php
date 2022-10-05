<?php

namespace Abd\Course\Models;

use Abd\Media\Models\Media;
use Abd\User\Models\User;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $guarded=[];

    const CONFIRMATION_STATUS_ACCEPTED = 'accepted';
    const CONFIRMATION_STATUS_REJECTED= 'rejected';
    const CONFIRMATION_STATUS_PENDING = 'pending';
    static $confirmationStatuses = [self::CONFIRMATION_STATUS_ACCEPTED, self::CONFIRMATION_STATUS_PENDING, self::CONFIRMATION_STATUS_REJECTED];

    const STATUS_OPENED = 'opened';
    const STATUS_LOCKED = 'locked';
    static $statuses = [self::STATUS_OPENED, self::STATUS_LOCKED];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function media()
    {
        return $this->hasMany(Media::class);
    }
}
