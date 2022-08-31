<?php

namespace Abd\RolePermissions\Models;

class Permission extends \Spatie\Permission\Models\Permission
{
    const PERMISSION_MANAGE_CATEGORIES = 'manage categories';
    const PERMISSION_MANAGE_USERS = 'manage users';
    const PERMISSION_MANAGE_ROLE_PERMISSIONS = 'manage role_permissions';
    const PERMISSION_MANAGE_COURSES = 'manage courses';
    const PERMISSION_MANAGE_OWN_COURSES = 'manage own courses';
    const PERMISSION_TEACH = 'teach';
    const PERMISSION_SUPER_ADMIN = 'super admin';

    static $permissions = [
        self::PERMISSION_MANAGE_CATEGORIES,
        self::PERMISSION_MANAGE_USERS,
        self::PERMISSION_MANAGE_ROLE_PERMISSIONS,
        self::PERMISSION_MANAGE_COURSES,
        self::PERMISSION_MANAGE_OWN_COURSES,
        self::PERMISSION_TEACH,
        self::PERMISSION_SUPER_ADMIN
    ];
}
