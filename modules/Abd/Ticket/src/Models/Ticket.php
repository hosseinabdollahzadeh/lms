<?php

namespace Abd\Ticket\Models;

use Abd\User\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

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
