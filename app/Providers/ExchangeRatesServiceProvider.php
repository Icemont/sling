<?php

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
    public function register()
    {
        $this->app->singleton(ExchangeRatesService::class, function ($app) {
            $user = auth()->user();
            switch ($user ? Str::upper($user->getCurrencyCode()) : '') {
                case 'GEL':
                    return new NBGExchangeRatesService();
                default:
                    return new FakeExchangeRatesService();
            }
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
