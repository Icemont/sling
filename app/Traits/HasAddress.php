<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Address;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait HasAddress
{
    /**
     * Get address.
     *
     * @return MorphOne
     */
    public function address(): MorphOne
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    /**
     * Update or create address for "addressable".
     *
     * @param array $attributes
     * @return Model
     */
    public function upsertAddress(array $attributes): Model
    {
        return $this->address()->updateOrCreate(
            [],
            [
                'street1' => $attributes['street1'],
                'street2' => $attributes['street2'],
                'city' => $attributes['city'],
                'state' => $attributes['state'],
                'country' => $attributes['country'],
                'zip' => $attributes['zip'],
            ]
        );
    }
}
