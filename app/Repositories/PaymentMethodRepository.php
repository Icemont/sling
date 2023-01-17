<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Http\Requests\PaymentMethodRequest;
use App\Models\PaymentMethod;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class PaymentMethodRepository
{
    public function getActiveForSelector(): Collection
    {
        return PaymentMethod::active()->get(['id', 'name']);
    }

    public function create(PaymentMethodRequest $request): PaymentMethod
    {
        return PaymentMethod::create(
            $request->getPaymentMethodPayload(true)
        );
    }

    public function updatePaymentMethod(PaymentMethod $paymentMethod, PaymentMethodRequest $request): bool
    {
        return $paymentMethod->update($request->getPaymentMethodPayload());
    }

    public function getPaginated(int $per_page = 25): LengthAwarePaginator
    {
        return PaymentMethod::orderByDesc('id')
            ->paginate(config('app.per_page.payment_methods', $per_page));
    }
}
