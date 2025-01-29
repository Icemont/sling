<?php

declare(strict_types=1);

namespace App\Enums;

enum Currency: int
{
    case GEL = 1;
    case USD = 2;
    case EUR = 3;
    case GBP = 4;
    case RUB = 5;
    case TRY = 6;
    case UAH = 7;

    public function name(): string
    {
        return match ($this) {
            self::GEL => 'Georgian Lari',
            self::USD => 'US Dollar',
            self::EUR => 'Euro',
            self::GBP => 'British Pound',
            self::RUB => 'Russian Ruble',
            self::TRY => 'Turkish Lira',
            self::UAH => 'Ukrainian Hryvnia',
        };
    }

    public function code(): string
    {
        return match ($this) {
            self::GEL => 'GEL',
            self::USD => 'USD',
            self::EUR => 'EUR',
            self::GBP => 'GBP',
            self::RUB => 'RUB',
            self::TRY => 'TRY',
            self::UAH => 'UAH',
        };
    }

    public function symbol(): string
    {
        return match ($this) {
            self::GEL => '₾',
            self::USD => '$',
            self::EUR => '€',
            self::GBP => '£',
            self::RUB => '₽',
            self::TRY => '₺',
            self::UAH => '₴',
        };
    }

    public static function getRandom(): Currency
    {
        $enums = self::cases();

        return $enums[array_rand($enums)];
    }
}
