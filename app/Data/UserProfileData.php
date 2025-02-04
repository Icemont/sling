<?php

declare(strict_types=1);

namespace App\Data;

readonly class UserProfileData
{
    public function __construct(
        public string $name,
        public array $business,
        public string $phone,
        public ?AddressData $address,
    ) {
    }
}
