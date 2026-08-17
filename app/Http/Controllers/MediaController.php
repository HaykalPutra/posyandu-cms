<?php

namespace App\Http\Controllers;

use App\Models\MediaAsset;
use Illuminate\Http\Response;

class MediaController extends Controller
{
    public function show(MediaAsset $mediaAsset): Response
    {
        return response(base64_decode($mediaAsset->binary_data), 200, [
            'Content-Type' => $mediaAsset->mime_type,
            'Content-Length' => (string) $mediaAsset->size,
            'Cache-Control' => 'public, max-age=86400',
        ]);
    }
}
