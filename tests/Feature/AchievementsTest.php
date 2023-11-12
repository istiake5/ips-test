<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Lesson;
use App\Models\Comment;
use App\Events\LessonWatched;
use App\Events\CommentWritten;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AchievementsTest extends TestCase
{
    use RefreshDatabase;
    public function user_unlocks_first_lesson_watched_achievement()
    {
        $user = User::factory()->create();
        $lesson = Lesson::factory()->create();
        event(new LessonWatched($lesson, $user));
        $this->assertContains('First Lesson Watched', $user->achievements());
    }
    public function user_unlocks_first_comment_written_achievement()
    {
        $user = User::factory()->create();
        $comment = Comment::factory()->create();

        event(new CommentWritten($comment));
        $this->assertContains('First Comment Written', $user->achievements());
    }

    public function user_unlocks_5_lessons_and_3_comments_achievements()
    {
        $user = User::factory()->create();
        $lessons = Lesson::factory(5)->create();
        $comments = Comment::factory(3)->create();

        // Fire LessonWatched events for the user
        foreach ($lessons as $lesson) {
            event(new LessonWatched($lesson, $user));
        }

        // Fire CommentWritten events for the user
        foreach ($comments as $comment) {
            event(new CommentWritten($comment));
        }

        // Check if the "5 Lessons Watched" and "3 Comments Written" achievements are unlocked
        $unlockedAchievements = $user->achievements();
        $this->assertContains('5 Lessons Watched', $unlockedAchievements);
        $this->assertContains('3 Comments Written', $unlockedAchievements);
    }

}
