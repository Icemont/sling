<?php

declare(strict_types=1);

namespace App\DTOs;

readonly class PaymentMethodDTO
{
    public function __construct(
        public string $name,
        public array $attributes,
        public bool $isActive,
        public ?int $userId = null,
    ) {
    }
}
