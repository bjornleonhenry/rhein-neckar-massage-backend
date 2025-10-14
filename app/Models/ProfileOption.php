<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfileOption extends Model
{
    protected $fillable = [
        'category',
        'option_key',
        'option_value',
        'option_value_en',
        'description',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
