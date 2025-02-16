<?php

namespace Database\Seeders;

use App\Models\Classroom;
use Illuminate\Database\Seeder;

class ClassroomSeeder extends Seeder
{
    public function run()
    {
        $classrooms = [];
        
        // لكل مستوى، نضيف 4 فصول
        for ($level_id = 1; $level_id <= 9; $level_id++) {
            $classrooms[] = [
                'name' => "صف {$level_id} - أ",
                'level_id' => $level_id
            ];
            $classrooms[] = [
                'name' => "صف {$level_id} - ب",
                'level_id' => $level_id
            ];
            $classrooms[] = [
                'name' => "صف {$level_id} - ج",
                'level_id' => $level_id
            ];
            $classrooms[] = [
                'name' => "صف {$level_id} - د",
                'level_id' => $level_id
            ];
        }

        foreach ($classrooms as $classroom) {
            Classroom::create($classroom);
        }
    }
}
