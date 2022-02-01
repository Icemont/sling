<?php

use App\Http\Controllers\Api\V1\ExchangeRateController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum', 'throttle:10,1'])->group(function () {
    Route::get('/exchange-rates/{currency:code}/{date}', [ExchangeRateController::class, 'get'])
        ->where([
            'currency' => '[A-Za-z]{3}',
            'date' => '20\d{2}\-\d{2}\-\d{2}'
        ]);
});
