<?php

namespace App\Http\Resources;

use App\Enums\GenderType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Student extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $gender_type = GenderType::fromValue($this->gender);

        return [
            'student_number' => $this->student_number,
            'name' => $this->name,
            'gender' => [
                'key' => $gender_type->key,
                'name' => $gender_type->description,
                'value' => $gender_type->value,
            ],
            'qr_code' => $this->qr_code,
            'active' => $this->is_active,
            'date_from' => $this->date_from,
            'date_to' => $this->date_to,
            'nationality' => Nationality::make($this->nationality),
            'created_at' => date('Y-m-d', strtotime($this->created_at)),
            'updated_at' => date('Y-m-d', strtotime($this->updated_at)),
        ];
    }
}
