<?php

namespace Abd\Payment\Providers;

use Abd\Course\Listeners\RegisterUserInTheCourse;
use Abd\Payment\Events\PaymentWasSuccessful;
use Abd\Payment\Listeners\AddSellerShareToHisAccount;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        PaymentWasSuccessful::class => [
            AddSellerShareToHisAccount::class
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
