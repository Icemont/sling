<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Client;
use App\Models\User;
use App\Repositories\InvoiceRepository;
use App\Traits\AuthenticatedUser;
use Exception;
use Illuminate\Support\Facades\Cache;

class StatisticService
{
    use AuthenticatedUser;

    public readonly User $user;

    public readonly InvoiceRepository $invoiceRepository;

    /**
     * @throws Exception
     */
    public function __construct(InvoiceRepository $invoiceRepository)
    {
        $this->invoiceRepository = $invoiceRepository;
        $this->user = $this->getAuthenticatedUser();
    }

    public function getStatisticForDashboard()
    {
        return Cache::remember('dashboard.statistic.' . $this->user->id, 300, function () {
            $invoices = $this->invoiceRepository->getCountsGroupedByStatus();

            return [
                'invoices' => [
                    'total' => $invoices->sum('invoices_count'),
                    'non_paid' => $invoices->where('is_paid', '0')->sum('invoices_count'),
                ],
                'sales' => [
                    'total' => $this->invoiceRepository->getPaidTotalAmount(),
                    'month' => $this->invoiceRepository->getPaidAmountCurrentMonth(),
                ],
                'clients' => Client::count(),
                'currency_code' => $this->user->getCurrencyCode(),
            ];
        });
    }
}
