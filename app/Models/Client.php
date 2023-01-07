<?php

declare(strict_types=1);

namespace App\Models;

use App\Contracts\HasOwner;
use App\Scopes\UserScope;
use App\Traits\HasAddress;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model implements HasOwner
{
    use HasFactory, HasAddress;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'company',
        'phone',
        'invoice_prefix',
        'invoice_index',
        'note',
    ];

    protected static function booted()
    {
        static::addGlobalScope(new UserScope(auth()->id()));
    }

    public function getOwnerId(): ?int
    {
        return $this->user_id;
    }
}
