<?php

namespace Abd\Comment\Listeners;

use Abd\Comment\Notifications\CommentSubmittedNotification;

class CommentSubmittedListener
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
        // notify comment owner
//        if($event->comment->comment_id && $event->comment->user_id != $event->comment->comment->user->id)
//            $event->comment->comment->user->notify(new CommentSubmittedNotification($event->comment));
    }
}
