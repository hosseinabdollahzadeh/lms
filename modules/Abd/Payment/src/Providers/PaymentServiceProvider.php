<?php
namespace Abd\Payment\Providers;

use Abd\Course\Models\Course;
use Abd\Payment\Gateways\Gateway;
use Abd\Payment\Gateways\Zarinpal\ZarinpalAdaptor;
use Abd\Payment\Models\Payment;
use Abd\RolePermissions\Models\Permission;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
    public $namespace = "Abd\Payment\Http\Controllers";
    public function register()
    {
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
        Route::middleware("web")->namespace($this->namespace)->group(__DIR__ . "/../Routes/payments_routes.php");
        $this->loadViewsFrom(__DIR__.'/../Resources/Views', 'Payment');
        $this->loadJsonTranslationsFrom(__DIR__.'/../Resources/Lang');
    }

    public function boot()
    {
        $this->app->singleton(Gateway::class, function($app){
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
    }
}