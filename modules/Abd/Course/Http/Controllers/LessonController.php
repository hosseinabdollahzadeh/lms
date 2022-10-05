<?php

namespace Abd\Course\Http\Controllers;

use Abd\Course\Http\Requests\LessonRequest;
use Abd\Course\Repositories\CourseRepo;
use Abd\Course\Repositories\LessonRepo;
use Abd\Course\Repositories\SeasonRepo;
use Abd\Media\Services\MediaFileService;
use App\Http\Controllers\Controller;

class LessonController extends Controller
{
    private LessonRepo $lessonRepo;

    public function __construct(LessonRepo $lessonRepo)
    {
        $this->lessonRepo = $lessonRepo;
    }

    public function create($course, SeasonRepo $seasonRepo, CourseRepo $courseRepo)
    {
        $seasons = $seasonRepo->getCourseSeasons($course);
        $course = $courseRepo->findById($course);
        return view('Courses::lessons.create', compact('seasons', 'course'));
    }

    public function store($course, LessonRequest $request)
    {
        $request->request->add(['media_id' => MediaFileService::upload($request->file('lesson_file'))->id]);
        $this->lessonRepo->store($request, $course);
        newFeedback();

        return redirect(route('courses.details', $course));
    }
}
