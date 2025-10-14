<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SimpleSettingsModel extends Model
{
    protected $table = 'settings';

    protected $fillable = [
        'key',
        'title',
        'value',
        'type',
        'is_active',
    ];

    protected $casts = [
        'value' => 'json',
        'is_active' => 'boolean',
    ];

    public $timestamps = true;
}
