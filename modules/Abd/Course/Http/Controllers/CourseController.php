<?php

namespace Abd\Course\Http\Controllers;

use Abd\Category\Repositories\CategoryRepo;
use Abd\Category\Responses\AjaxResponses;
use Abd\Course\CourseRepo;
use Abd\Course\Http\Requests\CourseRequest;
use Abd\Course\Models\Course;
use Abd\Media\Models\Media;
use Abd\Media\Services\MediaFileService;
use Abd\User\Repositories\UserRepo;
use App\Http\Controllers\Controller;

class CourseController extends Controller
{
    public function index(CourseRepo $courseRepo)
    {
        $this->authorize('manage', Course::class);
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

    public function edit($id, CourseRepo $courseRepo,UserRepo $userRepo, CategoryRepo $categoryRepo)
    {
        $teachers = $userRepo->getTeachers();
        $categories = $categoryRepo->all();
        $course = $courseRepo->findById($id);
        return view('Courses::edit', compact('course', 'teachers', 'categories'));

    }

    public function update($id, CourseRequest $request, CourseRepo $courseRepo)
    {
        $course = $courseRepo->findById($id);
        if($request->hasFile('image')){
            $request->request->add(['banner_id' => MediaFileService::upload($request->file('image'))->id]);
            $course->banner->delete();
        }else{
            $request->request->add(['banner_id'=> $course->banner_id]);
        }
        $courseRepo->update($id, $request);
        return redirect(route('courses.index'));
    }

    public function accept($id, CourseRepo $courseRepo)
    {
        if($courseRepo->updateConfirmationStatus($id, Course::CONFIRMATION_STATUS_ACCEPTED)){
            AjaxResponses::SuccessResponse();
        }else{
            AjaxResponses::FailedResponse();
        }
    }
    public function reject($id, CourseRepo $courseRepo)
    {
        if($courseRepo->updateConfirmationStatus($id, Course::CONFIRMATION_STATUS_REJECTED)){
            AjaxResponses::SuccessResponse();
        }else{
            AjaxResponses::FailedResponse();
        }
    }
    public function lock($id, CourseRepo $courseRepo)
    {
        if($courseRepo->updateStatus($id, Course::STATUS_LOCKED)){
            AjaxResponses::SuccessResponse();
        }else{
            AjaxResponses::FailedResponse();
        }
    }
}
