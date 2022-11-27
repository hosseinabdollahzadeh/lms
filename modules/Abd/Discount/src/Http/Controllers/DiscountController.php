<?php

namespace Abd\Discount\Http\Controllers;

use Abd\Common\Responses\AjaxResponses;
use Abd\Course\Models\Course;
use Abd\Course\Repositories\CourseRepo;
use Abd\Discount\Http\Requests\DiscountRequest;
use Abd\Discount\Models\Discount;
use Abd\Discount\Repositories\DiscountRepo;
use Abd\Discount\Services\DiscountService;
use App\Http\Controllers\Controller;

class DiscountController extends Controller
{
    public function index(CourseRepo $courseRepo, DiscountRepo $discountRepo)
    {
        $this->authorize("manage", Discount::class);
        $discounts = $discountRepo->paginateAll();
        $courses = $courseRepo->getAll(Course::CONFIRMATION_STATUS_ACCEPTED);
        return view('Discounts::index', compact('courses', 'discounts'));
    }

    public function store(DiscountRequest $request, DiscountRepo $repo)
    {
        $this->authorize("manage", Discount::class);
        $repo->store($request->all());
        newFeedback();
        return back();
    }

    public function edit(Discount $discount, CourseRepo $courseRepo)
    {
        $this->authorize("manage", Discount::class);
        $courses = $courseRepo->getAll(Course::CONFIRMATION_STATUS_ACCEPTED);
        return view('Discounts::edit', compact('discount', 'courses'));
    }

    public function update(Discount $discount, DiscountRequest $request, DiscountRepo $repo)
    {
        $this->authorize("manage", Discount::class);
        $repo->update($discount->id, $request->all());
        newFeedback();
        return redirect()->route("discounts.index");
    }

    public function destroy(Discount $discount)
    {
        $this->authorize("manage", Discount::class);
        $discount->delete();
        return AjaxResponses::SuccessResponse();
    }

    public function check($code, Course $course, DiscountRepo $repo)
    {
        $discount = $repo->getValidDiscountByCode($code, $course->id);
        if ($discount) {
            $discountAmount = DiscountService::calculateDiscountAmount($course->price, $discount->percent);
            $discountPercent = $discount->percent;
            $response = [
                "status" => "valid",
                "payableAmount" => $course->price - $discountAmount,
                "discountAmount" => $discountAmount,
                "discountPercent" => $discountPercent
            ];
            return response()->json($response);
        }
        return response()->json([
            "status" => "invalid"
        ])->setStatusCode(422);
    }
}
