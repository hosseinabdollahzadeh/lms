<?php

namespace Abd\Payment\Providers;

use Abd\Payment\Gateways\Gateway;
use Abd\Payment\Gateways\Zarinpal\ZarinpalAdaptor;
use Abd\Payment\Models\Settlement;
use Abd\Payment\Policies\SettlementPolicy;
use Abd\RolePermissions\Models\Permission;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
    public $namespace = "Abd\Payment\Http\Controllers";

    public function register()
    {
        $this->app->register(EventServiceProvider::class);
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        Route::middleware("web")->namespace($this->namespace)->group(__DIR__ . "/../Routes/payments_routes.php");
        Route::middleware("web")->namespace($this->namespace)->group(__DIR__ . "/../Routes/settlements_routes.php");
        $this->loadViewsFrom(__DIR__ . '/../Resources/Views', 'Payment');
        $this->loadJsonTranslationsFrom(__DIR__ . '/../Resources/Lang');
        \Gate::policy(Settlement::class, SettlementPolicy::class);
    }

    public function boot()
    {
        $this->app->singleton(Gateway::class, function ($app) {
            return new ZarinpalAdaptor();
        });
        $this->app->booted(function () {
            config()->set('sidebar.items.payments', [
                "icon" => "i-transactions",
                "title" => "تراکنش ها",
                "url" => route('payments.index'),
                "permission" => [
                    Permission::PERMISSION_MANAGE_PAYMENTS,
                ]
            ]);
        });
        $this->app->booted(function () {
            config()->set('sidebar.items.my-purchases', [
                "icon" => "i-my__purchases",
                "title" => "خریدهای من",
                "url" => route('purchases.index')
            ]);
        });
        $this->app->booted(function () {
            config()->set('sidebar.items.settlements', [
                "icon" => "i-checkouts",
                "title" => "تسویه حساب ها",
                "url" => route('settlements.index'),
                "permission" => [
                    Permission::PERMISSION_TEACH,
                    Permission::PERMISSION_MANAGE_SETTLEMENTS,
                ]
            ]);
        });
        $this->app->booted(function () {
            config()->set('sidebar.items.paymentsRequest', [
                "icon" => "i-checkout__request",
                "title" => "درخواست تسویه",
                "url" => route('settlements.create'),
                "permission" => [
                    Permission::PERMISSION_TEACH,
                ]
            ]);
        });

    }
}
