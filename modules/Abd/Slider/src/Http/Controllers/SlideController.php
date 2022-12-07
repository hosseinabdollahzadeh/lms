<?php

namespace Abd\Slider\Http\Controllers;

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
    public function edit()
    {
        $this->authorize('manage', Slide::class);

    }
    public function update()
    {
        $this->authorize('manage', Slide::class);

    }
    public function destroy()
    {
        $this->authorize('manage', Slide::class);

    }
}
