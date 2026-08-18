<?php

namespace App\Http\Controllers;

use App\Models\MediaAsset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

abstract class Controller
{
    /**
     * Stores an uploaded image on the "public" disk (storage/app/public,
     * symlinked to public/storage) and records it as a MediaAsset row.
     * Only the file path is kept in the database - not the file's bytes -
     * so the database stays small and images are served as plain static
     * files instead of being decoded from base64 on every request.
     */
    protected function storeUploadedImage(Request $request, string $field, string $directory, ?string $currentValue = null): ?int
    {
        if (! $request->hasFile($field)) {
            return null;
        }

        $file = $request->file($field);
        $mimeType = $file->getMimeType() ?: 'application/octet-stream';
        $rawContents = (string) file_get_contents($file->getRealPath());

        [$contents, $mimeType] = $this->optimizeImage($rawContents, $mimeType);

        $extension = match ($mimeType) {
            'image/png' => 'png',
            'image/webp' => 'webp',
            'image/jpeg' => 'jpg',
            default => $file->getClientOriginalExtension() ?: 'bin',
        };

        $path = trim($directory, '/') . '/' . Str::random(20) . '.' . $extension;

        Storage::disk('public')->put($path, $contents);

        $mediaAsset = MediaAsset::create([
            'disk_name' => $path,
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $mimeType,
            'size' => strlen($contents),
            'binary_data' => null,
        ]);

        return $mediaAsset->id;
    }

    /**
     * Resize + compress raster images (jpeg/png/webp) before they're stored.
     * Phone camera photos are often 3-5MB; this brings them down to a
     * reasonable web size so the public site stays fast and the database
     * doesn't bloat. Falls back to the original, untouched bytes if the GD
     * extension isn't available or the file isn't a format GD can decode -
     * it never blocks an upload, it just skips optimizing it.
     *
     * @return array{0: string, 1: string} [binary contents, mime type]
     */
    private function optimizeImage(string $contents, string $mimeType, int $maxWidth = 1600, int $quality = 78): array
    {
        if (! function_exists('gd_info') || ! in_array($mimeType, ['image/jpeg', 'image/png', 'image/webp'], true)) {
            return [$contents, $mimeType];
        }

        $image = @imagecreatefromstring($contents);

        if ($image === false) {
            return [$contents, $mimeType];
        }

        $width = imagesx($image);
        $height = imagesy($image);

        if ($width > $maxWidth) {
            $newWidth = $maxWidth;
            $newHeight = (int) round($height * ($maxWidth / $width));

            $resized = imagecreatetruecolor($newWidth, $newHeight);

            if (in_array($mimeType, ['image/png', 'image/webp'], true)) {
                imagealphablending($resized, false);
                imagesavealpha($resized, true);
            }

            imagecopyresampled($resized, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            imagedestroy($image);
            $image = $resized;
        }

        ob_start();

        match ($mimeType) {
            'image/png' => imagepng($image, null, 6),
            'image/webp' => imagewebp($image, null, $quality),
            default => imagejpeg($image, null, $quality),
        };

        $optimized = ob_get_clean();
        imagedestroy($image);

        if (empty($optimized)) {
            return [$contents, $mimeType];
        }

        return [$optimized, $mimeType];
    }

    /**
     * Permanently deletes a media asset row. Only call this for a record
     * that is being force-deleted from Sampah (Trash) - never from a normal
     * "Hapus" action, since the record's own delete() is now a soft delete
     * and the image should stay intact in case the record gets restored.
     */
    /**
     * Permanently deletes a media asset - its physical file on disk (if any)
     * and its database row. Only call this for a record that is being
     * force-deleted from Sampah (Trash) - never from a normal "Hapus"
     * action, since the record's own delete() is now a soft delete and the
     * image should stay intact in case the record gets restored.
     */
    protected function deleteDatabaseMedia(?int $mediaId): void
    {
        if (! $mediaId) {
            return;
        }

        $mediaAsset = MediaAsset::find($mediaId);

        if (! $mediaAsset) {
            return;
        }

        if ($mediaAsset->disk_name) {
            Storage::disk('public')->delete($mediaAsset->disk_name);
        }

        $mediaAsset->delete();
    }
}