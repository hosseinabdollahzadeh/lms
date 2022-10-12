<?php

namespace Abd\Course\Tests\Feature;

use Abd\Category\Models\Category;
use Abd\Course\Models\Course;
use Abd\Course\Models\Lesson;
use Abd\RolePermissions\Database\Seeders\RolePermissionTableSeeder;
use Abd\RolePermissions\Models\Permission;
use Abd\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class LessonTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_permitted_user_can_see_create_lesson_form()
    {
        $this->actAsAdmin();
        $course = $this->createCourse();
        $this->get(route('lessons.create', $course->id))->assertOk();

        $this->actAsUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $course = $this->createCourse();
        $this->get(route('lessons.create', $course->id))->assertOk();
    }

    public function test_not_permitted_user_can_not_see_create_lesson_form()
    {
        $this->actAsAdmin();
        $course = $this->createCourse();
        $this->actAsUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $this->get(route('lessons.create', $course->id))->assertStatus(403);
    }

    public function test_permitted_user_can_store_lesson()
    {
        $this->actAsAdmin();
        $course = $this->createCourse();
        $this->post(route('lessons.store', $course->id), [
            "title" => "Lesson One",
            "time" => "40",
            "is_free" => "1",
            "lesson_file" => UploadedFile::fake()->create('asdhye89789.mp4', 10240)
        ]);

        $this->assertEquals(1, Lesson::query()->count());
    }
    public function test_only_allowed_extensions_can_be_uploaded()
    {
        $notAllowedExtensions = ['jpg', 'png', 'mp3'];
        $this->actAsAdmin();
        $course = $this->createCourse();
        foreach ($notAllowedExtensions as $extension){
            $this->post(route('lessons.store', $course->id), [
                "title" => "Lesson One",
                "time" => "40",
                "is_free" => "1",
                "lesson_file" => UploadedFile::fake()->create('asdhye89789'.$extension, 10240)
            ]);
        }
        $this->assertEquals(0, Lesson::query()->count());
    }

    public function test_permitted_user_can_edit_lesson()
    {
        $this->actAsAdmin();
        $course =$this->createCourse();
        $lesson = $this->createLesson($course);
        $this->get(route('lessons.edit', [$course->id, $lesson->id]))->assertOk();

        $this->actAsUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $course =$this->createCourse();
        $lesson = $this->createLesson($course);
        $this->get(route('lessons.edit', [$course->id, $lesson->id]))->assertOk();

        $this->actAsUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $this->get(route('lessons.edit', [$course->id, $lesson->id]))->assertStatus(403);
    }

    public function test_permitted_user_can_update_lesson()
    {
        $this->actAsAdmin();
        $course =$this->createCourse();
        $lesson = $this->createLesson($course);

        $this->patch(route('lessons.update', [$course->id, $lesson->id]),[
            "title" => "Lesson updated",
            "time" => "25",
            "is_free" => "0",
        ]);
        $this->assertEquals("Lesson updated", Lesson::find(1)->title);

        $this->actAsUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $this->patch(route('lessons.update', [$course->id, $lesson->id]),[
            "title" => "Lesson updated 2",
            "time" => "25",
            "is_free" => "0",
        ])->assertStatus(403);
        $this->assertEquals("Lesson updated", Lesson::find(1)->title);
    }

    public function test_permitted_user_can_accept_lesson()
    {
        $this->actAsAdmin();
        $course =$this->createCourse();
        $lesson = $this->createLesson($course);
        $this->assertEquals(Lesson::CONFIRMATION_STATUS_PENDING, Lesson::find(1)->confirmation_status);
        $this->patch(route('lessons.accept', $lesson->id))->assertOk();
        $this->assertEquals(Lesson::CONFIRMATION_STATUS_ACCEPTED, Lesson::find(1)->confirmation_status);

        $this->actAsUser();
        $this->patch(route('lessons.accept', $lesson->id))->assertStatus(403);

        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $this->patch(route('lessons.accept', $lesson->id))->assertStatus(403);
    }

    public function test_permitted_user_can_accept_all_lessons()
    {
        $this->actAsAdmin();
        $course1 = $this->createCourse();
        $this->createLesson($course1);
        $this->createLesson($course1);

        $course2 = $this->createCourse();
        $this->createLesson($course2);

        $this->assertEquals(Lesson::CONFIRMATION_STATUS_PENDING, Lesson::find(1)->confirmation_status);
        $this->assertEquals(Lesson::CONFIRMATION_STATUS_PENDING, Lesson::find(2)->confirmation_status);
        $this->assertEquals(Lesson::CONFIRMATION_STATUS_PENDING, Lesson::find(3)->confirmation_status);

        $this->patch(route('lessons.acceptAll', $course1->id));
        $this->assertEquals($course1->lessons()->count(),
            $course1->lessons()->where('confirmation_status', Lesson::CONFIRMATION_STATUS_ACCEPTED)->count());

        $this->assertEquals($course2->lessons()->count(),
            $course2->lessons()->where('confirmation_status', Lesson::CONFIRMATION_STATUS_PENDING)->count());

        $this->actAsUser();
        $this->patch(route('lessons.acceptAll', $course2->id))->assertStatus(403);
        $this->assertEquals($course2->lessons()->count(),
            $course2->lessons()->where('confirmation_status', Lesson::CONFIRMATION_STATUS_PENDING)->count());

        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $this->patch(route('lessons.acceptAll', $course2->id))->assertStatus(403);
        $this->assertEquals($course2->lessons()->count(),
            $course2->lessons()->where('confirmation_status', Lesson::CONFIRMATION_STATUS_PENDING)->count());
    }

    public function test_permitted_user_can_accept_multiple_lessons()
    {
        $this->actAsAdmin();
        $course1 = $this->createCourse();
        $this->createLesson($course1);
        $this->createLesson($course1);
        $this->createLesson($course1);

        $this->assertEquals(Lesson::CONFIRMATION_STATUS_PENDING, Lesson::find(1)->confirmation_status);
        $this->assertEquals(Lesson::CONFIRMATION_STATUS_PENDING, Lesson::find(2)->confirmation_status);
        $this->assertEquals(Lesson::CONFIRMATION_STATUS_PENDING, Lesson::find(3)->confirmation_status);

        $this->patch(route('lessons.acceptMultiple',$course1->id), [
            'ids' => '1,2'
        ]);

        $this->assertEquals(Lesson::CONFIRMATION_STATUS_ACCEPTED, Lesson::find(1)->confirmation_status);
        $this->assertEquals(Lesson::CONFIRMATION_STATUS_ACCEPTED, Lesson::find(2)->confirmation_status);
        $this->assertEquals(Lesson::CONFIRMATION_STATUS_PENDING, Lesson::find(3)->confirmation_status);

        $this->actAsUser();
        $this->patch(route('lessons.acceptMultiple',$course1->id), [
            'ids' => '3'
        ])->assertStatus(403);
        $this->assertEquals(Lesson::CONFIRMATION_STATUS_PENDING, Lesson::find(3)->confirmation_status);

        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $this->patch(route('lessons.acceptMultiple',$course1->id), [
            'ids' => '3'
        ])->assertStatus(403);
        $this->assertEquals(Lesson::CONFIRMATION_STATUS_PENDING, Lesson::find(3)->confirmation_status);

    }
    public function test_permitted_user_can_reject_lesson()
    {
        $this->actAsAdmin();
        $course =$this->createCourse();
        $lesson = $this->createLesson($course);
        $this->assertEquals(Lesson::CONFIRMATION_STATUS_PENDING, Lesson::find(1)->confirmation_status);
        $this->patch(route('lessons.reject', $lesson->id))->assertOk();
        $this->assertEquals(Lesson::CONFIRMATION_STATUS_REJECTED, Lesson::find(1)->confirmation_status);

        $this->actAsUser();
        $this->patch(route('lessons.reject', $lesson->id))->assertStatus(403);

        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $this->patch(route('lessons.reject', $lesson->id))->assertStatus(403);
    }

    public function test_permitted_user_can_reject_multiple_lessons()
    {
        $this->actAsAdmin();
        $course1 = $this->createCourse();
        $this->createLesson($course1);
        $this->createLesson($course1);
        $this->createLesson($course1);

        $this->assertEquals(Lesson::CONFIRMATION_STATUS_PENDING, Lesson::find(1)->confirmation_status);
        $this->assertEquals(Lesson::CONFIRMATION_STATUS_PENDING, Lesson::find(2)->confirmation_status);
        $this->assertEquals(Lesson::CONFIRMATION_STATUS_PENDING, Lesson::find(3)->confirmation_status);

        $this->patch(route('lessons.rejectMultiple',$course1->id), [
            'ids' => '1,2'
        ]);

        $this->assertEquals(Lesson::CONFIRMATION_STATUS_REJECTED, Lesson::find(1)->confirmation_status);
        $this->assertEquals(Lesson::CONFIRMATION_STATUS_REJECTED, Lesson::find(2)->confirmation_status);
        $this->assertEquals(Lesson::CONFIRMATION_STATUS_PENDING, Lesson::find(3)->confirmation_status);

        $this->actAsUser();
        $this->patch(route('lessons.rejectMultiple',$course1->id), [
            'ids' => '3'
        ])->assertStatus(403);
        $this->assertEquals(Lesson::CONFIRMATION_STATUS_PENDING, Lesson::find(3)->confirmation_status);

        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $course2 = $this->createCourse();
        $lesson4 = $this->createLesson($course2);
        $this->patch(route('lessons.rejectMultiple',$course1->id), [
            'ids' => $lesson4->id
        ])->assertStatus(403);
        $this->assertEquals(Lesson::CONFIRMATION_STATUS_PENDING, Lesson::find(3)->confirmation_status);

    }

    public function test_permitted_user_can_lock_lesson()
    {
        $this->actAsAdmin();
        $course1 = $this->createCourse();
        $this->createLesson($course1);
        $this->createLesson($course1);

        $this->assertEquals(Lesson::STATUS_OPENED, Lesson::find(1)->status);
        $this->assertEquals(Lesson::STATUS_OPENED, Lesson::find(2)->status);

        $this->patch(route('lessons.lock', 1))->assertOk();

        $this->assertEquals(Lesson::STATUS_LOCKED, Lesson::find(1)->status);
        $this->assertEquals(Lesson::STATUS_OPENED, Lesson::find(2)->status);

        $this->actAsUser();
        $this->patch(route('lessons.lock', 2))->assertStatus(403);
        $this->assertEquals(Lesson::STATUS_OPENED, Lesson::find(2)->status);

        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $this->patch(route('lessons.lock', 2))->assertStatus(403);
        $this->assertEquals(Lesson::STATUS_OPENED, Lesson::find(2)->status);
    }

    public function test_permitted_user_can_unlock_lesson()
    {
        $this->actAsAdmin();
        $course1 = $this->createCourse();
        $this->createLesson($course1);
        $this->createLesson($course1);
        $this->patch(route('lessons.lock', 1))->assertOk();
        $this->patch(route('lessons.lock', 2))->assertOk();

        $this->assertEquals(Lesson::STATUS_LOCKED, Lesson::find(1)->status);
        $this->assertEquals(Lesson::STATUS_LOCKED, Lesson::find(2)->status);

        $this->patch(route('lessons.unlock', 1))->assertOk();

        $this->assertEquals(Lesson::STATUS_OPENED, Lesson::find(1)->status);
        $this->assertEquals(Lesson::STATUS_LOCKED, Lesson::find(2)->status);

        $this->actAsUser();
        $this->patch(route('lessons.unlock', 2))->assertStatus(403);
        $this->assertEquals(Lesson::STATUS_LOCKED, Lesson::find(2)->status);

        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $this->patch(route('lessons.unlock', 2))->assertStatus(403);
        $this->assertEquals(Lesson::STATUS_LOCKED, Lesson::find(2)->status);
    }

    public function test_permitted_user_can_destroy_lesson()
    {
        $this->actAsAdmin();
        $course1 = $this->createCourse();
        $lesson1 =$this->createLesson($course1);
        $lesson2 = $this->createLesson($course1);

        $this->delete(route('lessons.destroy', [$course1->id, $lesson1->id]))->assertOk();
        $this->assertEquals(null, Lesson::find(1));

        $this->actAsUser();
        $this->delete(route('lessons.destroy', [$course1->id, $lesson2->id]))->assertStatus(403);
        $this->assertEquals(1, Lesson::query()->where('id', 2)->count());

        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $course2 = $this->createCourse();
        $lesson3 =$this->createLesson($course2);
        $this->delete(route('lessons.destroy', [$course2->id, $lesson3->id]))->assertOk();
        $this->assertEquals(null, Lesson::find(3));
    }
    public function test_permitted_user_can_destroy_multiple_lessons()
    {
        $this->actAsAdmin();
        $course1 = $this->createCourse();
        $this->createLesson($course1);
        $this->createLesson($course1);
        $this->createLesson($course1);

        $this->delete(route('lessons.destroyMultiple',$course1->id), [
            'ids' => '1,2'
        ]);

        $this->assertEquals(null, Lesson::find(1));
        $this->assertEquals(null, Lesson::find(2));
        $this->assertEquals(1, Lesson::find(3)->count());

        $this->actAsUser();
        $this->delete(route('lessons.destroyMultiple',$course1->id), [
            'ids' => '3'
        ])->assertStatus(403);
        $this->assertEquals(1, Lesson::find(3)->count());

        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $course2 = $this->createCourse();
        $lesson4 = $this->createLesson($course2);
        $this->delete(route('lessons.destroyMultiple',$course2->id), [
            'ids' => $lesson4->id
        ]);
        $this->assertEquals(null, Lesson::find(4));

    }

    private function createLesson($course)
    {
        return Lesson::create([
            "title" => "Lesson One",
            "slug" => "Lesson One",
            "course_id" => $course->id,
            "user_id" => auth()->id(),
        ]);
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
