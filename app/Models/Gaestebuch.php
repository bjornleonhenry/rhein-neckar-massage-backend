<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gaestebuch extends Model
{
    protected $table = 'gaestebuchs';

    protected $fillable = [
        'name',
        'date',
        'rating',
        'service',
        'message',
        'verified'
    ];

    protected $casts = [
        'date' => 'date',
        'rating' => 'integer',
        'verified' => 'boolean'
    ];
}
