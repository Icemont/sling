<?php

declare(strict_types=1);

namespace App\Repositories;

use App\DTO\InvoiceDTO;
use App\Models\Invoice;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Throwable;

class InvoiceRepository
{
    public function getPaginatedWithRelations(?int $perPage = null): LengthAwarePaginator
    {
        return Invoice::with(['client'])
            ->orderByDesc('id')
            ->paginate($perPage ?? config('app.per_page.invoices'));
    }

    /**
     * @throws Throwable
     */
    public function create(InvoiceDTO $data)
    {
        return DB::transaction(function () use ($data) {
            /** @var User $user */
            $user = auth()->user();

            $invoice = $user->invoices()->create([
                'client_id' => $data->clientId,
                'product_name' => $data->productName,
                'currency' => $data->currency,
                'invoice_number' => $data->invoiceNumber,
                'payment_method_id' => $data->paymentMethodId,
                'product_price' => $data->productPrice,
                'invoice_date' => $data->invoiceDate,
                'is_paid' => $data->isPaid,
                'payment_date' => $data->paymentDate,
                'exchange_rate' => $data->exchangeRate,
                'amount' => $data->amount,
                'note' => $data->note,
            ]);

            $invoice->client()->increment('invoice_index');

            return $invoice;
        });
    }

    public function update(Invoice $invoice, InvoiceDTO $data): bool
    {
        return $invoice->update([
            'product_name' => $data->productName,
            'currency' => $data->currency,
            'invoice_number' => $data->invoiceNumber,
            'payment_method_id' => $data->paymentMethodId,
            'product_price' => $data->productPrice,
            'invoice_date' => $data->invoiceDate,
            'is_paid' => $data->isPaid,
            'payment_date' => $data->paymentDate,
            'exchange_rate' => $data->exchangeRate,
            'amount' => $data->amount,
            'note' => $data->note,
        ]);
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
            'invoices.currency',
            'clients.name as client_name',
        ])
            ->leftJoin('clients', 'invoices.client_id', '=', 'clients.id')
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
            'is_paid',
        ])
            ->groupBy('is_paid')
            ->get();
    }

    public function getPaidTotalAmount()
    {
        return Invoice::where('is_paid', true)->sum('amount');
    }

    public function getPaidAmountByDates(Carbon $dateFrom, Carbon $dateTo)
    {
        return Invoice::where('is_paid', true)
            ->whereDate('payment_date', '>=', $dateFrom)
            ->whereDate('payment_date', '<=', $dateTo)
            ->sum('amount');
    }

    public function getPaidAmountCurrentMonth()
    {
        return $this->getPaidAmountByDates(
            now()->startOfMonth(),
            now()->endOfMonth()
        );
    }
}
