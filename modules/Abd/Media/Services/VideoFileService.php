<?php

namespace Abd\Media\Services;

use Abd\Media\Contracts\FileServiceContract;
use Abd\Media\Models\Media;
use Illuminate\Support\Facades\Storage;

class VideoFileService implements FileServiceContract
{
    public static function upload($file, $filename, $dir) : array
    {
        $extension = strtolower($file->getClientOriginalExtension());
        Storage::putFileAs($dir, $file, $filename . '.' . $extension);

        return ["video" => $dir . $filename . '.' . $extension];
    }

    public static function delete(Media $media)
    {
        // TODO: Implement delete() method.
    }
}
