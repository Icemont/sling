<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Invoice;
use App\Models\PaymentMethod;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class PaymentMethodRepository
{

    public function getActiveForSelector(): Collection
    {
        return PaymentMethod::active()->get(['id', 'name']);
    }


}