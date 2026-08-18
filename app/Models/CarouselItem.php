<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CarouselItem extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'subtitle',
        'image_url',
        'image_media_asset_id',
        'link_url',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
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
