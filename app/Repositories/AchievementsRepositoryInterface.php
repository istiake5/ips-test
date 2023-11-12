<?php

namespace App\Repositories;

use App\Models\User;

interface AchievementsRepositoryInterface
{
    public function getUnlockedAchievements(User $user): array;

    public function getNextAvailableAchievements(array $unlockedAchievements): array;

    public function getCurrentBadgeName(int $achievementCount): string;

    public function getNextBadgeName(int $achievementCount): string;

    public function getRemainingToUnlockNextBadge(int $achievementCount): int;
}
