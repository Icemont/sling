<?php

namespace Tests\Unit;

use App\Models\Currency;
use App\Services\FakeExchangeRatesService;
use PHPUnit\Framework\TestCase;

class FakeExchangeRatesServiceTest extends TestCase
{
    /**
     * Test FakeExchangeRatesService
     *
     * @return void
     */
    public function test_fake_exchange_rates_service()
    {
        $currency = new Currency();

        $rate = (new FakeExchangeRatesService())->getExchangeRate($currency, now());

        $this->assertEquals(1.0, $rate);
    }
}
