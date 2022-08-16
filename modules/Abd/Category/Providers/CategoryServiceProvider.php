<?php

namespace Abd\Category\Providers;

use Illuminate\Support\ServiceProvider;

class CategoryServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../Routes/category_routes.php');
        $this->loadViewsFrom(__DIR__.'/../Resources/Views', 'Categories');
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
    }
}
