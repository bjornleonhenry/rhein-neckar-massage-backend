<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AngebotOption extends Model
{
    protected $fillable = [
        'angebot_id',
        'title',
        'angebot_price',
        'angebot_time',
        'is_active',
    ];

    protected $casts = [
        'angebot_price' => 'decimal:2',
        'angebot_time' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Get the angebot that owns this option.
     */
    public function angebot(): BelongsTo
    {
        return $this->belongsTo(Angebot::class);
    }
}
