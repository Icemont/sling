<?php

namespace App\Traits;

use App\Models\Address;

trait HasAddress
{
    /**
     * Get address.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function address()
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    /**
     * Update or create address for "addressable".
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function upsertAddress(array $attributes)
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
