<?php

namespace Abd\Course\Repositories;

use Abd\Course\Models\Lesson;
use Illuminate\Support\Str;

class LessonRepo
{
    public function store($values, $courseId)
    {
        return Lesson::create([
            "title" => $values->title,
            "slug" => $values->slug ? Str::slug($values->slug) : Str::slug($values->title),
            "time" => $values->time,
            "number" => $this->generateNumber($values->number, $courseId),
            "season_id" => $values->season_id,
            "is_free" => $values->is_free,
            "media_id" => $values->media_id,
            "course_id" => $courseId,
            "user_id" => auth()->id(),
            "body" => $values->body,
            "confirmation_status" => Lesson::CONFIRMATION_STATUS_PENDING,
            "status" => Lesson::STATUS_OPENED
        ]);
    }

    public function paginate($courseId)
    {
        return Lesson::where('course_id', $courseId)->orderBy('number')->paginate();
    }

    public function findById($id)
    {
        return Lesson::findOrFail($id);
    }

    public function update($id, $courseId, $values)
    {
        return Lesson::where('id', $id)->update([
            "title" => $values->title,
            "slug" => $values->slug ? Str::slug($values->slug) : Str::slug($values->title),
            "time" => $values->time,
            "number" => $this->generateNumber($values->number, $courseId),
            "season_id" => $values->season_id,
            "is_free" => $values->is_free,
            "media_id" => $values->media_id,
            "body" => $values->body,
        ]);
    }

    public function updateConfirmationStatus($id, string $status)
    {
        if (is_array($id)) {
            return Lesson::query()->whereIn('id', $id)->update(['confirmation_status' => $status]);
        }
        return Lesson::where('id', $id)->update(['confirmation_status' => $status]);
    }

    public function updateStatus($id, string $status)
    {
        return Lesson::where('id', $id)->update(['status' => $status]);
    }

    private function generateNumber($number, $courseId)
    {
        if (is_null($number)) {
            $courseRepo = new CourseRepo();
            $number = $courseRepo->findById($courseId)->lessons()->orderBy('number', 'desc')->firstOrNew([])->number ?: 0;
            $number++;
        }
        return $number;
    }

    public function acceptAll($courseId)
    {
        return Lesson::query()->where('course_id', $courseId)->update(['confirmation_status' => Lesson::CONFIRMATION_STATUS_ACCEPTED]);
    }

    public function getAcceptedLessons(int $courseId)
    {
        return Lesson::where('course_id', $courseId)
            ->where('confirmation_status', Lesson::CONFIRMATION_STATUS_ACCEPTED)->get();
    }

    public function getFirstLesson(int $courseId)
    {
        return Lesson::where('course_id', $courseId)
            ->where('confirmation_status', Lesson::CONFIRMATION_STATUS_ACCEPTED)
            ->orderBy('number', 'asc')->first();
    }

    public function getLesson(int $courseId, int $lessonId)
    {
        return Lesson::where('course_id', $courseId)->where('id', $lessonId)->first();
    }

}
