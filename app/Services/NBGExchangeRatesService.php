<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\ExchangeRatesService;
use App\Models\Currency;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class NBGExchangeRatesService implements ExchangeRatesService
{
    public const BASE_CURRENCY = 'GEL';

    private const API_ENDPOINT = 'https://nbg.gov.ge/gw/api/ct/monetarypolicy/currencies/';

    private const CACHE_PREFIX = 'nbg';

    public function getExchangeRate(Currency $currency, Carbon $date): ?float
    {
        if ($currency->code == self::BASE_CURRENCY) {
            return 1.0;
        }

        return $this->getCachedRate($currency, $date);
    }

    private function getCachedRate(Currency $currency, Carbon $date): ?float
    {
        $cache_key = self::CACHE_PREFIX . '.' . $currency->code . '.' . $date->format('Ymd');

        return (float)Cache::remember($cache_key, 3600, function () use ($currency, $date) {
            return $this->getFromEndpoint($currency, $date);
        });
    }

    /**
     * @throws RequestException
     */
    private function getFromEndpoint(Currency $currency, Carbon $date): ?float
    {
        $data = Http::acceptJson()
            ->timeout(5)
            ->get(self::API_ENDPOINT, [
                'currencies' => $currency->code,
                'date' => $date->format('Y-m-d'),
            ])
            ->throw()
            ->json();

        if (!Arr::has($data, ['0.currencies.0.rate', '0.currencies.0.quantity', '0.currencies.0.code'])) {
            return null;
        }

        if (Arr::get($data, '0.currencies.0.code') != $currency->code) {
            return null;
        }

        $rate = Arr::get($data, '0.currencies.0.rate');
        $quantity = Arr::get($data, '0.currencies.0.quantity');

        return round($rate / $quantity, 6);
    }
}
