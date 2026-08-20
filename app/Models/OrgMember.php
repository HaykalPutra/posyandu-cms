<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrgMember extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'org_group_id',
        'name',
        'position',
        'photo_media_asset_id',
        'photo_url',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(OrgGroup::class, 'org_group_id');
    }

    public function photoMediaAsset(): BelongsTo
    {
        return $this->belongsTo(MediaAsset::class, 'photo_media_asset_id');
    }

    public function photoSrc(): ?string
    {
        if ($this->photo_media_asset_id) {
            return route('media.show', $this->photo_media_asset_id);
        }

        return $this->photo_url ?: null;
    }

    /**
     * Up to 2 uppercase initials from the member's name, used as a fallback
     * avatar whenever no photo has been uploaded - e.g. "Haykal Putra" -> "HP".
     */
    public function initials(): string
    {
        $words = array_values(array_filter(preg_split('/\s+/', trim($this->name)) ?: []));

        $letters = array_map(
            fn (string $word) => mb_strtoupper(mb_substr($word, 0, 1)),
            array_slice($words, 0, 2)
        );

        return $letters ? implode('', $letters) : '?';
    }

    /**
     * Deterministic background color for the initials avatar, picked from a
     * small brand-consistent palette based on the member's name - so the
     * same person always gets the same color across page loads.
     */
    public function avatarColor(): string
    {
        $palette = [
            '#1f7a53', '#b6763f', '#2f6fa8', '#a8456b',
            '#5c7a2f', '#7a4f9c', '#c2703a', '#2f8f8a',
        ];

        return $palette[crc32($this->name) % count($palette)];
    }
}
