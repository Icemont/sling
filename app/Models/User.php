<?php

declare(strict_types=1);

namespace App\Models;

use App\Casts\BusinessCast;
use App\Traits\HasAddress;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use Throwable;

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

    public function updateProfileWithAddress(array $attributes): self
    {
        $this->updateProfile($attributes);
        $this->upsertAddress($attributes);

        return $this;
    }

    public function updateProfile(array $attributes): bool
    {
        return $this->update([
            'name' => $attributes['name'],
            'business' => $attributes['business'],
            'phone' => $attributes['phone'],
        ]);
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

    /**
     * @throws Throwable
     */
    public function createInvoice(array $attributes): Invoice
    {
        $invoice_data = Arr::only($attributes, [
            'client_id', 'product_name', 'currency_id',
            'invoice_number', 'payment_method_id', 'note',
        ]);

        $invoice_data['product_price'] = round(floatval($attributes['product_price']), 2);
        $invoice_data['invoice_date'] = Carbon::createFromFormat('Y-m-d', $attributes['invoice_date']);
        $invoice_data['is_paid'] = $attributes['is_paid'] ?? false;

        if ($invoice_data['is_paid']) {
            $invoice_data['payment_date'] = Carbon::createFromFormat('Y-m-d', $attributes['payment_date']);

            if ($this->currency_id == $attributes['currency_id']) {
                $invoice_data['amount'] = $invoice_data['product_price'];
            } else {
                $invoice_data['exchange_rate'] = floatval($attributes['exchange_rate']);
                $invoice_data['amount'] = $invoice_data['product_price'] * $invoice_data['exchange_rate'];
            }
        }

        return  DB::transaction(function () use ($invoice_data) {
            $invoice = new Invoice($invoice_data);
            $this->invoices()->save($invoice);
            $invoice->client()->increment('invoice_index');

            return $invoice;
        });
    }
}
