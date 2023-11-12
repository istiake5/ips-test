<?php


namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\AchievementsRepositoryInterface;
use App\Services\AchievementService;

class AchievementsController extends Controller
{
    private $achievementService;
    private $achievementsRepository;

    public function __construct(AchievementService $achievementService, AchievementsRepositoryInterface $achievementsRepository)
    {
        $this->achievementService = $achievementService;
        $this->achievementsRepository = $achievementsRepository;
    }

    public function index(User $user)
    {
        $this->updateAchievements($user);

        $unlockedAchievements = $this->achievementsRepository->getUnlockedAchievements($user);
        $nextAvailableAchievements = $this->achievementsRepository->getNextAvailableAchievements($unlockedAchievements);

        $currentBadge = $this->achievementsRepository->getCurrentBadgeName(count($unlockedAchievements));
        $nextBadge = $this->achievementsRepository->getNextBadgeName(count($unlockedAchievements) + 1);
        $remainingToUnlockNextBadge = $this->achievementsRepository->getRemainingToUnlockNextBadge(count($unlockedAchievements));

        return [
            'unlocked_achievements' => $unlockedAchievements,
            'next_available_achievements' => $nextAvailableAchievements,
            'current_badge' => $currentBadge,
            'next_badge' => $nextBadge,
            'remaining_to_unlock_next_badge' => $remainingToUnlockNextBadge,
        ];
    }

    private function updateAchievements(User $user)
    {
        $lessonsWatchedCount = $user->watched()->wherePivot('watched', true)->count();
        $commentsWrittenCount = $user->comments()->count();

        $this->achievementService->unlockLessonAchievements($user, $lessonsWatchedCount);
        $this->achievementService->unlockCommentAchievements($user, $commentsWrittenCount);
    }

    private function getNextAvailableAchievements(array $unlockedAchievements)
    {
        $allAchievements = ['1 Lessons Watched', '5 Lessons Watched', '10 Lessons Watched', '25 Lessons Watched', '50 Lessons Watched',
                            '1 Comments Written', '3 Comments Written', '5 Comments Written', '10 Comments Written', '20 Comments Written'];

        return array_values(array_diff($allAchievements, $unlockedAchievements));
    }

    private function getBadgeName($achievementCount)
    {
        $badgeNames = ['Beginner', 'Intermediate', 'Advanced', 'Master'];
        $badgeIndex = floor($achievementCount / 4);
        return $badgeNames[$badgeIndex];
    }
}
