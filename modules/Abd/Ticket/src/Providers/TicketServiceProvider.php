<?php

namespace Abd\Ticket\Providers;

use Illuminate\Support\ServiceProvider;

class TicketServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
    }

    public function boot()
    {

    }
}
