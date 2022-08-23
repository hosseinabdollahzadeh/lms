<?php
namespace Abd\RolePermissions\Http\Controllers;

use Abd\RolePermissions\Http\Requests\RoleRequest;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionsController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        return view('RolePermissions::index', compact('roles', 'permissions'));
    }
    public function store(RoleRequest $request){

    }
}
