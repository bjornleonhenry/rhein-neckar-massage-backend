<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mieterin extends Model
{
    protected $table = 'mieterinnen';

    protected $fillable = [
        'name',
        'age',
        'description',
        'image',
        'specialties',
        'languages',
        'working_hours',
        'rating',
    ];

    protected $casts = [
        'specialties' => 'array',
        'languages' => 'array',
        'rating' => 'decimal:1',
    ];

    /**
     * Get the image URL
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            // Check if it's already a full URL
            if (filter_var($this->image, FILTER_VALIDATE_URL)) {
                return $this->image;
            }
            return $this->getCorrectStorageUrl('storage/' . $this->image);
        }
        return null;
    }

    /**
     * Get the correct storage URL, replacing 0.0.0.0 with localhost
     */
    private function getCorrectStorageUrl($path)
    {
        $url = asset($path);
        // Replace 0.0.0.0 with localhost to fix CORS issues, preserving protocol
        return str_replace(['http://0.0.0.0:', 'https://0.0.0.0:'], ['http://localhost:', 'https://localhost:'], $url);
    }
}
