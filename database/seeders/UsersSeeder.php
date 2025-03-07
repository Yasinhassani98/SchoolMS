<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Yasin',
            'email' => 'yasin@gmail.com',
            'password' => Hash::make('12345678')
        ])->assignRole('admin');

        User::create([
            'name' => 'Omar',
            'email' => 'Omar@gmail.com',
            'password' => Hash::make('12345678')
        ])->assignRole('admin');

        for ($i = 0; $i < 10; $i++) {
            User::create([
                'name' => fake()->name(),
                'email' => fake()->email(),
                'password' => Hash::make('12345678')
            ])->assignRole('student');
        }
        for ($i = 0; $i < 10; $i++) {
            User::create([
                'name' => fake()->name(),
                'email' => fake()->email(),
                'password' => Hash::make('12345678')
            ])->assignRole('parent');
        }
        for ($i = 0; $i < 10; $i++) {
            User::create([
                'name' => fake()->name(),
                'email' => fake()->email(),
                'password' => Hash::make('12345678')
            ])->assignRole('teacher');
        }
    }
}
