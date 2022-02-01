<?php

namespace App\Values;

use App\Models\Address as AddressModel;
use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;


class Address implements Arrayable, JsonSerializable
{
    public ?string $street1 = null;
    public ?string $street2 = null;
    public ?string $city = null;
    public ?string $state = null;
    public ?string $country = null;
    public ?string $zip = null;

    public function __construct(?AddressModel $address)
    {
        if ($address) {
            $this->street1 = $address->street1;
            $this->street2 = $address->street2;
            $this->city = $address->city;
            $this->state = $address->state;
            $this->country = $address->country;
            $this->zip = $address->zip;
        }
    }

    public function toArray(): array
    {
        return [
            'street1' => $this->street1,
            'street2' => $this->street2,
            'city' => $this->city,
            'state' => $this->state,
            'country' => $this->country,
            'zip' => $this->zip,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
