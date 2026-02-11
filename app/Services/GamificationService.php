<?php

namespace App\Services;

use App\DTOs\PurchaseData;
use App\Events\AchievementUnlocked;
use App\Events\BadgeUnlocked;
use App\Models\Achievement;
use App\Models\Badge;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class GamificationService
{

    public function checkAndUnlockAchievements(User $user, PurchaseData $data): void
    {

        if ($data->amount >= 50000) {
            $this->unlockAchievement($user, 'Big Spender');
        }


        if ($user->achievements()->count() === 0) {
            $this->unlockAchievement($user, 'First Purchase');
        }


        $this->checkAndUnlockBadges($user);
    }

    protected function unlockAchievement(User $user, string $achievementName): void
    {
        $achievement = Achievement::where('name', $achievementName)->first();

        if (!$achievement) {
            return;
        }

        if ($user->achievements()->where('achievement_id', $achievement->id)->exists()) {
            return;
        }


        $user->achievements()->attach($achievement);


        Log::info("Unlocked achievement: {$achievement->name} for User {$user->id}");
    }

    public function checkAndUnlockBadges(User $user): void
    {
        $currentPoints = $user->achievements()->sum('points');

        $badge = Badge::where('points_required', '<=', $currentPoints)
            ->orderBy('points_required', 'desc')
            ->first();

        if (!$badge) {
            return;
        }

        if ($user->current_badge_id !== $badge->id) {
            $user->current_badge_id = $badge->id;
            $user->save();


            Log::info("Unlocked badge: {$badge->name} for User {$user->id}");
        }
    }
}
