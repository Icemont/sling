<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrenciesSeeder extends Seeder
{
    public function run()
    {
        $currencies = [
            [
                'name' => 'Georgian Lari',
                'code' => 'GEL',
                'symbol' => '₾',
            ],
            [
                'name' => 'US Dollar',
                'code' => 'USD',
                'symbol' => '$',
            ],
            [
                'name' => 'Euro',
                'code' => 'EUR',
                'symbol' => '€',
            ],
            [
                'name' => 'British Pound',
                'code' => 'GBP',
                'symbol' => '£',
            ],
            [
                'name' => 'Russian Ruble',
                'code' => 'RUB',
                'symbol' => '₽',
            ],
            [
                'name' => 'Turkish Lira',
                'code' => 'TRY',
                'symbol' => 'TL ',
            ],
            [
                'name' => 'Ukrainian Hryvnia',
                'code' => 'UAH',
                'symbol' => '₴',
            ],
        ];

        Currency::upsert($currencies, ['code'], ['name', 'symbol']);
    }
}
