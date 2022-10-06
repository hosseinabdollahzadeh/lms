<?php

namespace Abd\Media\Services;

use Abd\Media\Models\Media;
use Illuminate\Support\Facades\Storage;

class DefaultFileService
{

    public static function delete(Media $media)
    {
        foreach ($media->files as $file){
            if($media->is_private){
                Storage::delete('private\\'.$file);
            }else{
                Storage::delete('public\\'.$file);
            }
        }
    }
}
