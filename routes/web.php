<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return view('index');
});

Route::get('/test', function () {
    auth()->user()->givePermissionTo(\Abd\RolePermissions\Models\Permission::PERMISSION_SUPER_ADMIN);
    return auth()->user()->permissions;
});
