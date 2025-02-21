<?php

declare(strict_types=1);

namespace App\DTO;

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
