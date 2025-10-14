<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'service',
        'date',
        'time',
        'message',
        'is_read'
    ];

    protected $casts = [
        'date' => 'date',
        'time' => 'datetime:H:i',
        'is_read' => 'boolean'
    ];
}
