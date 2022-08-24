<?php

namespace Abd\Course\Providers;

use Illuminate\Support\ServiceProvider;

class CourseServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->loadRoutesFrom(__DIR__ . '/../Routes/course_routes.php');
        $this->loadViewsFrom(__DIR__.'/../Resources/Views', 'Course');
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
    }

    public function boot()
    {
        $this->app->booted(function () {
            config()->set('sidebar.items.courses', [
                "icon" => "i-courses",
                "title" => "دوره ها",
                "url" => route('courses.index'),
            ]);
        });
    }
}
