<?php

namespace Abd\Ticket\Providers;

use Abd\RolePermissions\Models\Permission;
use Abd\Ticket\Models\Reply;
use Abd\Ticket\Models\Ticket;
use Abd\Ticket\Policies\ReplyPolicy;
use Abd\Ticket\Policies\TicketPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class TicketServiceProvider extends ServiceProvider
{
    public $namespace = "Abd\Ticket\Http\Controllers";
    public function register()
    {
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
        $this->loadViewsFrom(__DIR__.'/../Resources/Views', 'Tickets');
        $this->loadJsonTranslationsFrom(__DIR__.'/../Resources/Lang');
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(__DIR__ . '/../Routes/tickets_routes.php');
        Gate::policy(Ticket::class, TicketPolicy::class);
        Gate::policy(Reply::class,ReplyPolicy::class);
    }

    public function boot()
    {
        $this->app->booted(function () {
            config()->set('sidebar.items.tickets', [
                "icon" => "i-tickets",
                "title" => "تیکت های پشتیبانی",
                "url" => route('tickets.index'),
            ]);
        });
    }
}
