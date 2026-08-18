<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CmsPage extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'slug',
        'nav_label',
        'title',
        'subtitle',
        'body',
        'hero_image',
        'hero_media_asset_id',
        'meta',
        'is_published',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'meta' => 'array',
        ];
    }

    public function heroMediaAsset(): BelongsTo
    {
        return $this->belongsTo(MediaAsset::class, 'hero_media_asset_id');
    }

    public function heroImageSrc(): ?string
    {
        if ($this->hero_media_asset_id) {
            return route('media.show', $this->hero_media_asset_id);
        }

        return $this->hero_image;
    }
}
