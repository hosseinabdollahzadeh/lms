<?php

namespace Abd\Ticket\Repositories;

use Abd\Ticket\Models\Ticket;
use Illuminate\Database\Eloquent\Model;

class TicketRepo
{
    public function paginateAll()
    {
        return Ticket::query()->latest()->paginate();
    }

    public function store($title) : Model
    {
        return Ticket::query()->create([
            "title" => $title,
            "user_id" => auth()->id()
        ]);
    }
}
