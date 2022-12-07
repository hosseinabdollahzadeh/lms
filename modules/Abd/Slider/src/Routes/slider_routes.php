<?php

use Abd\Slider\Http\Controllers\SlideController;

Route::group(["middleware" => "auth"], function ($router){
    $router->resources(['slides' => SlideController::class]);
});
