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
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $event->comment->commentable->teacher->notify(new CommentSubmittedNotification($event->comment));
    }
}
