<?php

use Abd\Comment\Http\Controllers\CommentController;

Route::group([], function($router){
    $router->resources(["comments" => CommentController::class]);
});

Route::group([], function($router){
    $router->get("/comments", [CommentController::class, "index"])->name('comments.index');
});
