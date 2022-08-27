<?php

namespace Abd\Course\Http\Controllers;

use Abd\Category\Repositories\CategoryRepo;
use Abd\Category\Responses\AjaxResponses;
use Abd\Course\CourseRepo;
use Abd\Course\Http\Requests\CourseRequest;
use Abd\Media\Models\Media;
use Abd\Media\Services\MediaFileService;
use Abd\User\Repositories\UserRepo;
use App\Http\Controllers\Controller;

class CourseController extends Controller
{
    public function index(CourseRepo $courseRepo)
    {
        $courses = $courseRepo->paginate();
        return view('Courses::index', compact('courses'));
    }

    public function create(UserRepo $userRepo, CategoryRepo $categoryRepo)
    {
        $teachers = $userRepo->getTeachers();
        $categories = $categoryRepo->all();
        return view('Courses::create' , compact('teachers', 'categories'));
    }

    public function store(CourseRequest $request, CourseRepo $courseRepo)
    {
        $request->request->add(['banner_id' => MediaFileService::upload($request->file('image'))->id]);
        $courseRepo->store($request);
        return redirect()->route('courses.index');
    }

    public function destroy($id, CourseRepo $courseRepo)
    {
        $course = $courseRepo->findById($id);

        if($course->banner){
            $course->banner->delete();
        }
        $course->delete();
        AjaxResponses::SuccessResponse();
    }
}
