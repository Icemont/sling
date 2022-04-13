<?php

namespace Tests\Feature\Api;

use App\Contracts\ExchangeRatesService;
use App\Models\User;
use App\Services\FakeExchangeRatesService;
use Database\Seeders\CurrenciesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ExchangeRateApiTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(CurrenciesSeeder::class);
        $this->user = User::factory()->createOne();
    }

    /**
     * @return void
     */
    public function test_exchange_rate_provider_api_endpoint()
    {
        $this->instance(ExchangeRatesService::class, new FakeExchangeRatesService());

        $response = $this->actingAs($this->user)->getJson(
            route('api.exchange-rates.get',
                [
                    'currency' => config('app.default_currency'),
                    'date' => now()->format('Y-m-d')
                ]
            )
        );

        $response->assertStatus(200);

        $response->assertJson(fn(AssertableJson $json) => $json
            ->has('rate')
            ->missing('error')
        );
    }
}
