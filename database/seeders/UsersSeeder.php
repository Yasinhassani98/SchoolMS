<?php

namespace Database\Seeders;

use App\Models\User;
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
        ])->assignRole('superadmin');

        User::create([
            'name' => 'Omar',
            'email' => 'omar@gmail.com',
            'password' => Hash::make('123456789')
        ])->assignRole('superadmin');
        
        User::create([
            'name' => 'Test 1',
            'email' => 'test1@gmail.com',
            'password' => Hash::make('123456789')
        ])->assignRole('admin');
        User::create([
            'name' => 'Test 2',
            'email' => 'test2@gmail.com',
            'password' => Hash::make('123456789')
        ])->assignRole('admin');
        User::create([
            'name' => 'Test 3',
            'email' => 'test3@gmail.com',
            'password' => Hash::make('123456789')
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
            ])->assignRole('parint');
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
