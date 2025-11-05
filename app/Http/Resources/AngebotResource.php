<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AngebotResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
            'duration_minutes' => $this->duration_minutes,
            'category' => $this->category,
            'image' => $this->image ? asset('storage/' . $this->image) : null,
            'services' => $this->services,
            'is_active' => $this->is_active,
            'options' => $this->options->map(function ($option) {
                return [
                    'id' => $option->id,
                    'title' => $option->title,
                    'price' => $option->angebot_price,
                    'duration_minutes' => $option->angebot_time,
                    'is_active' => $option->is_active,
                ];
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}