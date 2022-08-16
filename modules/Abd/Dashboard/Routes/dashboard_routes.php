<?php

Route::group(['namespace'=>'Abd\Dashboard\Http\Controllers'], function ($router){
    $router->get('/home','DashboardController@home')->name('home');
});
