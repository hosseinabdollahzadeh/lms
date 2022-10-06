<?php
return [
    "MediaTypeServices" => [
        "image" => [
            "extensions" => ['jpg', 'png', 'jpeg'],
            "handler" => \Abd\Media\Services\ImageFileService::class
        ],
        "video" => [
            "extensions" => ['avi', 'mkv', 'mp4'],
            "handler" => \Abd\Media\Services\VideoFileService::class
        ],
        "zip" => [
            "extensions" => ['zip', 'rar'],
            "handler" => \Abd\Media\Services\ZipFileService::class
        ]
    ]
];
