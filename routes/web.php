<?php
Route::get('/test', function () {
    dd(\Abd\Media\Services\MediaFileService::getExtensions());
//    auth()->user()->givePermissionTo(\Abd\RolePermissions\Models\Permission::PERMISSION_SUPER_ADMIN);
//    auth()->user()->givePermissionTo(\Abd\RolePermissions\Models\Permission::PERMISSION_TEACH);
//    return auth()->user()->permissions;
});
