<?php

namespace Database\Seeders;

use App\Models\Parint;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ParentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            Parint::create([
                'user_id' => User::role('parent')->first()->id,
                'name' => fake()->name(),
                'phone' => fake()->phoneNumber(),
                'date_of_birth' => fake()->date(),
            ]);
        }
    }
}
