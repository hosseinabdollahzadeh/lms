<?php

namespace Abd\Discount\Models;

use Abd\Course\Models\Course;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $guarded = [];
    protected $casts = [
        "expire_at" => "datetime"
    ];
    public function courses()
    {
        return $this->morphedByMany(Course::class, 'discountable');
    }
}
