<?php
Route::group(['namespace'=>'Abd\Course\Http\Controllers', 'middleware'=> ['web', 'auth', 'verified']], function ($router){
    $router->patch('seasons/{season}/accept', 'SeasonController@accept')->name('seasons.accept');
    $router->patch('seasons/{season}/reject', 'SeasonController@reject')->name('seasons.reject');
    $router->post('seasons/{course}', 'SeasonController@store')->name('seasons.store');
});
