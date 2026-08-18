<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'category',
        'schedule_date',
        'start_time',
        'end_time',
        'location',
        'accent',
        'notes',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'schedule_date' => 'date',
            'is_active' => 'boolean',
        ];
    }

    public function timeRangeLabel(): ?string
    {
        if ($this->start_time && $this->end_time) {
            return "{$this->start_time} - {$this->end_time} WIB";
        }

        return $this->start_time ? "{$this->start_time} WIB" : null;
    }
}
