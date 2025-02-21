<?php

declare(strict_types=1);

namespace App\DTO;

readonly class ClientDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public ?string $company,
        public string $invoice_prefix,
        public int $invoice_index,
        public ?string $phone,
        public ?AddressDTO $address,
        public ?string $note
    ) {
    }
}
