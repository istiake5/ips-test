<?php

namespace App\Repositories;

use App\Models\User;

class EloquentAchievementsRepository implements AchievementsRepositoryInterface
{
    public function getUnlockedAchievements(User $user): array
    {
        return $user->achievements();
    }

    public function getNextAvailableAchievements(array $unlockedAchievements): array
    {
        $allAchievements = [
            '1 Lessons Watched', '5 Lessons Watched', '10 Lessons Watched', '25 Lessons Watched', '50 Lessons Watched',
            '1 Comments Written', '3 Comments Written', '5 Comments Written', '10 Comments Written', '20 Comments Written'
        ];

        return array_values(array_diff($allAchievements, $unlockedAchievements));
    }

    public function getCurrentBadgeName(int $achievementCount): string
    {
        $badgeNames = ['Beginner', 'Intermediate', 'Advanced', 'Master'];
        $badgeIndex = floor($achievementCount / 4);
        return $badgeNames[$badgeIndex];
    }

    public function getNextBadgeName(int $achievementCount): string
    {
        $badgeNames = ['Beginner', 'Intermediate', 'Advanced', 'Master'];
        $badgeIndex = floor($achievementCount / 4);
        return $badgeNames[$badgeIndex];
    }

    public function getRemainingToUnlockNextBadge(int $achievementCount): int
    {
        return max(0, 4 - ($achievementCount % 4));
    }
}
