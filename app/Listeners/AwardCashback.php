<?php

namespace App\Listeners;

use App\Events\BadgeUnlocked;
use Illuminate\Support\Facades\Log;

class AwardCashback
{
    public function handle(BadgeUnlocked $event): void
    {
        $amount = $event->badge->cashback_amount;

        if ($amount > 0) {
            Log::info("CASHBACK AWARDED: {$amount} Naira to User {$event->user->id} for unlocking {$event->badge->name}");
        }
    }
}