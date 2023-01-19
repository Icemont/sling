<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Http\Requests\InvoiceStoreRequest;
use App\Models\Invoice;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Throwable;

class InvoiceRepository
{
    public function getPaginatedWithRelations(int $perPage = 25): LengthAwarePaginator
    {
        return Invoice::with(['client', 'currency'])
            ->orderByDesc('id')
            ->paginate(config('app.per_page.invoices', $perPage));
    }

    /**
     * @throws Throwable
     */
    public function create(InvoiceStoreRequest $request)
    {
        return DB::transaction(function () use ($request) {
            /** @var User $user */
            $user = auth()->user();

            $invoice = $user->invoices()->create($request->getInvoicePayload(true));
            $invoice->client()->increment('invoice_index');

            return $invoice;
        });
    }

    public function update(Invoice $invoice, InvoiceStoreRequest $request): bool
    {
        return $invoice->update($request->getInvoicePayload());
    }

    public function getForReportByDates(CarbonImmutable $dateFrom, CarbonImmutable $dateTo): Collection
    {
        return Invoice::select([
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
            ->whereDate('invoices.payment_date', '>=', $dateFrom)
            ->whereDate('invoices.payment_date', '<=', $dateTo)
            ->orderBy('invoices.payment_date')
            ->get();
    }

    public function getCountsGroupedByStatus(): Collection
    {
        return Invoice::select([
            DB::raw('count(*) as invoices_count'),
            'is_paid'
        ])
            ->groupBy('is_paid')
            ->get();
    }

    public function getPaidTotalAmount()
    {
        return Invoice::where('is_paid', true)->sum('amount');
    }

    public function getPaidAmountByDates(CarbonImmutable $dateFrom, CarbonImmutable $dateTo)
    {
        return Invoice::where('is_paid', true)
            ->whereDate('payment_date', '>=', $dateFrom)
            ->whereDate('payment_date', '<=', $dateTo)
            ->sum('amount');
    }

    public function getPaidAmountCurrentMonth()
    {
        return Invoice::getPaidAmountByDates(
            now()->startOfMonth(),
            now()->endOfMonth()
        );
    }
}
