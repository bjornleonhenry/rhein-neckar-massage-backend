<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'age' => $this->age,
            'gender' => $this->gender,
            'height' => $this->height,
            'bust_size' => $this->bust_size,
            'body_type' => $this->body_type,
            'origin' => $this->origin,
            'clothing_size' => $this->clothing_size,
            'weight' => $this->weight,
            'shoe_size' => $this->shoe_size,
            'intimate_area' => $this->intimate_area,
            'hair' => $this->hair,
            'eyes' => $this->eyes,
            'skin' => $this->skin,
            'body_jewelry' => $this->body_jewelry,
            'languages' => $this->languages,
            'other' => $this->other,
            'description' => $this->description,
            'image' => $this->image,
            'images' => $this->images,
            'main_image' => $this->main_image,
            'main_image_url' => $this->main_image_url,
            'image_urls' => $this->image_urls,
            'intercourse_options' => $this->intercourse_options,
            'services_for' => $this->services_for,
            'services' => $this->services,
            'meetings' => $this->meetings,
            'massages' => $this->massages,
            'schedule' => $this->schedule,
            'additional_info' => $this->additional_info,
            'profile_options' => $this->profile_options,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

