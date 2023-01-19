<?php

declare(strict_types=1);

namespace App\Models;

use App\Contracts\HasOwner;
use App\Scopes\UserScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;

class Invoice extends Model implements HasOwner
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'product_name',
        'currency_id',
        'invoice_number',
        'payment_method_id',
        'note',
        'product_price',
        'invoice_date',
        'is_paid',
        'payment_date',
        'exchange_rate',
        'amount',
    ];

    protected $casts = [
        'is_paid' => 'boolean',
        'product_price' => 'float',
        'invoice_date' => 'date',
        'payment_date' => 'date',
        'amount' => 'float',
        'exchange_rate' => 'float',
    ];

    protected static function booted()
    {
        $auth_id = auth()->id();

        static::addGlobalScope(new UserScope($auth_id));

        $forgetter = function () use ($auth_id) {
            Cache::forget('dashboard.statistic.' . $auth_id);
        };

        static::created($forgetter);
        static::deleted($forgetter);
        static::updated($forgetter);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function getOwnerId(): ?int
    {
        return $this->user_id;
    }
}
