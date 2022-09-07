<?php

namespace Abd\Course\Http\Controllers;

use Abd\Course\Http\Requests\SeasonRequest;
use Abd\Course\Repositories\SeasonRepo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SeasonController extends Controller
{
    public function store($course, SeasonRequest $request, SeasonRepo $seasonRepo)
    {
        $seasonRepo->store($course, $request);
        newFeedback();
        return back();
    }
}
