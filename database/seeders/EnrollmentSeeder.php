<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Enrollment;
use Illuminate\Support\Facades\DB;

class EnrollmentSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {

            $data = [
                ['student_id' => 8, 'date' => '2024-01-15 10:00:00'],
                ['student_id' => 9, 'date' => '2024-01-16 11:00:00'],
                ['student_id' => 10, 'date' => '2024-01-17 12:00:00'],
                ['student_id' => 11, 'date' => '2024-01-18 13:00:00'],
                ['student_id' => 12, 'date' => '2024-01-18 13:00:00'],
                ['student_id' => 13, 'date' => '2024-01-19 14:00:00'],
                ['student_id' => 14, 'date' => '2024-01-19 14:00:00'],
                ['student_id' => 15, 'date' => '2024-01-20 15:00:00'],
                ['student_id' => 16, 'date' => '2024-01-21 16:00:00'],
                ['student_id' => 17, 'date' => '2024-01-22 17:00:00'],
                ['student_id' => 18, 'date' => '2024-01-23 18:00:00'],
                ['student_id' => 19, 'date' => '2024-01-24 19:00:00'],
                ['student_id' => 20, 'date' => '2024-01-25 20:00:00'],
                ['student_id' => 21, 'date' => '2024-01-26 21:00:00'],
                ['student_id' => 22, 'date' => '2024-01-27 22:00:00'],
                ['student_id' => 23, 'date' => '2024-01-28 23:00:00'],
                ['student_id' => 24, 'date' => '2024-01-29 09:00:00'],
                ['student_id' => 25, 'date' => '2024-01-30 10:00:00'],
                ['student_id' => 26, 'date' => '2024-01-31 11:00:00'],
                ['student_id' => 27, 'date' => '2024-02-01 12:00:00'],
                ['student_id' => 28, 'date' => '2024-02-02 13:00:00'],
                ['student_id' => 29, 'date' => '2024-02-03 14:00:00'],
                ['student_id' => 30, 'date' => '2024-02-04 15:00:00'],
                ['student_id' => 31, 'date' => '2024-02-05 16:00:00'],
                ['student_id' => 32, 'date' => '2024-02-06 17:00:00'],
                ['student_id' => 33, 'date' => '2024-02-07 18:00:00'],
                ['student_id' => 34, 'date' => '2024-02-08 19:00:00'],
                ['student_id' => 35, 'date' => '2024-02-09 20:00:00'],
                ['student_id' => 36, 'date' => '2024-02-10 21:00:00'],
                ['student_id' => 37, 'date' => '2024-02-11 22:00:00'],
                ['student_id' => 38, 'date' => '2024-02-12 23:00:00'],
                ['student_id' => 39, 'date' => '2024-02-13 09:00:00'],
                ['student_id' => 40, 'date' => '2024-02-14 10:00:00'],
                ['student_id' => 41, 'date' => '2024-02-15 11:00:00'],
            ];

            foreach ($data as $item) {
                Enrollment::updateOrCreate(
                    ['student_id' => $item['student_id']],
                    [
                        'course_id' => 2, // 👈 tu curso fijo
                        'created_at' => $item['date'],
                        'updated_at' => $item['date'],
                    ]
                );
            }
        });
    }
}