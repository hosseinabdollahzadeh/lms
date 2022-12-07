<?php

namespace App\Providers;

use Abd\Comment\Events\CommentApprovedEvent;
use Abd\Comment\Events\CommentRejectedEvent;
use Abd\Comment\Events\CommentSubmittedEvent;
use Abd\Comment\Listeners\CommentApprovedListener;
use Abd\Comment\Listeners\CommentRejectedListener;
use Abd\Comment\Listeners\CommentSubmittedListener;
use Abd\Comment\Notifications\CommentApprovedNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        CommentSubmittedEvent::class => [
            CommentSubmittedListener::class
        ],
        CommentApprovedEvent::class => [
            CommentApprovedListener::class
        ],
        CommentRejectedEvent::class => [
            CommentRejectedListener::class
        ]
    ];

    public function boot() : void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
