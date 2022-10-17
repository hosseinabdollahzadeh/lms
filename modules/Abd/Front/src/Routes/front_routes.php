<?php
Route::group(['middleware' => ['web'], 'namespace' => 'Abd\Front\Http\Controllers'],
    function ($router) {
        $router->get('/', 'FrontController@index');
        $router->get('/c-{slug}', 'FrontController@singleCourse')->name('singleCourse');
    });
