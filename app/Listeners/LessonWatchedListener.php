<?php

namespace App\Listeners;

use App\Events\LessonWatched;
use Illuminate\Contracts\Queue\ShouldQueue;

class LessonWatchedListener implements ShouldQueue
{
    public function handle(LessonWatched $event)
    {
        // Implement logic to unlock lesson-related achievements and badges
        // Dispatch events for unlocked achievements and badges
        event(new AchievementUnlocked('Achievement Name', $event->user));
        event(new BadgeUnlocked('Badge Name', $event->user));
    }
}


