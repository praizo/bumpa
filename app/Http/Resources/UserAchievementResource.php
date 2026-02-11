<?php

namespace App\Http\Resources;

use App\Models\Achievement;
use App\Models\Badge;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserAchievementResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        /** @var \App\Models\User $user */
        $user = $this->resource;

        $unlockedIds = $user->achievements()->pluck('achievements.id');
        
        $nextBadge = $user->nextBadge();
        $currentPoints = $user->achievements()->sum('points');
        $remainingPoints = $nextBadge ? ($nextBadge->points_required - $currentPoints) : 0;

        return [
            'unlocked_achievements' => $user->achievements->pluck('name'),
            'next_available_achievements' => Achievement::whereNotIn('id', $unlockedIds)->pluck('name'),
            'current_badge' => $user->badge?->name ?? 'None',
            'next_badge' => $nextBadge?->name ?? 'Max Level',
            'remaining_to_unlock_next_badge' => $remainingPoints,
        ];
    }
}