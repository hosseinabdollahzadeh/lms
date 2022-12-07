<?php

namespace Abd\Comment\Listeners;

use Abd\Comment\Notifications\CommentApprovedNotification;
use Abd\Comment\Notifications\CommentRejectedNotification;

class CommentRejectedListener
{
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle($event)
    {
        $event->comment->user->notify(new CommentRejectedNotification($event->comment));
    }
}
