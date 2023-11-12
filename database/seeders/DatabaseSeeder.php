<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Lesson;
use App\Models\Comment;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->count(10)->create();
        Lesson::factory()->count(20)->create();
        Comment::factory()->count(50)->create();
        $this->call(LessonUserSeeder::class);
    }
}
