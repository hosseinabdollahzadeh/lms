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
            "number" => $this->generateNumber($values->number, $courseId), // todo generate automatic number
            "season_id" => $values->season_id,
            "free" => $values->free,
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

    public function update($id, $values)
    {
        return Lesson::where('id', $id)->update([
            "teacher_id" => $values->teacher_id,
            "category_id" => $values->category_id,
            "banner_id" => $values->banner_id,
            "title" => $values->title,
            "slug" => Str::slug($values->slug),
            "number" => $values->priority,
            "price" => $values->price,
            "percent" => $values->percent,
            "type" => $values->type,
            "status" => $values->status,
            "body" => $values->body,
        ]);
    }

    public function updateConfirmationStatus($id, string $status)
    {
        return Lesson::where('id', $id)->update(['confirmation_status'=> $status]);
    }

    public function updateStatus($id, string $status)
    {
        return Lesson::where('id', $id)->update(['status'=> $status]);
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
}
