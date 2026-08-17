<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaAsset extends Model
{
    protected $fillable = [
        'disk_name',
        'original_name',
        'mime_type',
        'size',
        'binary_data',
    ];
}
