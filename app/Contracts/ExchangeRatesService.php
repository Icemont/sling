<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\Currency;
use Illuminate\Support\Carbon;

interface ExchangeRatesService
{
    public function getExchangeRate(Currency $currency, Carbon $date): ?float;
}
