<?php

namespace Database\Seeders;

use App\Enums\GenderType;
use App\Models\Student;
use App\Models\Nationality;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $nationalityIds = Nationality::pluck('id')->toArray();
        for ($i = 1; $i <= 50; $i++) {
            $student_number = 'STU' . str_pad($i, 6, '0', STR_PAD_LEFT);
            $qr_code = Hash::make($student_number . now());
            Student::create([
                'nationality_id' => fake()->randomElement($nationalityIds),
                'student_number' => $student_number,
                'qr_code' => $qr_code,
                'gender' => GenderType::getRandomValue(),
                'name' => fake()->name(),
                'date_from' => fake()->dateTimeBetween('-2 years', 'now'),
                'date_to' => fake()->dateTimeBetween('now', '+2 years'),
                'is_active' => fake()->boolean(80),
            ]);
        }
    }
}
