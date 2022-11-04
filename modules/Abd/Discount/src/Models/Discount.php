<?php

namespace Abd\Discount\Models;

use Abd\Course\Models\Course;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    public function courses()
    {
        return $this->morphedByMany(Course::class, 'discountable');
    }
}
