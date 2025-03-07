<?php

namespace Database\Seeders;

use App\Models\Level;
use App\Models\Subject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubjectsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $levels = Level::pluck('id');
        
        $subjects = [
            'Mathematics', 'Science', 'History', 'Geography', 'English', 'Physics', 'Chemistry', 'Biology', 'Computer Science'
        ];

        foreach ($levels as $levelId) {
            foreach ($subjects as $subject) {
                Subject::create([
                    'level_id' => $levelId,
                    'name' => $subject,

                ]);
            }
        }
    }
}
