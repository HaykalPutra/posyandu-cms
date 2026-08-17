<?php

namespace App\Http\Controllers;

use App\Models\MediaAsset;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

abstract class Controller
{
    protected function storeUploadedImage(Request $request, string $field, string $directory, ?string $currentValue = null): ?int
    {
        if (! $request->hasFile($field)) {
            return null;
        }

        $file = $request->file($field);

        $mediaAsset = MediaAsset::create([
            'disk_name' => trim($directory . '/' . Str::random(20), '/'),
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType() ?: 'application/octet-stream',
            'size' => $file->getSize() ?: 0,
            'binary_data' => base64_encode((string) file_get_contents($file->getRealPath())),
        ]);

        return $mediaAsset->id;
    }

    protected function deleteDatabaseMedia(?int $mediaId): void
    {
        if (! $mediaId) {
            return;
        }

        MediaAsset::query()->whereKey($mediaId)->delete();
    }
}
