<?php

declare(strict_types=1);

namespace App\Data;

readonly class ClientData
{
    public function __construct(
        public string $name,
        public string $email,
        public ?string $company,
        public string $invoice_prefix,
        public int $invoice_index,
        public ?string $phone,
        public ?AddressData $address,
        public ?string $note
    ) {
    }
}
