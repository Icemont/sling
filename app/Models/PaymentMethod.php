<?php

declare(strict_types=1);

namespace App\Models;

use App\Contracts\HasOwner;
use App\Scopes\UserScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentMethod extends Model implements HasOwner
{
    use HasFactory;

    protected $casts = [
        'attributes' => 'array',
        'is_active' => 'boolean',
    ];

    protected $fillable = [
        'name',
        'user_id',
        'attributes',
        'is_active',
    ];

    protected static function booted()
    {
        static::addGlobalScope(new UserScope(auth()->id()));
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function getOwnerId(): ?int
    {
        return $this->user_id;
    }
}
