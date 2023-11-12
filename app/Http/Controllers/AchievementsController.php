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
}
