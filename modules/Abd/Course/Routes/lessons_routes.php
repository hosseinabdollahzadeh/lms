<?php
Route::group(['namespace'=>'Abd\Course\Http\Controllers', 'middleware'=> ['web', 'auth', 'verified']], function ($router){
    $router->get('courses/{course}/lessons/create', 'LessonController@create')->name('lessons.create');
});
