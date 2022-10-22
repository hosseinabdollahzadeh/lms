<?php

namespace Abd\Course\Providers;

use Abd\Course\Listeners\RegisterUserInTheCourse;
use Abd\Payment\Events\PaymentWasSuccessful;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        PaymentWasSuccessful::class => [
            RegisterUserInTheCourse::class
        ]
    ];

    public function boot()
    {
        //
    }

    public function shouldDiscoverEvents()
    {
        return false;
    }
}
