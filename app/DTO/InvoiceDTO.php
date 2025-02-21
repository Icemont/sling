<?php

declare(strict_types=1);

namespace App\DTO;

use App\Enums\Currency;
use Carbon\CarbonImmutable as Carbon;

readonly class InvoiceDTO
{
    public function __construct(
        public ?int $clientId,
        public string $productName,
        public float $productPrice,
        public Currency $currency,
        public ?float $exchangeRate,
        public ?float $amount,
        public string $invoiceNumber,
        public Carbon $invoiceDate,
        public int $paymentMethodId,
        public bool $isPaid,
        public ?Carbon $paymentDate,
        public ?string $note,
    ) {
    }
}
