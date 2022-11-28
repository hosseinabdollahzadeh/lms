<?php

namespace Abd\Discount\Providers;

use Abd\Discount\Models\Discount;
use Abd\Discount\Policies\DiscountPolicy;
use Abd\RolePermissions\Models\Permission;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class DiscountServiceProvider extends ServiceProvider
{
    public $namespace = "Abd\Discount\Http\Controllers";
    public function register()
    {
        $this->app->register(EventServiceProvider::class);
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(__DIR__ . '/../Routes/discounts_routes.php');
        $this->loadViewsFrom(__DIR__.'/../Resources/Views', 'Discounts');
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
        $this->loadJsonTranslationsFrom(__DIR__.'/../Resources/Lang');
        Gate::policy(Discount::class, DiscountPolicy::class);
    }

    public function boot()
    {
        $this->app->booted(function () {
            config()->set('sidebar.items.discounts', [
                "icon" => "i-discounts",
                "title" => "تخفیف ها",
                "url" => route('discounts.index'),
                "permission" => Permission::PERMISSION_MANAGE_DISCOUNTS,
            ]);
        });
    }
}
