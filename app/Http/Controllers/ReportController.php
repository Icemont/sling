<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ReportRequest;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;

class ReportController extends Controller
{
    public function form(): View
    {
        return view('reports.form');
    }

    public function create(ReportRequest $request): Response|View
    {
        $params = $request->getPreparedPayload();
        $invoices = Invoice::getForReport($params['from_date'], $params['to_date']);

        $data = [
            'params' => $params,
            'report' => $invoices->groupBy('client_id'),
            'total' => $invoices->sum('amount'),
            'user' => auth()->user(),
        ];

        if ($params['download']) {
            $pdf = Pdf::loadView('reports.sales-report', $data);
            return $pdf->download('report-' . now()->format('d-m-Y') . '.pdf');
        }

        return view('reports.show', $data);
    }
}
