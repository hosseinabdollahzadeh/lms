<?php

namespace Abd\Media\Http\Controllers;

use Abd\Media\Models\Media;
use Abd\Media\Services\MediaFileService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function download(Media $media, Request $request)
    {
        if(!$request->hasValidSignature()){
            abort(401);
        }
        return MediaFileService::stream($media);
    }
}
