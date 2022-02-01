<?php

namespace App\Values;

use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

class Business implements Arrayable, JsonSerializable
{
    public ?string $name = null;
    public ?string $code = null;

    private function __construct(?string $name, ?string $code)
    {
        $this->name = $name;
        $this->code = $code;
    }

    public static function fromJson($json): self
    {
        $arr = json_decode($json, true) ?: [];

        return new self(
            $arr['name'] ?? '',
            $arr['code'] ?? ''
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'code' => $this->code,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
