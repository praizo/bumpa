<?php

namespace Database\Seeders;

use App\Models\Achievement;
use Illuminate\Database\Seeder;

class AchievementSeeder extends Seeder
{
    public function run(): void
    {
        $achievements = [
            [
                'name' => 'First Purchase',
                'description' => 'Complete your first successful order.',
                'points' => 10,
                'icon_url' => 'https://via.placeholder.com/150?text=First+Purchase'
            ],
            [
                'name' => 'Big Spender',
                'description' => 'Spend over 50,000 Naira in a single order.',
                'points' => 50,
                'icon_url' => 'https://via.placeholder.com/150?text=Big+Spender'
            ],
            [
                'name' => 'Loyal Customer',
                'description' => 'Complete 10 orders.',
                'points' => 100,
                'icon_url' => 'https://via.placeholder.com/150?text=Loyal+Customer'
            ],
            [
                'name' => 'Reviewer',
                'description' => 'Leave a product review.',
                'points' => 20,
                'icon_url' => 'https://via.placeholder.com/150?text=Reviewer'
            ]
        ];

        foreach ($achievements as $achievement) {
            Achievement::firstOrCreate(['name' => $achievement['name']], $achievement);
        }
    }
}