<?php

namespace App\Http\Controllers;

use App\helpers\R2Helper;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|image',
        ]);

        $file = $request->file('file');

        if (!$file->isValid()) {
            return response()->json([
                'success' => false,
                'message' => 'The file failed to upload.'
            ], 400);
        }

        $path = R2Helper::storeFile($file, 'categories');

        return response()->json([
            'success' => true,
            'url' => $path
        ]);
    }


    public function uploadProducts(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Upload to R2 (S3)
        $filePath = R2Helper::storeFile($request->file('file'), 'products');

        // dd($filePath);

        if (!$filePath) {
            return response()->json([
                'success' => false,
                'message' => 'Upload failed'
            ], 500);
        }

        return response()->json([
            'success' => true,
            'path' => $filePath,
            'url' => R2Helper::getFileUrl($filePath),
        ]);
    }
}
