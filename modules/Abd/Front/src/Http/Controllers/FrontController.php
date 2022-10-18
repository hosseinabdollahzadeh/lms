<?php

namespace Abd\Front\Http\Controllers;

use Abd\Course\Repositories\CourseRepo;
use Abd\Course\Repositories\LessonRepo;
use Abd\RolePermissions\Models\Permission;
use Abd\User\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class FrontController extends Controller
{
    public function index()
    {
        return view('Front::index');
    }

    public function singleCourse($slug, CourseRepo $courseRepo, LessonRepo $lessonRepo)
    {
        $courseId = $this->extractId($slug, 'c');
        $course = $courseRepo->findById($courseId);
        $lessons = $lessonRepo->getAcceptedLessons($courseId);

        if(request()->lesson){
            $lesson = $lessonRepo->getLesson($courseId, $this->extractId(request()->lesson, 'l'));
        }else{
            $lesson = $lessonRepo->getFirstLesson($courseId);
        }
        return view('Front::singleCourse', compact('course', 'lessons', 'lesson'));
    }

    public function extractId($slug, $key)
    {
        return Str::before(Str::after($slug,$key.'-'),'-');
    }

    public function singleTutor($username)
    {
        $tutor = User::permission(Permission::PERMISSION_TEACH)->where('username', $username)->first();

        return view('Front::tutor', compact('tutor'));
    }
}
