<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'category',
        'excerpt',
        'body',
        'cover_image',
        'cover_media_asset_id',
        'is_published',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    public function coverMediaAsset(): BelongsTo
    {
        return $this->belongsTo(MediaAsset::class, 'cover_media_asset_id');
    }

    public function coverImageSrc(): ?string
    {
        if ($this->cover_media_asset_id) {
            return route('media.show', $this->cover_media_asset_id);
        }

        return $this->cover_image;
    }
}
