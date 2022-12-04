<?php

use Abd\Comment\Http\Controllers\CommentController;

Route::group([], function($router){
    $router->resources(["comments" => CommentController::class]);
});
