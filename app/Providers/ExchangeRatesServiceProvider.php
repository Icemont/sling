<?php

declare(strict_types=1);

namespace App\Providers;

use App\Contracts\ExchangeRatesService;
use App\Services\FakeExchangeRatesService;
use App\Services\NBGExchangeRatesService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class ExchangeRatesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(ExchangeRatesService::class, function ($app) {
            $user = auth()->user();
            return match ($user ? Str::upper($user->getCurrencyCode()) : '') {
                NBGExchangeRatesService::BASE_CURRENCY => new NBGExchangeRatesService(),
                default => new FakeExchangeRatesService(),
            };
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }
}
