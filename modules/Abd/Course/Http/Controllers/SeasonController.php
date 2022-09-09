<?php

namespace Abd\Course\Http\Controllers;

use Abd\Common\Responses\AjaxResponses;
use Abd\Course\Http\Requests\SeasonRequest;
use Abd\Course\Models\Season;
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

    public function destroy($id)
    {
        $season = $this->seasonRepo->findById($id);
        $season->delete();
        return AjaxResponses::SuccessResponse();
    }

    public function accept($id)
    {
        if ($this->seasonRepo->updateConfirmationStatus($id, Season::CONFIRMATION_STATUS_ACCEPTED)) {
            return AjaxResponses::SuccessResponse();
        } else {
            return AjaxResponses::FailedResponse();
        }
    }

    public function reject($id)
    {
        if ($this->seasonRepo->updateConfirmationStatus($id, Season::CONFIRMATION_STATUS_REJECTED)) {
            return AjaxResponses::SuccessResponse();
        } else {
            return AjaxResponses::FailedResponse();
        }
    }

    public function lock($id)
    {
        if ($this->seasonRepo->updateStatus($id, Season::STATUS_LOCKED)) {
            return AjaxResponses::SuccessResponse();
        } else {
            return AjaxResponses::FailedResponse();
        }
    }

    public function unlock($id)
    {
        if ($this->seasonRepo->updateStatus($id, Season::STATUS_OPENED)) {
            return AjaxResponses::SuccessResponse();
        } else {
            return AjaxResponses::FailedResponse();
        }
    }
}
