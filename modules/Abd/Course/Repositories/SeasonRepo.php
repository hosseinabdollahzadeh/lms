<?php

namespace Abd\Course\Repositories;

use Abd\Course\Models\Course;
use Abd\Course\Models\Season;
use Illuminate\Support\Str;

class SeasonRepo
{
    public function store($courseId, $values)
    {
        return Season::create([
            "course_id" => $courseId,
            "user_id" => auth()->id(),
            "title" => $values->title,
            "number" => $this->generateNumber($values->number, $courseId),
            "confirmation_status" => Season::CONFIRMATION_STATUS_PENDING
        ]);
    }

    public function findById($id)
    {
        return Season::findOrFail($id);
    }

    public function update($id, $values)
    {
        $season = $this->findById($id);
        $courseId = $season->course_id;
        return $season->update([
            "title" => $values->title,
            "number" => $this->generateNumber($values->number, $courseId)
        ]);
    }

    private function generateNumber($number, $courseId)
    {
        if (is_null($number)) {
            $courseRepo = new CourseRepo();
            $number = $courseRepo->findById($courseId)->seasons()->orderBy('number', 'desc')->firstOrNew([])->number ?: 0;
            $number++;
        }
        return $number;
    }

}
