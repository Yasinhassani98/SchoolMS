<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class AcademicYearsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $years = [
            '2020/2021', '2021/2022', '2022/2023', '2023/2024', '2024/2025', '2025/2026', '2026/2027', '2027/2028', '2028/2029', '2029/2030'
        ];

        foreach ($years as $year) {
            $startYear = explode('/', $year)[0];
            AcademicYear::create([
            'name' => $year,
            'start_date' => Carbon::create($startYear)->startOfYear(),
            'end_date' => Carbon::create($startYear)->startOfYear()->addYear(),
            'is_current' => ($year == '2024/2025')? true : false,
            'description' => 'Academic year ' . $year,

            ]);
        }
    }
}
