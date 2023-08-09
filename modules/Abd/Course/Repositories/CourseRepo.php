<?php

namespace Abd\Course\Repositories;

use Abd\Course\Models\Course;
use Abd\Course\Models\Lesson;
use Illuminate\Support\Str;

class CourseRepo
{
    public $query;

    public function __construct()
    {
        $this->query = Course::query();
    }

    public function store($values)
    {
        return Course::create([
            "teacher_id" => $values->teacher_id,
            "category_id" => $values->category_id,
            "banner_id" => $values->banner_id,
            "title" => $values->title,
            "slug" => Str::slug($values->slug),
            "priority" => $values->priority,
            "price" => $values->price,
            "percent" => $values->percent,
            "type" => $values->type,
            "status" => $values->status,
            "body" => $values->body,
            "confirmation_status" => Course::CONFIRMATION_STATUS_PENDING
        ]);
    }

    public function paginate($perPage = 10)
    {
        return $this->query->paginate($perPage);
    }

    public function findById($id)
    {
        return Course::findOrFail($id);
    }

    public function update($id, $values)
    {
        return Course::where('id', $id)->update([
            "teacher_id" => $values->teacher_id,
            "category_id" => $values->category_id,
            "banner_id" => $values->banner_id,
            "title" => $values->title,
            "slug" => Str::slug($values->slug),
            "priority" => $values->priority,
            "price" => $values->price,
            "percent" => $values->percent,
            "type" => $values->type,
            "status" => $values->status,
            "body" => $values->body,
        ]);
    }

    public function updateConfirmationStatus($id, string $status)
    {
        return Course::where('id', $id)->update(['confirmation_status' => $status]);
    }

    public function updateStatus($id, string $status)
    {
        return Course::where('id', $id)->update(['status' => $status]);
    }

    public function getCoursesByTeacherId(int|string|null $id)
    {
        $this->query->where('teacher_id', $id)->get();
        return $this;
    }

    public function latestCourses()
    {
        return Course::where('confirmation_status', Course::CONFIRMATION_STATUS_ACCEPTED)->latest()->take(8)->get();
    }

    public function allCourses()
    {
        return Course::where('confirmation_status', Course::CONFIRMATION_STATUS_ACCEPTED)->latest()->paginate();
    }


    public function popularCourses()
    {
        return Course::select('courses.*')
            ->join('course_user', 'courses.id', '=', 'course_user.course_id')
            ->groupBy('courses.id')
            ->orderByRaw('COUNT(course_user.user_id) DESC')
            ->take(8)
            ->get();
    }

    public function getDuration($id)
    {
        return $this->getLessonsQuery($id)->sum('time');
    }

    public function getLessons($id)
    {
        return $this->getLessonsQuery($id)->get();
    }

    public function getLessonsCount($id)
    {
        return $this->getLessonsQuery($id)->count();
    }

    public function addStudentToCourse(Course $course, $studentId)
    {
        if (!$this->getCourseStudentById($course, $studentId)) {
            return $course->students()->attach($studentId);
        }
    }

    public function getCourseStudentById(Course $course, $studentId)
    {
        return $course->students()->where('id', $studentId)->first();
    }

    public function hasStudent(Course $course, $studentId)
    {
        return $course->students->contains($studentId);
    }

    private function getLessonsQuery($id)
    {
        return Lesson::where('course_id', $id)
            ->where('confirmation_status', Lesson::CONFIRMATION_STATUS_ACCEPTED);
    }

    public function getAll(string $confirmationStatus = null)
    {
        $query = Course::query();
        if ($confirmationStatus) $query->where('confirmation_status', $confirmationStatus);
        return $query->latest()->get();
    }

    public function getCoursesByCategoryId($categoryId)
    {
        $this->query->where('confirmation_status', Course::CONFIRMATION_STATUS_ACCEPTED)
            ->where('category_id', $categoryId)
            ->latest()->get();
        return $this;
    }

    public function searchConfirmationStatus($status)
    {
        if ($status)
            $this->query->where('confirmation_status', $status);
        return $this;
    }
}
