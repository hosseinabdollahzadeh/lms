<?php
namespace Abd\Payment\Providers;

use Abd\Course\Models\Course;
use Abd\Payment\Gateways\Gateway;
use Abd\Payment\Gateways\Zarinpal\ZarinpalAdaptor;
use Abd\Payment\Models\Payment;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
    public $namespace = "Abd\Payment\Http\Controllers";
    public function register()
    {
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
        Route::middleware("web")->namespace($this->namespace)->group(__DIR__ . "/../Routes/payments_routes.php");
    }

    public function boot()
    {
        $this->app->singleton(Gateway::class, function($app){
            return new ZarinpalAdaptor();
        });

//        Course::resolveRelationUsing("payments", function ($courseModel){
//            return $courseModel->morphMany(Payment::class, "paymentable");
//        });
    }
}
