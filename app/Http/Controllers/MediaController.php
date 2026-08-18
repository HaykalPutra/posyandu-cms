<?php

namespace App\Http\Controllers;

use App\Models\MediaAsset;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MediaController extends Controller
{
    /**
     * Serves an image. New uploads live on the "public" disk and are
     * streamed straight from there - no more decoding base64 out of the
     * database on every request. Old records created before this change
     * (which only have binary_data, no file on disk yet) still work via
     * the fallback below, so nothing that was already uploaded breaks.
     */
    public function show(MediaAsset $mediaAsset): Response|StreamedResponse
    {
        if ($mediaAsset->disk_name && Storage::disk('public')->exists($mediaAsset->disk_name)) {
            return Storage::disk('public')->response(
                $mediaAsset->disk_name,
                $mediaAsset->original_name,
                [
                    'Content-Type' => $mediaAsset->mime_type,
                    'Cache-Control' => 'public, max-age=86400',
                ]
            );
        }

        if ($mediaAsset->binary_data) {
            return response(base64_decode($mediaAsset->binary_data), 200, [
                'Content-Type' => $mediaAsset->mime_type,
                'Content-Length' => (string) $mediaAsset->size,
                'Cache-Control' => 'public, max-age=86400',
            ]);
        }

        abort(404);
    }
}