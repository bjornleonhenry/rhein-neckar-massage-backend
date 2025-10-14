<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'bookings';

    protected $fillable = [
        'girl',
        'service',
        'date',
        'time',
        'name',
        'phone',
        'email',
        'message',
        'special_requests',
        'status',
        'is_read',
        'price',
        'duration'
    ];

    protected $casts = [
        'date' => 'date',
        'time' => 'datetime:H:i',
        'is_read' => 'boolean',
        'price' => 'decimal:2'
    ];
}
