<?php

Route::group(['namespace'=>'Abd\Dashboard\Http\Controllers', 'middleware'=> ['web', 'auth', 'verified']], function ($router){
    $router->get('/home','DashboardController@home')->name('home');
});
