<?php

namespace Abd\Course\Repositories;

use Abd\Course\Models\Course;
use Abd\Course\Models\Season;
use Illuminate\Support\Str;

class SeasonRepo
{
    public function store($id, $values)
    {
        if(is_null($values->number)){
            $courseRepo = new CourseRepo();
            $number = $courseRepo->findById($id)->seasons()->orderBy('number','desc')->firstOrNew([])->number ?: 0;
            $number++;
        }else{
            $number = $values->number;
        }
        return Season::create([
            "course_id" => $id,
            "user_id" => auth()->id(),
            "title" => $values->title,
            "number" => $number,
            "confirmation_status" => Season::CONFIRMATION_STATUS_PENDING
        ]);
    }

}
