<?php

namespace Abd\Slider\Http\Controllers;

use Abd\Common\Responses\AjaxResponses;
use Abd\Media\Services\MediaFileService;
use Abd\Slider\Http\Requests\SlideRequest;
use Abd\Slider\Models\Slide;
use Abd\Slider\Repositories\SlideRepo;
use App\Http\Controllers\Controller;

class SlideController extends Controller
{
    public function index(SlideRepo $repo)
    {
        $this->authorize('manage', Slide::class);
        $slides = $repo->all();
        return view('Sliders::index', compact('slides'));
    }

    public function store(SlideRequest $request, SlideRepo $repo)
    {
        $this->authorize('manage', Slide::class);
        $request->request->add(['media_id' => MediaFileService::publicUpload($request->file('image'))->id]);
        $repo->store($request);
        newFeedback();
        return redirect()->route('slides.index');
    }

    public function edit(Slide $slide)
    {
        $this->authorize('manage', Slide::class);
        return view('Sliders::edit', compact('slide'));
    }

    public function update(Slide $slide, SlideRepo $repo, SlideRequest $request)
    {
        $this->authorize('manage', Slide::class);
        if ($request->hasFile('image')) {
            $request->request->add(['media_id' => MediaFileService::publicUpload($request->file('image'))->id]);
            if ($slide->media) {
                $slide->media->delete();
            }
        } else {
            $request->request->add(['media_id' => $slide->media_id]);
        }
        $repo->update($slide->id, $request);
        newFeedback();
        return redirect()->route('slides.index');
    }

    public function destroy(Slide $slide)
    {
        $this->authorize('manage', Slide::class);
        if ($slide->media) {
            $slide->media->delete();
        }
        $slide->delete();
        return AjaxResponses::SuccessResponse();
    }
}
