<?php

namespace Database\Seeders;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    public function run()
    {
        

        for ($i = 0; $i < 10; $i++) {
            Teacher::create(['user_id' => User::role('teacher')->first()->id,
                'name' =>fake()->name(),
                'date_of_birth' => fake()->date(),
                'gender' => fake()->randomElement(['male','female']),
                'phone' => '01' . random_int(000000000, 299999999),
                'specialization' => fake()->randomElement(['Math', 'Science', 'English', 'Arabic']),
                'hiring_date' => fake()->date(),
                'status' => fake()->randomElement(['active', 'inactive']),
            ]);
        }
    }
}
