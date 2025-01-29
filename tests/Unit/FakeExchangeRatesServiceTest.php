<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Enums\Currency;
use App\Services\FakeExchangeRatesService;
use PHPUnit\Framework\TestCase;

class FakeExchangeRatesServiceTest extends TestCase
{
    /**
     * Test FakeExchangeRatesService
     *
     * @return void
     */
    public function test_fake_exchange_rates_service(): void
    {
        $rate = (new FakeExchangeRatesService())->getExchangeRate(Currency::USD, now());

        $this->assertEquals(1.0, $rate);
    }
}
