<?php

namespace Abd\Discount\Http\Controllers;

use Abd\Course\Models\Course;
use Abd\Course\Repositories\CourseRepo;
use Abd\Discount\Http\Requests\DiscountRequest;
use Abd\Discount\Repositories\DiscountRepo;
use App\Http\Controllers\Controller;

class DiscountController extends Controller
{
    public function index(CourseRepo $courseRepo, DiscountRepo $discountRepo)
    {
        $discounts = $discountRepo->paginateAll();
        $courses = $courseRepo->getAll(Course::CONFIRMATION_STATUS_ACCEPTED);
        return view('Discounts::index', compact('courses', 'discounts'));
    }

    public function store(DiscountRequest $request, DiscountRepo $repo)
    {
        $repo->store($request->all());
        newFeedback();
        return back();
    }
}
