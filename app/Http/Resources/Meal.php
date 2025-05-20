<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Meal extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'meal_id' => $this->id,
            'meal_name' => $this->name,
            'meal_description' => $this->description,
            'meal_time_from' => $this->time_from,
            'meal_time_to' => $this->time_to,
            'meal_is_active' => $this->is_active,
        ];
    }
}
