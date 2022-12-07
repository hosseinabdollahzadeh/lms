<?php

namespace Abd\Comment\Listeners;

use Abd\Comment\Notifications\CommentApprovedNotification;
use Abd\Comment\Notifications\CommentSubmittedNotification;

class CommentApprovedListener
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
        // notify teacher
        if ($event->comment->user_id != $event->comment->commentable->teacher->id)
            $event->comment->commentable->teacher->notify(new CommentSubmittedNotification($event->comment));

        // notify comment owner
        if ($event->comment->comment_id && $event->comment->user_id != $event->comment->comment->user->id)
            $event->comment->comment->user->notify(new CommentSubmittedNotification($event->comment));

        $event->comment->user->notify(new CommentApprovedNotification($event->comment));

    }
}
