<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
            UsersSeeder::class,
            AcademicYearsSeeder::class,
            LevelSeeder::class,
            ClassroomSeeder::class,
            TeacherSeeder::class,
            ParentSeeder::class,
            StudentSeeder::class,
            ClassroomTeacherSeeder::class,
            SubjectsSeeder::class
        ]);
    }
}