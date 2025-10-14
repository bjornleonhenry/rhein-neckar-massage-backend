<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GaestebuchResource extends JsonResource
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
            'date' => $this->date,
            'rating' => $this->rating,
            'service' => $this->service,
            'message' => $this->message,
            'verified' => $this->verified,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
