<?php

namespace Abd\Media\Services;

use Abd\Media\Contracts\FileServiceContract;
use Illuminate\Support\Facades\Storage;

class VideoFileService extends DefaultFileService implements FileServiceContract
{
    public static function upload($file, $filename, $dir) : array
    {
        $extension = strtolower($file->getClientOriginalExtension());
        Storage::putFileAs($dir, $file, $filename . '.' . $extension);

        return ["video" => $filename . '.' . $extension];
    }

}
