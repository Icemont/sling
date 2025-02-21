<?php

declare(strict_types=1);

use App\Http\Controllers\Api\V1\ExchangeRateController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'throttle:10,1'])->group(function () {
    Route::get('/exchange-rates/{currency}/{date}', [ExchangeRateController::class, 'get'])
        ->where([
            'currency' => '\d',
            'date' => '20\d{2}\-\d{2}\-\d{2}',
        ])->name('api.exchange-rates.get');
});
