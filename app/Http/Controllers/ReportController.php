<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ReportRequest;
use App\Repositories\InvoiceRepository;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;

class ReportController extends Controller
{
    public function form(): View|Factory
    {
        return view('reports.form');
    }

    public function create(ReportRequest $request, InvoiceRepository $invoiceRepository): View|Factory|Response
    {
        $reportParameters = $request->getPayload();
        $invoices = $invoiceRepository->getForReportByDates($reportParameters->dateFrom, $reportParameters->dateTo);

        $reportData = [
            'reportParameters' => $reportParameters,
            'report' => $invoices->groupBy('client_id'),
            'total' => $invoices->sum('amount'),
            'user' => auth()->user(),
        ];

        if ($reportParameters->download) {
            $pdf = Pdf::loadView('reports.sales-report', $reportData);
            return $pdf->download('report-' . now()->format('d-m-Y') . '.pdf');
        }

        return view('reports.show', $reportData);
    }
}
