<?php

namespace Database\Seeders;

use App\Models\Teacher;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    public function run()
    {
        $teachers = [
            ['name' => 'أحمد محمد', 'email' => 'ahmed@school.com'],
            ['name' => 'محمد علي', 'email' => 'mohamed@school.com'],
            ['name' => 'سارة أحمد', 'email' => 'sara@school.com'],
            ['name' => 'فاطمة محمود', 'email' => 'fatima@school.com'],
            ['name' => 'خالد إبراهيم', 'email' => 'khaled@school.com'],
        ];

        foreach ($teachers as $teacher) {
            Teacher::create([
                'name' => $teacher['name'],
                'email' => $teacher['email'],
                'phone' => '01' . random_int(000000000, 299999999)
            ]);
        }
    }
}
