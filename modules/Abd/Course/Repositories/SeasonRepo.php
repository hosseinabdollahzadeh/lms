<?php

namespace Abd\Course\Repositories;

use Abd\Course\Models\Season;
use Illuminate\Support\Str;

class SeasonRepo
{
    public function getCourseSeasons($course)
    {
        return Season::where('course_id', $course)
            ->where('confirmation_status', Season::CONFIRMATION_STATUS_ACCEPTED)
            ->orderBy('number')->get();
    }

    public function findByIdandCourseId($seasonId, $courseId)
    {
        return Season::where('course_id', $courseId)->where('id', $seasonId)->first();
    }
    public function store($courseId, $values)
    {
        return Season::create([
            "course_id" => $courseId,
            "user_id" => auth()->id(),
            "title" => $values->title,
            "number" => $this->generateNumber($values->number, $courseId),
            "confirmation_status" => Season::CONFIRMATION_STATUS_PENDING,
            "status" => Season::STATUS_OPENED
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

    public function updateConfirmationStatus($id, string $status)
    {
        return Season::where('id', $id)->update(['confirmation_status'=> $status]);
    }

    public function updateStatus($id, string $status)
    {
        return Season::where('id', $id)->update(['status'=> $status]);
    }

}
