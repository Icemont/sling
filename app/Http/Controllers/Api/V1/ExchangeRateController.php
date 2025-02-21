<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Contracts\ExchangeRatesService;
use App\Enums\Currency;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;

class ExchangeRateController extends Controller
{
    public function get(int $currencyId, string $date, ExchangeRatesService $service): JsonResponse
    {
        $currency = Currency::tryFrom($currencyId);
        if (!$currency) {
            abort(404);
        }

        $date = Carbon::createFromFormat('Y-m-d', $date) ?? now();

        return response()->json([
            'rate' => $service->getExchangeRate($currency, $date),
        ]);
    }
}
