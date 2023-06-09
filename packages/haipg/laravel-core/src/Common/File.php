<?php

namespace HaiPG\LaravelCore\Common;

use Illuminate\Support\Facades\Storage;

class File
{
    public static function generateStorageFile($file)
    {
        $path = 'files/' . time();

        Storage::putFileAs(
            $path,
            $file,
            $file->getClientOriginalName(),
            [ 'visibility' => 'public' ]
        );

        return Storage::url($path . '/' . $file->getClientOriginalName());
    }

    public static function getFileFromBase64($base64string)
    {
        $extension              = explode('/', mime_content_type($base64string))[1];
        list($baseType, $image) = explode(';', $base64string);
        list(, $image)          = explode(',', $image);

        $content  = base64_decode($image);
        $filename = md5( uniqid() ) . time() . "." .$extension;

        return ['content' => $content, 'filename' => $filename];
    }
}
