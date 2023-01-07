<?php

declare(strict_types=1);

namespace App\Models;

use App\Contracts\HasOwner;
use App\Scopes\UserScope;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

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

    public static function getPaginated(int $per_page = 25): LengthAwarePaginator
    {
        return self::with(['client', 'currency'])
            ->orderByDesc('id')
            ->paginate(config('app.per_page.invoices', $per_page));
    }

    /**
     * @param Carbon $from_date
     * @param Carbon $to_date
     * @return Collection
     */
    public static function getForReport(Carbon $from_date, Carbon $to_date): Collection
    {
        return self::select([
            'invoices.payment_date',
            'invoices.invoice_number',
            'invoices.amount',
            'invoices.product_price',
            'invoices.client_id',
            'invoices.exchange_rate',
            'invoices.currency_id',
            'currencies.code as currency',
            'clients.name as client_name',
        ])
            ->leftJoin('clients', 'invoices.client_id', '=', 'clients.id')
            ->leftJoin('currencies', 'invoices.currency_id', '=', 'currencies.id')
            ->where('invoices.is_paid', true)
            ->whereDate('invoices.payment_date', '>=', $from_date)
            ->whereDate('invoices.payment_date', '<=', $to_date)
            ->orderBy('invoices.payment_date')
            ->get();
    }

    public static function getCountsGroupedByStatus(): Collection
    {
        return self::select([
            DB::raw('count(*) as invoices_count'),
            'is_paid'
        ])
            ->groupBy('is_paid')
            ->get();
    }

    public static function getPaidTotalAmount()
    {
        return self::where('is_paid', true)->sum('amount');
    }

    public static function getPaidAmountByDates(Carbon $from_date, Carbon $to_date)
    {
        return self::where('is_paid', true)
            ->whereDate('payment_date', '>=', $from_date)
            ->whereDate('payment_date', '<=', $to_date)
            ->sum('amount');
    }

    public static function getPaidAmountCurrentMonth()
    {
        return self::getPaidAmountByDates(
            now()->startOfMonth(),
            now()->endOfMonth()
        );
    }

    public function getOwnerId(): ?int
    {
        return $this->user_id;
    }

    public function updateInvoice(array $attributes): bool
    {
        $invoice_data = Arr::only($attributes, [
            'product_name',
            'currency_id',
            'invoice_number',
            'payment_method_id',
            'note',
        ]);

        $invoice_data['product_price'] = round(floatval($attributes['product_price']), 2);
        $invoice_data['invoice_date'] = Carbon::createFromFormat('Y-m-d', $attributes['invoice_date']);
        $invoice_data['is_paid'] = $attributes['is_paid'] ?? false;

        if ($invoice_data['is_paid']) {
            $invoice_data['payment_date'] = Carbon::createFromFormat('Y-m-d', $attributes['payment_date']);

            if ($this->user->currency_id == $attributes['currency_id']) {
                $invoice_data['amount'] = $invoice_data['product_price'];
            } else {
                $invoice_data['exchange_rate'] = floatval($attributes['exchange_rate']);
                $invoice_data['amount'] = $invoice_data['product_price'] * $invoice_data['exchange_rate'];
            }
        }

        return $this->update($invoice_data);
    }
}
