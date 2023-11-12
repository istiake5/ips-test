<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LessonUserSeeder extends Seeder
{
    public function run()
    {
        $usersCount = 10; // Set the number of users
        $lessonsCount = 20; // Set the number of lessons

        // Seed lesson_user table with fake data
        for ($i = 1; $i <= $usersCount; $i++) {
            for ($j = 1; $j <= $lessonsCount; $j++) {
                DB::table('lesson_user')->insert([
                    'user_id' => $i,
                    'lesson_id' => $j,
                    'watched' => rand(0, 1), // Randomly set watched to true or false
                ]);
            }
        }
    }
}
