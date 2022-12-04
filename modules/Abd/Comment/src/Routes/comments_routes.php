<?php

use Abd\Comment\Http\Controllers\CommentController;

Route::group([], function($router){
    $router->post("/comments/{commentable}", [CommentController::class, "store"])->name('comments.store');
});
