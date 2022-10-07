<?php
Route::group(['namespace'=>'Abd\Course\Http\Controllers', 'middleware'=> ['web', 'auth', 'verified']], function ($router){
    $router->get('courses/{course}/lessons/create', 'LessonController@create')->name('lessons.create');
    $router->post('courses/{course}/lessons/store', 'LessonController@store')->name('lessons.store');
    $router->delete('courses/{course}/lessons/{lesson}', 'LessonController@destroy')->name('lessons.destroy');
    $router->delete('courses/{course}/lessons/', 'LessonController@destroyMultiple')->name('lessons.destroyMultiple');
    $router->patch('lessons/{lesson}/accept', 'LessonController@accept')->name('lessons.accept');
    $router->patch('lessons/{lesson}/reject', 'LessonController@reject')->name('lessons.reject');
    $router->patch('lessons/{lesson}/lock', 'LessonController@lock')->name('lessons.lock');
    $router->patch('lessons/{lesson}/unlock', 'LessonController@unlock')->name('lessons.unlock');
});
