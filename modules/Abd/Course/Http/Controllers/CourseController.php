<?php

namespace Abd\Course\Http\Controllers;

use Abd\Category\Repositories\CategoryRepo;
use Abd\Course\CourseRepo;
use Abd\Course\Http\Requests\CourseRequest;
use Abd\Media\Services\MediaUploadService;
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
        $request->request->add(['banner_id' => MediaUploadService::upload($request->file('image'))->id]);
        $courseRepo->store($request);
        return redirect()->route('courses.index');
    }
}
