<?php

declare(strict_types=1);

namespace App\DTOs;

readonly class UserProfileData
{
    public function __construct(
        public string $name,
        public array $business,
        public string $phone,
        public ?AddressDTO $address,
    ) {
    }
}
