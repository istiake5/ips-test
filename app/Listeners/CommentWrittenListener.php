<?php

namespace App\Listeners;

use App\Events\AchievementUnlocked;
use App\Events\CommentWritten;
use App\Services\AchievementService;
use Illuminate\Contracts\Queue\ShouldQueue;

class CommentWrittenListener implements ShouldQueue
{
    private $achievementService;

    public function __construct(AchievementService $achievementService)
    {
        $this->achievementService = $achievementService;
    }

    public function handle(CommentWritten $event)
    {
        $user = $event->comment->user;
        $commentsWrittenCount = $user->comments()->count();

        if ($user->comments()->count() === 1) {
            event(new AchievementUnlocked('First Comment Written', $user));
        }

        $this->achievementService->unlockCommentAchievements($user, $commentsWrittenCount);
    }
}
