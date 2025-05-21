<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Survey extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'survey_id' => $this->id,
            'is_answerd' => $this->is_answerd,
            'meal' => Meal::make($this->meal),
            'mearchant' => Merchant::make($this->user),
        ];
        return parent::toArray($request);
    }
}
