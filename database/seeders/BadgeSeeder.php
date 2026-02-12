<?php

namespace Database\Seeders;

use App\Models\Badge;
use Illuminate\Database\Seeder;

class BadgeSeeder extends Seeder
{
    public function run(): void
    {
        $badges = [
            [
                'name' => 'Bronze',
                'description' => 'Entry level member',
                'points_required' => 0,
                'cashback_amount' => 0
            ],
            [
                'name' => 'Silver',
                'description' => 'Intermediate member (50 points)',
                'points_required' => 50,
                'cashback_amount' => 100
            ],
            [
                'name' => 'Gold',
                'description' => 'Advanced member (100 points)',
                'points_required' => 100,
                'cashback_amount' => 300
            ],
            [
                'name' => 'Platinum',
                'description' => 'Elite member (500 points)',
                'points_required' => 500,
                'cashback_amount' => 1000
            ]
        ];

        foreach ($badges as $badge) {
            Badge::firstOrCreate(['name' => $badge['name']], $badge);
        }
    }
}