<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ClassroomTeacherSeeder extends Seeder
{
    public function run()
    {
        // لكل معلم، نقوم بربطه بعدة فصول
        for ($teacher_id = 1; $teacher_id <= 5; $teacher_id++) {
            // كل معلم يدرس في 4 فصول
            for ($i = 0; $i < 4; $i++) {
                DB::table('classroom_teacher')->insert([
                    'teacher_id' => $teacher_id,
                    'classroom_id' => rand(1, 36),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
    }
}
