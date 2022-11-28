<?php

namespace Abd\Discount\Providers;

use Abd\Discount\Listeners\UpdateUsedDiscountsForPayment;
use Abd\Payment\Events\PaymentWasSuccessful;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        PaymentWasSuccessful::class => [
            UpdateUsedDiscountsForPayment::class
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
