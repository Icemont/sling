<?php

declare(strict_types=1);

namespace App\Data;

readonly class PaymentMethodData
{
    public function __construct(
        public string $name,
        public array $attributes,
        public bool $isActive,
        public ?int $userId = null,
    ) {
    }
}
