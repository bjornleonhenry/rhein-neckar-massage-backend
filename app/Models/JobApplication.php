<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    protected $table = 'job_applications';

    protected $fillable = [
        'first_name',
        'last_name',
        'age',
        'nationality',
        'languages',
        'email',
        'phone',
        'experience',
        'availability',
        'specialties',
        'motivation',
        'references',
        'status',
        'is_read'
    ];

    protected $casts = [
        'specialties' => 'array',
        'is_read' => 'boolean',
        'age' => 'integer'
    ];
}
