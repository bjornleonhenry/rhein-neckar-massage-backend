<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'name',
        'age',
        'gender',
        'height',
        'bust_size',
        'body_type',
        'origin',
        'clothing_size',
        'weight',
        'shoe_size',
        'intimate_area',
        'hair',
        'eyes',
        'skin',
        'body_jewelry',
        'languages',
        'other',
        'description',
        'image',
        'images',
        'main_image',
        'intercourse_options',
        'services_for',
        'services',
        'meetings',
        'massages',
        'schedule',
        'additional_info',
        'profile_options',
    ];

    protected $casts = [
        'languages' => 'array',
        'images' => 'array',
        'intercourse_options' => 'array',
        'services_for' => 'array',
        'services' => 'array',
        'meetings' => 'array',
        'massages' => 'array',
        'schedule' => 'array',
        'profile_options' => 'array',
    ];

    /**
     * Get the main image URL
     */
    public function getMainImageUrlAttribute()
    {
        if ($this->main_image) {
            // Skip temporary file paths
            if (str_contains($this->main_image, 'livewire-tmp')) {
                // Try to get the first image from the images array instead
                if ($this->images && is_array($this->images) && count($this->images) > 0) {
                    $firstImage = $this->images[0];
                    if (filter_var($firstImage, FILTER_VALIDATE_URL)) {
                        return $firstImage;
                    }
                    return $this->getCorrectStorageUrl('storage/' . $firstImage);
                }
                return null;
            }
            
            // Check if it's already a full URL
            if (filter_var($this->main_image, FILTER_VALIDATE_URL)) {
                return $this->main_image;
            }
            return $this->getCorrectStorageUrl('storage/' . $this->main_image);
        }
        
        // Fallback to the old image field
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
     * Get all image URLs
     */
    public function getImageUrlsAttribute()
    {
        $urls = [];
        
        if ($this->images && is_array($this->images)) {
            foreach ($this->images as $image) {
                // Check if it's already a full URL
                if (filter_var($image, FILTER_VALIDATE_URL)) {
                    $urls[] = $image;
                } else {
                    $urls[] = $this->getCorrectStorageUrl('storage/' . $image);
                }
            }
        }
        
        // Include the old image field if it exists and not already in images array
        if ($this->image && is_array($this->images) && !in_array($this->image, $this->images)) {
            // Check if it's already a full URL
            if (filter_var($this->image, FILTER_VALIDATE_URL)) {
                $urls[] = $this->image;
            } else {
                $urls[] = $this->getCorrectStorageUrl('storage/' . $this->image);
            }
        }
        
        return $urls;
    }

    /**
     * Set the main image from the images array
     */
    public function setMainImage($imagePath)
    {
        $this->main_image = $imagePath;
        $this->save();
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
