<?php

namespace Abd\Course\Http\Controllers;

use Abd\Course\Http\Requests\SeasonRequest;
use Abd\Course\Repositories\SeasonRepo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SeasonController extends Controller
{
    private $seasonRepo;
    public function __construct(SeasonRepo $seasonRepo)
    {
        $this->seasonRepo = $seasonRepo;
    }

    public function store($course, SeasonRequest $request)
    {
        $this->seasonRepo->store($course, $request);
        newFeedback();
        return back();
    }

    public function edit($id)
    {
        $season = $this->seasonRepo->findById($id);
        return view('Courses::seasons.edit', compact('season'));
    }

    public function update($id, SeasonRequest $request)
    {
        $this->seasonRepo->update($id, $request);
        newFeedback();
        return back();
    }
}
