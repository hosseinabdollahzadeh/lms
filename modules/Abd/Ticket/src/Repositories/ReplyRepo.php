<?php

namespace Abd\Ticket\Repositories;


use Abd\Ticket\Models\Reply;

class ReplyRepo
{
    public function store($ticketId, $body, $mediaId=null)
    {
        return Reply::query()->create([
            "user_id" => auth()->id(),
            "ticket_id" => $ticketId,
            "media_id" => $mediaId,
            "body" => $body
        ]);
    }
}
