<?php

namespace Abd\Ticket\Repositories;

use Abd\Ticket\Models\Ticket;

class TicketRepo
{
    public function paginateAll()
    {
        return Ticket::query()->latest()->paginate();
    }

    public function store($title)
    {
        return Ticket::query()->create([
            "title" => $title,
            "user_id" => auth()->id()
        ]);
    }
}
