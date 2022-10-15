<?php

namespace Abd\RolePermissions\Tests\Feature;

use Abd\RolePermissions\Database\Seeders\RolePermissionTableSeeder;
use Abd\RolePermissions\Models\Permission;
use Abd\RolePermissions\Models\Role;
use Abd\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RolesTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_permitted_user_can_see_index()
    {
        $this->actAsAdmin();
        $this->get(route('role-permissions.index'))->assertOk();
    }
    public function test_normal_user_can_not_see_index()
    {
        $this->actAsUser();
        $this->get(route('role-permissions.index'))->assertStatus(403);
    }

    public function test_permitted_user_can_store_role()
    {
        $this->actAsAdmin();
        $this->post(route('role-permissions.store'), [
            "name" => "test_role",
            "permissions" =>[
                Permission::PERMISSION_TEACH,
                Permission::PERMISSION_MANAGE_COURSES
            ]
        ])->assertRedirect(route('role-permissions.index'));
        $this->assertEquals(count(Role::$roles)+1, Role::count());
    }
    public function test_normal_user_can_not_store_role()
    {
        $this->actAsUser();
        $this->post(route('role-permissions.store'), [
            "name" => "test_role",
            "permissions" =>[
                Permission::PERMISSION_TEACH,
                Permission::PERMISSION_MANAGE_COURSES
            ]
        ])->assertStatus(403);
        $this->assertEquals(count(Role::$roles), Role::count());
    }

    public function test_permitted_user_can_see_edit_role()
    {
        $this->actAsAdmin();
        $role = $this->createRole();
        $this->get(route('role-permissions.edit', $role->id))->assertOk();
    }
    public function test_normal_user_can_not_see_edit_role()
    {
        $this->actAsUser();
        $role = $this->createRole();
        $this->get(route('role-permissions.edit', $role->id))->assertStatus(403);
    }

    public function test_permitted_user_can_update_role()
    {
        $this->actAsAdmin();
        $role = $this->createRole();
        $this->patch(route('role-permissions.update', $role->id), [
            "id" => $role->id,
            "name" => "updated_role",
            "permissions" =>[
                Permission::PERMISSION_TEACH,
                Permission::PERMISSION_MANAGE_COURSES
            ]
        ])->assertRedirect(route('role-permissions.index'));

        $this->assertEquals('updated_role', $role->fresh()->name);
    }
    public function test_normal_user_can_not_update_role()
    {
        $this->actAsUser();
        $role = $this->createRole();
        $this->patch(route('role-permissions.update', $role->id), [
            "id" => $role->id,
            "name" => "updated_role",
            "permissions" =>[
                Permission::PERMISSION_TEACH,
            ]
        ])->assertStatus(403);
        $this->assertEquals($role->name, $role->fresh()->name);
    }

    public function test_permitted_user_can_delete_role()
    {
        $this->actAsAdmin();
        $role = $this->createRole();
        $this->delete(route('role-permissions.destroy', $role->id))->assertOk();
        $this->assertEquals(count(Role::$roles), Role::count());
    }
    public function test_normal_user_can_not_delete_role()
    {
        $this->actAsUser();
        $role = $this->createRole();
        $this->delete(route('role-permissions.destroy', $role->id))->assertStatus(403);
        $this->assertEquals(count(Role::$roles) +1, Role::count());
    }

    public function createRole()
    {
        return Role::create(['name' => 'test_role'])->syncPermissions([Permission::PERMISSION_TEACH, Permission::PERMISSION_MANAGE_COURSES]);
    }
    private function actAsUser()
    {
        $this->createUser();
        $this->seed(RolePermissionTableSeeder::class);
    }
    private function actAsAdmin()
    {
        $this->createUser();
        $this->seed(RolePermissionTableSeeder::class);
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_ROLE_PERMISSIONS);

    }
    private function actAsSupperAdmin()
    {
        $this->createUser();
        $this->seed(RolePermissionTableSeeder::class);
        auth()->user()->givePermissionTo(Permission::PERMISSION_SUPER_ADMIN);
    }

    private function createUser()
    {
        $this->actingAs(User::factory()->create());
    }
}
