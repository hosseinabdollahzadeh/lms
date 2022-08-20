<?php

Route::group(['namespace'=>'Abd\RolePermissions\Http\Controllers', 'middleware'=> ['web', 'auth', 'verified']], function ($router){
    $router->resource('role-permissions', 'RolePermissionsController')->middleware('permission:manage role_permissions');
});
