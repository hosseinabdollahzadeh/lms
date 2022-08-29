<?php

namespace Abd\Course\Tests\Feature;

use Abd\Category\Models\Category;
use Abd\Course\Models\Course;
use Abd\RolePermissions\Database\Seeders\RolePermissionTableSeeder;
use Abd\RolePermissions\Models\Permission;
use Abd\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CourseTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
    // permitted user can see courses index
    public function test_permitted_user_can_see_courses_index()
    {
        $this->actAsAdmin();
        $this->get(route('courses.index'))->assertOk();

        $this->actAsSupperAdmin();
        $this->get(route('courses.index'))->assertOk();
    }

    public function test_normal_user_can_not_see_courses_index()
    {
        $this->actAsUser();
        $this->get(route('courses.index'))->assertStatus(403);
    }

    // permitted user can see create course
    public function test_permitted_user_can_create_course()
    {
        $this->actAsAdmin();
        $this->get(route('courses.create'))->assertOk();

        $this->actAsUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $this->get( route('courses.create'))->assertOk();
    }
    public function test_normal_user_can_not_create_course()
    {
        $this->actAsUser();
        $this->get(route('courses.create'))->assertStatus(403);
    }

    // permitted user store course
    public function test_permitted_user_can_store_course()
    {
        $this->actAsUser();
        auth()->user()->givePermissionTo([Permission::PERMISSION_MANAGE_OWN_COURSES,Permission::PERMISSION_TEACH]);
        Storage::fake('local');
        $response = $this->post(route('courses.store'),$this->courseData());
        $response->assertRedirect(route('courses.index'));
        $this->assertEquals(1,Course::count());
    }
    // permitted user can edit course
    public function test_permitted_user_can_edit_course()
    {
        $this->actAsAdmin();
        $course = $this->createCourse();
        $this->get(route('courses.edit', $course->id))->assertOk();

        $this->actAsUser();
        $course = $this->createCourse();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $this->get(route('courses.edit', $course->id))->assertOk();
    }
    public function test_permitted_user_can_not_edit_other_users_courses()
    {
        $this->actAsUser();
        $course = $this->createCourse();

        $this->actAsUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
//        $this->get(route('courses.edit', $course->id))->assertForbidden(); // this or below line
        $this->get(route('courses.edit', $course->id))->assertStatus(403);

    }
    public function test_normal_user_can_not_edit_course()
    {
        $this->actAsUser();
        $course = $this->createCourse();
        $this->get(route('courses.edit', $course->id))->assertStatus(403);

    }
    // permitted user can update course
    public function test_permitted_user_can_update_course()
    {
        $this->actAsUser();
        auth()->user()->givePermissionTo([Permission::PERMISSION_MANAGE_OWN_COURSES,Permission::PERMISSION_TEACH]);
        $course = $this->createCourse();
        $this->patch(route('courses.update', $course->id), [
            'title' => 'updated title',
            'slug' => 'updated slug',
            'teacher_id' => auth()->id(),
            'category_id' => $course->category->id,
            'price' => 1000,
            'percent' => 70,
            'type' => Course::TYPE_FREE,
            'status' => Course::STATUS_COMPLETED,
            'image' => UploadedFile::fake()->image('banner.jpg'),
        ])->assertRedirect(route('courses.index'));
        $course = $course->fresh();
        $this->assertEquals('updated title', $course->title);
    }
    public function test_normal_user_can_not_update_course()
    {
        $this->actAsAdmin();
        $course = $this->createCourse();

        $this->actAsUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_TEACH);
        $this->patch(route('courses.update', $course->id), [
            'title' => 'updated title',
            'slug' => 'updated slug',
            'teacher_id' => auth()->id(),
            'category_id' => $course->category->id,
            'price' => 1000,
            'percent' => 70,
            'type' => Course::TYPE_FREE,
            'status' => Course::STATUS_COMPLETED,
            'image' => UploadedFile::fake()->image('banner.jpg'),
        ])->assertStatus(403);
    }
    // permitted user can delete course
    public function test_permitted_user_can_delete_course()
    {
        $this->actAsAdmin();
        $course = $this->createCourse();
        $this->delete(route('courses.destroy', $course->id))->assertOk();
        $this->assertEquals(0, Course::count());
    }
    public function test_normal_user_can_not_delete_course()
    {
        $this->actAsAdmin();
        $course = $this->createCourse();
        $this->actAsUser();
        $this->delete(route('courses.destroy', $course->id))->assertStatus(403);
        $this->assertEquals(1, Course::count());
    }

    public function test_permitted_user_can_change_confirmation_status()
    {
        $this->actAsAdmin();
        $course = $this->createCourse();
        $this->patch(route('courses.accept', $course->id))->assertOk();
        $this->patch(route('courses.reject', $course->id))->assertOk();
        $this->patch(route('courses.lock', $course->id))->assertOk();
    }
    public function test_normal_user_can_not_change_confirmation_status()
    {
        $this->actAsUser();
        $course = $this->createCourse();
        $this->patch(route('courses.accept', $course->id))->assertStatus(403);
        $this->patch(route('courses.reject', $course->id))->assertStatus(403);
        $this->patch(route('courses.lock', $course->id))->assertStatus(403);
    }

    private function createCourse()
    {
        $data = $this->courseData() + ["confirmation_status" => Course::CONFIRMATION_STATUS_PENDING];
        unset($data['image']);
        return Course::create($data);

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
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_COURSES);

    }
    private function actAsSupperAdmin()
    {
        $this->createUser();
        $this->seed(RolePermissionTableSeeder::class);
        auth()->user()->givePermissionTo(Permission::PERMISSION_SUPER_ADMIN);
    }

    private function createUser()
    {
        $user = User::create([
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'password' => bcrypt('Aa@1234')
        ]);
        $user->markEmailAsVerified();
        $this->actingAs($user);
    }
    private function createCategory()
    {
        return Category::create(['title'=> $this->faker->word, 'slug'=> $this->faker->word]);

    }

    private function courseData()
    {
        $category = $this->createCategory();
        return [
            'title' => $this->faker->sentence(2),
            'slug' => $this->faker->sentence(2),
            'teacher_id' => auth()->id(),
            'category_id' => $category->id,
            'price' => 1000,
            'percent' => 70,
            'type' => Course::TYPE_FREE,
            'status' => Course::STATUS_COMPLETED,
            'image' => UploadedFile::fake()->image('banner.jpg'),
        ];
    }
}
