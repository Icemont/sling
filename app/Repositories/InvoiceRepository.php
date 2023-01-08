<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Http\Requests\InvoiceStoreRequest;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
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
}