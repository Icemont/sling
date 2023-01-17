<?php

declare(strict_types=1);

namespace App\Models;

use App\Casts\BusinessCast;
use App\Traits\HasAddress;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasAddress;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'business',
        'currency_id',
        'dark_theme',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'business' => BusinessCast::class,
        'dark_theme' => 'boolean',
    ];


    public function clients(): HasMany
    {
        return $this->hasMany(Client::class);
    }

    public function paymentMethods(): HasMany
    {
        return $this->hasMany(PaymentMethod::class);
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function getBusinessName(): ?string
    {
        return $this->business->name;
    }

    public function getCurrencyCode(): string
    {
        return $this->currency ? $this->currency->code : config('app.default_currency');
    }

    public function createPaymentMethod(array $attributes): PaymentMethod
    {
        $payment_method = new PaymentMethod([
            'name' => $attributes['name'],
            'attributes' => isset($attributes['method_attributes']) ?
                array_combine($attributes['method_attributes']['keys'], $attributes['method_attributes']['values']) : [],
            'is_active' => $attributes['is_active'] ?? false,
        ]);

        $this->paymentMethods()->save($payment_method);

        return $payment_method;
    }
}
