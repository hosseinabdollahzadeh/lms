<?php

Route::group(['namespace'=>'Abd\Course\Http\Controllers', 'middleware'=> ['web', 'auth', 'verified']], function ($router){
    $router->resource('courses', 'CourseController');
});
