<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReportRequest;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade as PDF;

class ReportController extends Controller
{
    public function form()
    {
        return view('reports.form');
    }

    public function create(ReportRequest $request)
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
            $pdf = PDF::loadView('reports.sales-report', $data);
            return $pdf->download('report-' . now()->format('d-m-Y') . '.pdf');
        }

        return view('reports.show', $data);
    }
}
