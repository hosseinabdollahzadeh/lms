<?php
Route::group([
    'namespace'=> 'Abd\User\Http\Controllers',
    'middleware'=>'web'
], function ($router){
    Auth::routes(['verify'=> true]);
});

