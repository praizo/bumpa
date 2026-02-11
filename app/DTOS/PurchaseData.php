<?php

namespace App\DTOs;

readonly class PurchaseData
{
    public function __construct(
        public int $userId,
        public float $amount,
        public int $itemsCount, 
        public string $category = 'general'
    ) {}
}