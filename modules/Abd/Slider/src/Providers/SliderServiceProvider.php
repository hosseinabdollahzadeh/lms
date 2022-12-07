<?php

namespace Abd\Slider\Providers;

use Abd\RolePermissions\Models\Permission;
use Abd\Slider\Models\Slide;
use Abd\Slider\Policies\SlidePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class SliderServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->loadViewsFrom(__DIR__ . '/../Resources/Views', 'Sliders');
        Route::middleware(['web'])
            ->group(__DIR__ . '/../Routes/slider_routes.php');
        Gate::policy(Slide::class, SlidePolicy::class);
    }

    public function boot()
    {
        $this->app->booted(function () {
            config()->set('sidebar.items.slider', [
                "icon" => "i-comments",
                "title" => "اسلایدر",
                "url" => route('slides.index'),
                "permission" => [Permission::PERMISSION_MANAGE_SLIDES]
            ]);
        });
    }
}
