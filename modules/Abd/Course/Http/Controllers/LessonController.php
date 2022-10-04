<?php

namespace Abd\Course\Http\Controllers;

use Abd\Course\Repositories\CourseRepo;
use App\Http\Controllers\Controller;

class LessonController extends Controller
{
    public function create($course, CourseRepo $courseRepo)
    {
        $seasons = $courseRepo->getCourseSeasons($course);
        return view('Courses::lessons.create', compact('seasons'));
    }
}
