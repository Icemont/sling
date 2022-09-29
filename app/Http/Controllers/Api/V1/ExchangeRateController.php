<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Contracts\ExchangeRatesService;
use App\Http\Controllers\Controller;
use App\Models\Currency;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;

class ExchangeRateController extends Controller
{
    public function get(Currency $currency, string $date, ExchangeRatesService $service): JsonResponse
    {
        $date = Carbon::createFromFormat('Y-m-d', $date) ?? now();

        return response()->json([
            'rate' => $service->getExchangeRate($currency, $date)
        ]);
    }
}
