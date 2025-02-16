<?php

namespace Database\Seeders;

use App\Models\Level;
use Illuminate\Database\Seeder;

class LevelSeeder extends Seeder
{
    public function run()
    {
        $levels = [
            ['name' => 'المرحلة الابتدائية - الصف الأول', 'level' => 1],
            ['name' => 'المرحلة الابتدائية - الصف الثاني', 'level' => 2],
            ['name' => 'المرحلة الابتدائية - الصف الثالث', 'level' => 3],
            ['name' => 'المرحلة الابتدائية - الصف الرابع', 'level' => 4],
            ['name' => 'المرحلة الابتدائية - الصف الخامس', 'level' => 5],
            ['name' => 'المرحلة الابتدائية - الصف السادس', 'level' => 6],
            ['name' => 'المرحلة المتوسطة - الصف الأول', 'level' => 7],
            ['name' => 'المرحلة المتوسطة - الصف الثاني', 'level' => 8],
            ['name' => 'المرحلة المتوسطة - الصف الثالث', 'level' => 9],
        ];

        foreach ($levels as $level) {
            Level::create($level);
        }
    }
}
