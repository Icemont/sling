<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\ExchangeRatesService;
use App\Models\Currency;
use Illuminate\Support\Carbon;

class FakeExchangeRatesService implements ExchangeRatesService
{

    public function getExchangeRate(Currency $currency, Carbon $date): ?float
    {
        return 1.0;
    }
}
