<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ambient extends Model
{
    protected $fillable = [
        'name',
        'description',
        'type',
        'location',
        'capacity',
        'size',
        'features',
        'amenities',
        'image',
        'rating',
        'is_active',
    ];

    protected $casts = [
        'features' => 'array',
        'amenities' => 'array',
        'rating' => 'decimal:1',
        'is_active' => 'boolean',
        'capacity' => 'integer',
    ];
}
