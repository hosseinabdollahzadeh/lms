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
    public function index()
    {
        return 'courses';
    }

    public function create(UserRepo $userRepo, CategoryRepo $categoryRepo)
    {
        $teachers = $userRepo->getTeachers();
        $categories = $categoryRepo->all();
        return view('Course::create' , compact('teachers', 'categories'));
    }

    public function store(CourseRequest $request, CourseRepo $courseRepo)
    {
        $request->request()->add(['benner_id' => MediaUploadService::upload($request->file('image'))->id]);
        $course = $courseRepo->store($request);
        return $course;
    }
}
