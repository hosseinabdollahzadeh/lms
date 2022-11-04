<?php

namespace Abd\Discount\Http\Controllers;

use Abd\Course\Models\Course;
use Abd\Course\Repositories\CourseRepo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function index(CourseRepo $repo)
    {
        $courses = $repo->getAll(Course::CONFIRMATION_STATUS_ACCEPTED);
        return view('Discounts::index', compact('courses'));
    }
}
