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
            'student_name' => $this->name,
            'student_gender' => [
                'key' => $gender_type->key,
                'name' => $gender_type->description,
                'value' => $gender_type->value,
            ],
            'student_qr_code' => $this->qr_code,
            'student_active' => $this->is_active,
            'student_date_from' => $this->date_from,
            'student_date_to' => $this->date_to,
            'student_nationality' => Nationality::make($this->nationality),
            'student_program' => Program::make($this->program),
            'student_created_at' => date('Y-m-d', strtotime($this->created_at)),
            'student_updated_at' => date('Y-m-d', strtotime($this->updated_at)),
        ];
    }
}
