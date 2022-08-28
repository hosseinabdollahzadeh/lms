<?php

Route::group(['namespace'=>'Abd\Category\Http\Controllers', 'middleware'=> ['web', 'auth', 'verified']], function ($router){
    $router->resource('categories', 'CategoryController');
});
