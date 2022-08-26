<?php

namespace Abd\Course;

use Abd\Course\Models\Course;
use Illuminate\Support\Str;

class CourseRepo
{
    public function store($values)
    {
        return Course::create([
            "teacher_id" => $values->teacher_id,
            "category_id" => $values->category_id,
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
}
