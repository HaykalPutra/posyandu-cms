<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GalleryItem extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image_url',
        'image_media_asset_id',
        'captured_at',
        'is_featured',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'captured_at' => 'date',
            'is_featured' => 'boolean',
        ];
    }

    public function imageMediaAsset(): BelongsTo
    {
        return $this->belongsTo(MediaAsset::class, 'image_media_asset_id');
    }

    public function imageSrc(): ?string
    {
        if ($this->image_media_asset_id) {
            return route('media.show', $this->image_media_asset_id);
        }

        return $this->image_url;
    }
}
