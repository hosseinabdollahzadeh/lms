<?php

namespace Abd\RolePermissions\Http\Controllers;

use Abd\Category\Responses\AjaxResponses;
use Abd\RolePermissions\Http\Requests\RoleRequest;
use Abd\RolePermissions\Http\Requests\RoleUpdateRequest;
use Abd\RolePermissions\Models\Role;
use Abd\RolePermissions\Repositories\PermissionRepo;
use Abd\RolePermissions\Repositories\RoleRepo;
use App\Http\Controllers\Controller;

class RolePermissionsController extends Controller
{
    private $roleRepo;
    private $permissionRepo;
    public function __construct(RoleRepo $roleRepo, PermissionRepo $permissionRepo)
    {
        $this->roleRepo = $roleRepo;
        $this->permissionRepo = $permissionRepo;
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('index', Role::class);
        $roles = $this->roleRepo->all();
        $permissions = $this->permissionRepo->all();
        return view('RolePermissions::index', compact('roles', 'permissions'));
    }

    public function store(RoleRequest $request)
    {
        $this->authorize('create', Role::class);
        $this->roleRepo->create($request);
        return redirect(route('role-permissions.index'));
    }

    public function edit($rolId)
    {
        $this->authorize('edit', Role::class);
        $role = $this->roleRepo->findById($rolId);
        $permissions = $this->permissionRepo->all();
        return view('RolePermissions::edit', compact('role', 'permissions'));
    }

    public function update(RoleUpdateRequest $request, $id)
    {
        $this->authorize('edit', Role::class);
        $this->roleRepo->update($request, $id);
        return redirect(route('role-permissions.index'));
    }

    public function destroy($roleId)
    {
        $this->authorize('delete', Role::class);
        $this->roleRepo->delete($roleId);
        return AjaxResponses::SuccessResponse();
    }
}
