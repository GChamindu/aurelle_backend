<?php

namespace App\helpers;

use Illuminate\Support\Facades\Storage;

class R2Helper
{
    public static function storeFile($file, $path = 'uploads')
    {
        if (!$file) {
            return null;
        }

        return Storage::disk('s3')->put($path, $file);
    }

    public static function getFileUrl($filePath)
    {
        if (!$filePath) {
            return null;
        }

        return rtrim(env('AWS_URL'), '/') . '/' . ltrim($filePath, '/');
    }

    public static function deleteFile($filePath)
    {
        if (!$filePath) {
            return false;
        }

        return Storage::disk('s3')->delete($filePath);
    }

    public static function updateFile($newFile, $existingFilePath = null, $path = 'uploads')
    {
        if ($existingFilePath) {
            self::deleteFile($existingFilePath);
        }

        return self::storeFile($newFile, $path);
    }
}
