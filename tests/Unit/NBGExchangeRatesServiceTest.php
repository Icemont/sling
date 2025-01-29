<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Enums\Currency;
use App\Services\NBGExchangeRatesService;
use Closure;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class NBGExchangeRatesServiceTest extends TestCase
{
    private NBGExchangeRatesService $service;

    private Carbon $date;

    private float $test_value = 2.0;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = new NBGExchangeRatesService();
        $this->date = now();
    }

    protected function setFakeHttpResponse(bool $valid = true): void
    {
        Http::fake([
            'nbg.gov.ge/*' => Http::response([
                [
                    'date' => $this->date->toDateTimeString(),
                    'currencies' => [
                        $valid ? [
                            'code' => 'USD',
                            'quantity' => 1,
                            'rate' => $this->test_value,
                        ] : [],
                    ],
                ],
            ]),
        ]);
    }

    /**
     * Test NBGExchangeRatesService
     *
     * @return void
     */
    public function test_nbg_exchange_rates_service(): void
    {
        $this->setFakeHttpResponse();

        $rate = $this->service->getExchangeRate(Currency::USD, $this->date);

        $this->assertEquals($this->test_value, $rate);
    }

    /**
     * Test NBGExchangeRatesService uses the cache
     *
     * @return void
     */
    public function test_nbg_exchange_rates_service_uses_cache(): void
    {
        $this->setFakeHttpResponse();

        Cache::shouldReceive('remember')
            ->once()
            ->with('nbg.USD.' . $this->date->format('Ymd'), 3600, Closure::class);

        $this->service->getExchangeRate(Currency::USD, $this->date);
    }

    /**
     * Test NBGExchangeRatesService for the same currency
     *
     * @return void
     */
    public function test_nbg_exchange_rates_service_for_gel(): void
    {
        $this->setFakeHttpResponse();

        $rate = $this->service->getExchangeRate(Currency::GEL, $this->date);

        $this->assertEquals(1.0, $rate);
    }

    /**
     * Test NBGExchangeRatesService with bad data
     *
     * @return void
     */
    public function test_nbg_exchange_rates_service_with_bad_data(): void
    {
        $this->setFakeHttpResponse();

        $rate = $this->service->getExchangeRate(Currency::EUR, $this->date);

        $this->assertEquals(null, $rate);
    }

    /**
     * Test NBGExchangeRatesService with invalid data
     *
     * @return void
     */
    public function test_nbg_exchange_rates_service_with_invalid_data(): void
    {
        $this->setFakeHttpResponse(false);

        $rate = $this->service->getExchangeRate(Currency::USD, $this->date);

        $this->assertEquals(null, $rate);
    }
}
