<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    public function run()
    {
        // إنشاء 20 طالب لكل فصل دراسي
        for ($classroom_id = 1; $classroom_id <= 36; $classroom_id++) {
            for ($i = 1; $i <= 7; $i++) {
                Student::create([
                    'name' => fake()->name(),
                    'email' => "student{$i}_class{$classroom_id}@school.com",
                    'phone' => "0100" . str_pad($classroom_id, 4, '0', STR_PAD_LEFT) . str_pad($i, 2, '0', STR_PAD_LEFT),
                    'enrollment_date' => fake()->date(),
                    'classroom_id' => $classroom_id,
                    'address' => fake()->address(),
                    'date_of_birth' => fake()->date(),
                    'parent_phone' => '012' . random_int(10000000, 99999999),
                    'status' => fake()->randomElement(['active', 'inactive']),
                ]);
            }
        }
    }
}
