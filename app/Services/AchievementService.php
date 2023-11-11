<?php

namespace App\Services;

use App\Events\AchievementUnlocked;
use App\Events\BadgeUnlocked;
use App\Models\User;

class AchievementService
{
    public function unlockLessonAchievements(User $user, $lessonsWatchedCount)
    {
        $lessonAchievements = [1, 5, 10, 25, 50];

        foreach ($lessonAchievements as $achievement) {
            if ($lessonsWatchedCount >= $achievement) {
                event(new AchievementUnlocked("$achievement Lessons Watched", $user));
            }
        }

        $this->checkAndUnlockBadge($user);
    }

    public function unlockCommentAchievements(User $user, $commentsWrittenCount)
    {
        $commentAchievements = [1, 3, 5, 10, 20];

        foreach ($commentAchievements as $achievement) {
            if ($commentsWrittenCount >= $achievement) {
                event(new AchievementUnlocked("$achievement Comments Written", $user));
            }
        }

        $this->checkAndUnlockBadge($user);
    }

    private function checkAndUnlockBadge(User $user)
    {
        $badgeAchievements = [4, 8, 10];
        $userAchievementsCount = $user->achievements()->count();

        foreach ($badgeAchievements as $badgeCount) {
            if ($userAchievementsCount >= $badgeCount) {
                event(new BadgeUnlocked($this->getBadgeName($badgeCount), $user));
            }
        }
    }

    private function getBadgeName($achievementCount)
    {
        $badgeNames = ['Beginner', 'Intermediate', 'Advanced', 'Master'];
        $badgeIndex = floor($achievementCount / 4);
        return $badgeNames[$badgeIndex];
    }
}
