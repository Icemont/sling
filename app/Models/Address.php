<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'street1',
        'street2',
        'city',
        'state',
        'country',
        'zip',
    ];

    public function addressable(): MorphTo
    {
        return $this->morphTo();
    }
}
