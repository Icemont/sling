<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $statistic = Cache::remember('dashboard.statistic.' . auth()->id(), 300, function () {
            $invoices = Invoice::getCountsGroupedByStatus();
            $sales = Invoice::getPaidTotalAmount();
            $sales_month = Invoice::getPaidAmountCurrentMonth();

            return [
                'invoices' => [
                    'total' => $invoices->sum('invoices_count'),
                    'non_paid' => $invoices->where('is_paid', '0')->sum('invoices_count'),
                ],
                'sales' => [
                    'total' => $sales,
                    'month' => $sales_month,
                ],
                'clients' => Client::count(),
                'currency_code' => auth()->user()->getCurrencyCode(),
            ];
        });

        return view('dashboard', compact('statistic'));
    }
}
