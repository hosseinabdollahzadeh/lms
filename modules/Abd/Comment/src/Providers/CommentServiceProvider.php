<?php

namespace Abd\Comment\Providers;

use Abd\RolePermissions\Models\Permission;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class CommentServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->loadViewsFrom(__DIR__ . '/../Resources/Views', 'Comments');
        $this->loadJsonTranslationsFrom(__DIR__ . '/../Resources/Lang');

        Route::middleware(['web', 'auth'])
            ->group(__DIR__ . '/../Routes/comments_routes.php');
    }

    public function boot()
    {
        $this->app->booted(function () {
            config()->set('sidebar.items.comments', [
                "icon" => "i-comments",
                "title" => "نظرات",
                "url" => route('comments.index'),
                "permission" => Permission::PERMISSION_MANAGE_COMMENTS,
            ]);
        });
    }
}
