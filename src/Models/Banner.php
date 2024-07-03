<?php

namespace Kenepa\Banner\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $table = 'banners';

    protected $fillable = [
        'data',
    ];

    protected $casts = [
        'data' => 'array',
    ];
}
