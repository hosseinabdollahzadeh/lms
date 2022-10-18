<?php

namespace Abd\Media\Services;

use Abd\Media\Contracts\FileServiceContract;
use Abd\Media\Models\Media;
use Illuminate\Support\Facades\Storage;

class VideoFileService extends DefaultFileService implements FileServiceContract
{
    public static function upload($file, $filename, $dir) : array
    {
        $extension = strtolower($file->getClientOriginalExtension());
        Storage::putFileAs($dir, $file, $filename . '.' . $extension);

        return ["video" => $filename . '.' . $extension];
    }

    public static function thumb(Media $media)
    {
        return url('/img/video-thumb.png');
    }

    public static function getFilename()
    {
        return (self::$media->is_private ? 'private/' : 'public/') . self::$media->files['video'];
    }
}
