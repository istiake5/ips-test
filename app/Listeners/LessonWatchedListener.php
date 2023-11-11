<?php

// app/Listeners/LessonWatchedListener.php

namespace App\Listeners;

use App\Events\AchievementUnlocked;
use App\Events\LessonWatched;
use App\Services\AchievementService;
use Illuminate\Contracts\Queue\ShouldQueue;

class LessonWatchedListener implements ShouldQueue
{
    private $achievementService;

    public function __construct(AchievementService $achievementService)
    {
        $this->achievementService = $achievementService;
    }

    public function handle(LessonWatched $event)
    {
        $user = $event->user;
        $lessonsWatchedCount = $user->watched()->count();

        if (!$user->watched()->where('lesson_id', $event->lesson->id)->exists()) {
            event(new AchievementUnlocked('First Lesson Watched', $user));
        }

        $this->achievementService->unlockLessonAchievements($user, $lessonsWatchedCount);
    }
}



