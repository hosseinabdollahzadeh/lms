<?php

namespace Abd\Media\Services;

use Abd\Media\Contracts\FileServiceContract;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ZipFileService extends DefaultFileService implements FileServiceContract
{
    public static function upload(UploadedFile $file, $filename, $dir): array
    {
        $extension = strtolower($file->getClientOriginalExtension());
        Storage::putFileAs($dir, $file, $filename . '.' . $extension);

        return ["zip" => $filename . '.' . $extension];
    }

}
