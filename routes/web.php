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
//    \Spatie\Permission\Models\Permission::create(['name' => 'manage categories']);
//    \Spatie\Permission\Models\Permission::create(['name' => 'manage role_permissions']);
//    auth()->user()->givePermissionTo('manage categories');
//    auth()->user()->givePermissionTo('manage role_permissions');
    auth()->user()->givePermissionTo('teach');
    return auth()->user()->permissions;
});
