<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeStat extends Model
{
    protected $fillable = [
        'value',
        'label',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }
}
