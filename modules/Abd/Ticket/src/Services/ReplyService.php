<?php

namespace Abd\Ticket\Services;

use Abd\Media\Services\MediaFileService;
use Abd\Ticket\Models\Ticket;
use Abd\Ticket\Repositories\ReplyRepo;
use Illuminate\Http\UploadedFile;

class ReplyService
{
    public static function store(Ticket $ticket, $reply, $attachment)
    {
        $repo = new ReplyRepo();
        $media_id = null;
        if ($attachment && ($attachment instanceof UploadedFile)){
            $media_id = MediaFileService::privateUpload($attachment)->id;
        }
        return $repo->store($ticket->id, $reply, $media_id);
    }
}
