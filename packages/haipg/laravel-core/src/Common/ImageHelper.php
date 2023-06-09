<?php

namespace HaiPG\LaravelCore\Common;

use Illuminate\Support\Facades\Storage;

class ImageHelper
{
    public static function generateStorageImage($file, $options = [], $name = null)
    {
        $path = 'images/' . time() . uniqid();

        $filename = $file->getClientOriginalName();
        if (!empty($name)) {
            $extension = $file->clientExtension();
            if (empty($extension)) {
                $extension = $file->getClientOriginalExtension();
                if (empty($extension)) {
                    $parse = explode('.', $file->getClientOriginalName());
                    $extension = end($parse);
                }
            }
            $filename = $name . '.' . $extension;
        }

        Storage::putFileAs(
            $path,
            $file,
            $filename,
            array_merge(['visibility' => 'private'], $options)
        );

        return $path . '/' . $filename;
    }

    public static function getImageData($image)
    {
        $fileSize = getimagesize($image);

        $imagePath = self::generateStorageImage($image);

        return [
            'name' => $image->getClientOriginalName(),
            'mime_type' => $image->getClientMimeType(),
            'extension' => $image->getClientOriginalExtension(),
            'size' => $image->getSize(),
            'witdh' => $fileSize[0],
            'height' => $fileSize[1],
            'path' => $imagePath
        ];
    }
}
