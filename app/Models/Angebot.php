<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Angebot extends Model
{
    protected $fillable = [
        'title',
        'description',
        'price',
        'duration_minutes',
        'category',
        'image',
        'services',
        'is_active',
    ];

    protected $casts = [
        'services' => 'array',
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];
}
