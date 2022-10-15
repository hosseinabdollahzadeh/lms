<?php

namespace Abd\Category\Tests\Feature;

use Abd\Category\Models\Category;
use Abd\RolePermissions\Database\Seeders\RolePermissionTableSeeder;
use Abd\RolePermissions\Models\Permission;
use Abd\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_permitted_user_can_see_categories_panel()
    {
        $this->actingAsAdmin();
        $this->get(route('categories.index'))->assertOk();
    }

    public function test_normal_user_can_not_see_categories_panel()
    {
        $this->actingAsUser();
        $this->get(route('categories.index'))->assertStatus(403);
    }

    public function test_permitted_user_can_create_category()
    {
        $this->actingAsAdmin();
        $this->createCategory();
        $this->assertEquals(1, Category::all()->count());
    }
    public function test_permitted_user_can_edit_category()
    {
        $newTitle = 'New Title after update';
        $newSlug = 'New Slug after update';
        $this->actingAsAdmin();
        $this->createCategory();
        $this->assertEquals(1, Category::all()->count());
        $this->patch(route('categories.update', 1), ['title'=> $newTitle, 'slug'=>$newSlug]);
        $this->assertEquals(1, Category::query()->where(['title'=> $newTitle, 'slug'=>$newSlug])->count());
    }

    public function test_permitted_user_can_delete_category()
    {
        $this->actingAsAdmin();
        $this->createCategory();
        $this->assertEquals(1, Category::all()->count());
        $this->delete(route('categories.destroy', 1))->assertOk();
        $this->assertEquals(0, Category::all()->count());
    }

    private function createCategory()
    {
        $this->post(route('categories.store', ['title'=> $this->faker->word, 'slug'=> $this->faker->word]));

    }
    private function actingAsAdmin()
    {
        // create user
        $this->actingAs(User::factory()->create());
        // seed roles and give permission
        $this->seed(RolePermissionTableSeeder::class);
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_CATEGORIES);

    }
    private function actingAsUser()
    {
        // create user
        $this->actingAs(User::factory()->create());
        // seed roles and give permission
        $this->seed(RolePermissionTableSeeder::class);
    }
}
