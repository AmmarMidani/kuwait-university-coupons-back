<?php

namespace Database\Seeders;

use App\Enums\GenderType;
use App\Models\Student;
use App\Models\Nationality;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $nationalityIds = Nationality::pluck('id')->toArray();

        $students = [];
        for ($i = 1; $i <= 100; $i++) {
            $students[] = [
                'nationality_id' => fake()->randomElement($nationalityIds),
                'student_number' => 'STU' . str_pad($i, 6, '0', STR_PAD_LEFT),
                'qr_code' => (string) Str::uuid(),
                'password' => Hash::make(Str::random(8) . rand(100, 999)),
                'name' => fake()->name(),
                'gender' => GenderType::getRandomValue(),
                'date_from' => fake()->dateTimeBetween('-2 years', 'now'),
                'date_to' => fake()->dateTimeBetween('now', '+2 years'),
                'is_active' => fake()->boolean(80),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Student::insert($students);
    }
}
