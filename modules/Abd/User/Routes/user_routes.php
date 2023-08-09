<?php
Route::group([
    'namespace' => 'Abd\User\Http\Controllers',
    'middleware' => 'web', 'auth'
], function ($router) {
    Route::post('users/{user}/add/role', 'UserController@addRole')->name('users.addRole');
    Route::delete('users/{user}/remove/{role}/role', 'UserController@removeRole')->name('users.removeRole');
    Route::patch('users/{user}/manualVerify', 'UserController@manualVerify')->name('users.manualVerify');
    Route::post('users/photo', 'UserController@updatePhoto')->name('users.photo');
    Route::get('edit-profile', 'UserController@profile')->name('users.editProfile');
    Route::post('edit-profile', ['uses' => 'UserController@updateProfile', "as" => "users.updateProfile"]);
    Route::get('users/{user}/info', ['uses' => 'UserController@info', "as" => "users.info"]);
    $router->resource('users', 'UserController');

});
Route::group([
    'namespace' => 'Abd\User\Http\Controllers',
    'middleware' => 'web'
], function ($router) {
    Route::post('/email/verify', 'Auth\VerificationController@verify')->name('verification.verify')->middleware('throttle:6,1');
    Route::post('/email/resend', 'Auth\VerificationController@resend')->name('verification.resend')->middleware('throttle:6,1');
    Route::get('/email/verify', 'Auth\VerificationController@show')->name('verification.notice');

    // login
    Route::get('/login', 'Auth\LoginController@showLoginForm')->name('loginForm');
    Route::post('/login', 'Auth\LoginController@login')->name('login');

    // logout
    Route::any('/logout', 'Auth\LoginController@logout')->name('logout');

    // reset password
    Route::get('/password/reset', 'Auth\ForgotPasswordController@showVerifyCodeRequestForm')
        ->name('password.request');
    Route::get('/password/reset/send', 'Auth\ForgotPasswordController@sendVerifyCodeEmail')
        ->name('password.sendVerifyCodeEmail')->middleware('throttle:5,30');
    Route::post('/password/reset/check-verify-code', 'Auth\ForgotPasswordController@checkVerifyCode')
        ->name('password.checkVerifyCode')
        ->middleware('throttle:5,1');
    Route::get('/password/change', 'Auth\ResetPasswordController@showResetForm')
        ->name('password.showResetForm')->middleware('auth');
    Route::post('/password/change', 'Auth\ResetPasswordController@reset')->name('password.update');


    // register
    Route::get('/register', 'Auth\RegisterController@showRegistrationForm')->name('registerForm');
    Route::post('/register', 'Auth\RegisterController@register')->name('register');

});

