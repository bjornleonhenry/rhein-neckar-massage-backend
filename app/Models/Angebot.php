<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    /**
     * Get the options for this angebot.
     */
    public function options(): HasMany
    {
        return $this->hasMany(AngebotOption::class);
    }
}
