<?php
namespace Abd\Media\Providers;

use Illuminate\Support\ServiceProvider;

class MediaServiceProvider extends ServiceProvider
{
    public function register()
    {
//        $this->loadRoutesFrom(__DIR__ . '/../Routes/media_routes.php');
//        $this->loadViewsFrom(__DIR__.'/../Resources/Views', 'Media');
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
//        $this->loadJsonTranslationsFrom(__DIR__.'/../Resources/Lang');
//        $this->loadTranslationsFrom(__DIR__.'/../Resources/Lang', 'Media');
        $this->mergeConfigFrom(__DIR__.'/../Config/mediaFile.php', 'mediaFile');
    }

    public function boot()
    {

    }
}
