<?php

namespace Tests\Feature;

use App\DTOs\PurchaseData;
use App\Models\Achievement;
use App\Models\Badge;
use App\Models\User;
use App\Services\GamificationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class GamificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_unlocks_achievement_and_badge_on_purchase()
    {
        // 1. Setup Data
        $user = User::factory()->create();

        $achievement = Achievement::create([
            'name' => 'Big Spender',
            'description' => 'Spend 50k',
            'points' => 100
        ]);

        $badge = Badge::create([
            'name' => 'Gold Member',
            'description' => 'Earn 100 points',
            'points_required' => 100,
            'cashback_amount' => 300
        ]);

        // 2. Simulate Purchase via Service
        // (We test the service directly to verify logic, or we could test a PurchaseController if we made one)
        $service = app(GamificationService::class);
        $purchaseData = new PurchaseData(
            userId: $user->id,
            amount: 55000,
            itemsCount: 1
        );

        $service->checkAndUnlockAchievements($user, $purchaseData);

        // 3. Assertions
        // Check Achievement Unlocked
        $this->assertTrue($user->fresh()->achievements->contains($achievement));

        // Check Badge Unlocked (current_badge_id updated)
        $this->assertEquals($badge->id, $user->fresh()->current_badge_id);
    }

    public function test_api_returns_achievements()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->getJson("/api/users/{$user->id}/achievements");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'unlocked_achievements',
                    'next_available_achievements',
                    'current_badge',
                    'next_badge',
                    'remaining_to_unlock_next_badge'
                ]
            ]);
    }
}
