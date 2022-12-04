<?php

use Abd\Comment\Http\Controllers\CommentController;

Route::group([], function($router){
    $router->resources(["comments" => CommentController::class]);
    $router->patch('comments/{course}/accept', [CommentController::class, 'accept'])->name('comments.accept');
    $router->patch('comments/{course}/reject', [CommentController::class, 'reject'])->name('comments.reject');
});

Route::group([], function($router){
    $router->get("/comments", [CommentController::class, "index"])->name('comments.index');
});
