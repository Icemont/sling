<?php

namespace Tests\Unit;

use App\Models\Currency;
use App\Services\NBGExchangeRatesService;
use Closure;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class NBGExchangeRatesServiceTest extends TestCase
{
    private NBGExchangeRatesService $service;

    private Currency $currency;

    private Carbon $date;

    private float $test_value = 2.0;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = new NBGExchangeRatesService();
        $this->currency = new Currency();
        $this->date = now();
    }

    protected function setFakeHttpResponse(bool $valid = true): void
    {
        Http::fake([
            'nbg.gov.ge/*' => Http::response(
                [[
                    'date' => $this->date->toDateTimeString(),
                    'currencies' => [
                        $valid ? [
                            'code' => 'USD',
                            'quantity' => 1,
                            'rate' => $this->test_value,
                        ] : []
                    ]
                ]],
                200,
                []
            ),
        ]);
    }

    /**
     * Test NBGExchangeRatesService
     *
     * @return void
     */
    public function test_nbg_exchange_rates_service()
    {
        $this->setFakeHttpResponse();

        $this->currency->code = 'USD';

        $rate = $this->service->getExchangeRate($this->currency, $this->date);

        $this->assertEquals($this->test_value, $rate);
    }


    /**
     * Test NBGExchangeRatesService uses the cache
     *
     * @return void
     */
    public function test_nbg_exchange_rates_service_uses_cache()
    {
        $this->setFakeHttpResponse();

        $this->currency->code = 'USD';

        Cache::shouldReceive('remember')
            ->once()
            ->with('nbg.USD.' . $this->date->format('Ymd'), 3600, Closure::class);

        $this->service->getExchangeRate($this->currency, $this->date);
    }

    /**
     * Test NBGExchangeRatesService for the same currency
     *
     * @return void
     */
    public function test_nbg_exchange_rates_service_for_gel()
    {
        $this->setFakeHttpResponse();

        $this->currency->code = 'GEL';

        $rate = $this->service->getExchangeRate($this->currency, $this->date);

        $this->assertEquals(1.0, $rate);
    }

    /**
     * Test NBGExchangeRatesService with bad data
     *
     * @return void
     */
    public function test_nbg_exchange_rates_service_with_bad_data()
    {
        $this->setFakeHttpResponse();

        $this->currency->code = 'EUR';

        $rate = $this->service->getExchangeRate($this->currency, $this->date);

        $this->assertEquals(null, $rate);
    }

    /**
     * Test NBGExchangeRatesService with invalid data
     *
     * @return void
     */
    public function test_nbg_exchange_rates_service_with_invalid_data()
    {
        $this->setFakeHttpResponse(false);

        $this->currency->code = 'USD';

        $rate = $this->service->getExchangeRate($this->currency, $this->date);

        $this->assertEquals(null, $rate);
    }
}
