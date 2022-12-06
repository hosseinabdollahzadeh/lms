<?php

namespace Abd\Course\Tests\Feature;

use Abd\Category\Models\Category;
use Abd\Comment\Models\Comment;
use Abd\Course\Models\Course;
use Abd\RolePermissions\Database\Seeders\RolePermissionTableSeeder;
use Abd\RolePermissions\Models\Permission;
use Abd\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    // permitted user can see courses index
    public function test_permitted_user_can_see_comments_index()
    {
        $this->actAsAdmin();
        $this->get(route('comments.index'))->assertOk();

        $this->actAsSupperAdmin();
        $this->get(route('comments.index'))->assertOk();
    }

    public function test_normal_user_can_not_see_comments_index()
    {
        $this->actAsUser();
        $this->get(route('comments.index'))->assertStatus(403);
    }

    // permitted user can see create course
    public function test_user_can_store_comment()
    {
        $this->actAsUser();
        $course = $this->createCourse();
        $this->post(route('comments.store', [
            "body" => "my first test comment",
            "commentable_id" => $course->id,
            "commentable_type" => get_class($course),
        ]))->assertRedirect();
        $this->assertEquals(1, Comment::query()->count());

//        $this->actAsUser();
//        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
//        $this->get(route('courses.create'))->assertOk();
    }

    public function test_user_can_not_reply_to_unapproved_comment()
    {
        $this->actAsUser();
        $course = $this->createCourse();
        $this->post(route('comments.store', [
            "body" => "my first test comment",
            "commentable_id" => $course->id,
            "commentable_type" => get_class($course),
        ]));

        // if the comment is not approved , user can`t reply to comment
        $this->post(route('comments.store', [
            "body" => "my first test comment",
            "commentable_id" => $course->id,
            "comment_id" => 1,
            "commentable_type" => get_class($course),
        ]));
        $this->assertEquals(1, Comment::query()->count());
    }

    public function test_user_can_reply_to_approved_comment()
    {
        $this->actAsAdmin();
        $course = $this->createCourse();
        $this->post(route('comments.store', [
            "body" => "my first test comment",
            "commentable_id" => $course->id,
            "commentable_type" => get_class($course),
        ]));

        // if the comment is not approved , user can`t reply to comment
        $this->post(route('comments.store', [
            "body" => "my first test comment",
            "commentable_id" => $course->id,
            "comment_id" => 1,
            "commentable_type" => get_class($course),
        ]));
        $this->assertEquals(2, Comment::query()->count());
    }

    // we can continue tests as the same above for other actions

    private function createUser()
    {
        $this->actingAs(User::factory()->create());
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
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_COMMENTS);

    }

    private function actAsSupperAdmin()
    {
        $this->createUser();
        $this->seed(RolePermissionTableSeeder::class);
        auth()->user()->givePermissionTo(Permission::PERMISSION_SUPER_ADMIN);
    }

    private function createCourse()
    {
        $data = $this->courseData() + ["confirmation_status" => Course::CONFIRMATION_STATUS_PENDING];
        unset($data['image']);
        return Course::create($data);

    }

    private function createCategory()
    {
        return Category::create(['title' => $this->faker->word, 'slug' => $this->faker->word]);

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
