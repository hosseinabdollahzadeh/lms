<?php

namespace Abd\Media\Services;

use Abd\Media\Contracts\FileServiceContract;
use Abd\Media\Models\Media;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ImageFileService extends DefaultFileService implements FileServiceContract
{
    protected static $sizes = ['300', '600'];
    public static function upload($file, $filename, $dir) : array
    {
        $extension = strtolower($file->getClientOriginalExtension());
        Storage::putFileAs($dir,$file,$filename.'.'.$extension);
        $path = $dir.$filename.'.'.$extension;
        return self::resize(Storage::path($path),$dir, $filename, $extension);
    }

    private static function resize($img, $dir, $filename, $extension)
    {
        $img = Image::make($img);
        $imgs['original'] = $filename.'.'.$extension;
        foreach (self::$sizes as $size){
            $imgs[$size] = $filename.'_'.$size.'.'.$extension;
            $img->resize($size, null, function ($aspect){
                $aspect->aspectRatio();
            })->save(Storage::path($dir).$filename.'_'.$size.'.'.$extension);
        }
        return $imgs;
    }

    public static function getFilename()
    {
        return (static::$media->is_private ? 'private/' : 'public/') . static::$media->files['original'];
    }

    public static function thumb(Media $media)
    {
        return '/storage/'.$media->files[300];
    }
}
