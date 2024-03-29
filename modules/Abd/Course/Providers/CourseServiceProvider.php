<?php

namespace Abd\Course\Providers;

use Abd\Course\Models\Course;
use Abd\Course\Models\Lesson;
use Abd\Course\Models\Season;
use Abd\Course\Policies\CoursePolicy;
use Abd\Course\Policies\LessonPolicy;
use Abd\Course\Policies\SeasonPolicy;
use Abd\RolePermissions\Models\Permission;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class CourseServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->register(EventServiceProvider::class);
        $this->loadRoutesFrom(__DIR__ . '/../Routes/course_routes.php');
        $this->loadRoutesFrom(__DIR__ . '/../Routes/seasons_routes.php');
        $this->loadRoutesFrom(__DIR__ . '/../Routes/lessons_routes.php');
        $this->loadViewsFrom(__DIR__.'/../Resources/Views', 'Courses');
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
        $this->loadJsonTranslationsFrom(__DIR__.'/../Resources/Lang');
        $this->loadTranslationsFrom(__DIR__.'/../Resources/Lang', 'Courses');

        Gate::policy(Course::class, CoursePolicy::class);
        Gate::policy(Season::class, SeasonPolicy::class);
        Gate::policy(Lesson::class, LessonPolicy::class);
    }

    public function boot()
    {
        $this->app->booted(function () {
            config()->set('sidebar.items.courses', [
                "icon" => "i-courses",
                "title" => "دوره ها",
                "url" => route('courses.index'),
                "permission" => [
                    Permission::PERMISSION_MANAGE_COURSES,
                    Permission::PERMISSION_MANAGE_OWN_COURSES
                    ]
            ]);
        });
    }
}
