<?php

namespace Abd\RolePermissions\Http\Controllers;

use Abd\RolePermissions\Http\Requests\RoleRequest;
use Abd\RolePermissions\Http\Requests\RoleUpdateRequest;
use Abd\RolePermissions\Repositories\PermissionRepo;
use Abd\RolePermissions\Repositories\RoleRepo;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionsController extends Controller
{
    private $roleRepo;
    private $permissionRepo;
    public function __construct(RoleRepo $roleRepo, PermissionRepo $permissionRepo)
    {
        $this->roleRepo = $roleRepo;
        $this->permissionRepo = $permissionRepo;
    }
    public function index()
    {
        $roles = $this->roleRepo->all();
        $permissions = $this->permissionRepo->all();
        return view('RolePermissions::index', compact('roles', 'permissions'));
    }

    public function store(RoleRequest $request)
    {
        return $this->roleRepo->create($request);
    }

    public function edit($rolId)
    {
        $role = $this->roleRepo->findById($rolId);
        $permissions = $this->permissionRepo->all();
        return view('RolePermissions::edit', compact('role', 'permissions'));
    }

    public function update(RoleUpdateRequest $request, $id)
    {
        $this->roleRepo->update($request, $id);
        return redirect(route('role-permissions.index'));
    }
}
