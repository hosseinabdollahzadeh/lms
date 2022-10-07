<?php

namespace Abd\Course\Http\Controllers;

use Abd\Common\Responses\AjaxResponses;
use Abd\Course\Http\Requests\LessonRequest;
use Abd\Course\Repositories\CourseRepo;
use Abd\Course\Repositories\LessonRepo;
use Abd\Course\Repositories\SeasonRepo;
use Abd\Media\Services\MediaFileService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        $request->request->add(['media_id' => MediaFileService::privateUpload($request->file('lesson_file'))->id]);
        $this->lessonRepo->store($request, $course);
        newFeedback();

        return redirect(route('courses.details', $course));
    }

    public function destroy($courseId, $lessonId)
    {
        $lesson = $this->lessonRepo->findById($lessonId);
        if($lesson->media)
            $lesson->media->delete();
        $lesson->delete();
        return AjaxResponses::SuccessResponse();
    }

    public function destroyMultiple(Request $request)
    {
        $ids = explode(',', $request->ids);
        foreach ($ids as $id){
            $lesson = $this->lessonRepo->findById($id);
            if($lesson->media)
                $lesson->media->delete();
            $lesson->delete();
        }
        newFeedback();
        return back();
    }
}
