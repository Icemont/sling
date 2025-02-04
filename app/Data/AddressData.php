<?php

declare(strict_types=1);

namespace App\Data;

readonly class AddressData
{
    public function __construct(
        public string $country,
        public ?string $state,
        public string $city,
        public ?string $zip,
        public string $street1,
        public ?string $street2
    ) {
    }
}
