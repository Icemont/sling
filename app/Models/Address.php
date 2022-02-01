<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'street1', 'street2', 'city',
        'state', 'country', 'zip',
    ];

    public function addressable()
    {
        return $this->morphTo();
    }
}
