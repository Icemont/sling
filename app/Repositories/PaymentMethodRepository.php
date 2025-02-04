<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Data\PaymentMethodData;
use App\Models\PaymentMethod;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class PaymentMethodRepository
{
    public function getActiveForSelector(): Collection
    {
        return PaymentMethod::active()->get(['id', 'name']);
    }

    public function create(PaymentMethodData $paymentMethodData): PaymentMethod
    {
        return PaymentMethod::create([
            'name' => $paymentMethodData->name,
            'attributes' => $paymentMethodData->attributes,
            'is_active' => $paymentMethodData->isActive,
            'user_id' => $paymentMethodData->userId,
        ]);
    }

    public function updatePaymentMethod(PaymentMethod $paymentMethod, PaymentMethodData $paymentMethodData): bool
    {
        return $paymentMethod->update([
            'name' => $paymentMethodData->name,
            'attributes' => $paymentMethodData->attributes,
            'is_active' => $paymentMethodData->isActive,
        ]);
    }

    public function getPaginated(?int $perPage = null): LengthAwarePaginator
    {
        return PaymentMethod::orderByDesc('id')
            ->paginate($perPage ?? config('app.per_page.payment_methods'));
    }
}
