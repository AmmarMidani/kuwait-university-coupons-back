<?php

namespace Database\Seeders;

use App\Models\Program;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $programs = [
            'Computer Science',
            'Business Administration',
            'Civil Engineering',
            'Pharmacy',
            'Mechanical Engineering',
            'Nursing',
            'Architecture',
            'Economics',
        ];

        foreach ($programs as $name) {
            Program::create(['name' => $name]);
        }
    }
}
