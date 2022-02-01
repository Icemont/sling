<?php

namespace App\Casts;

use App\Values\Business;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Support\Arr;

class BusinessCast implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes): Business
    {
        return Business::fromJson($value);
    }

    public function set($model, string $key, $value, array $attributes): ?string
    {
        $value = Arr::only((array)$value, ['name', 'code']);
        
        return json_encode($value ?: []);
    }
}
