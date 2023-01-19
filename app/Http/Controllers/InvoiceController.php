<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceCreateFormRequest;
use App\Http\Requests\InvoiceStoreRequest;
use App\Models\Client;
use App\Models\Currency;
use App\Models\Invoice;
use App\Repositories\ClientRepository;
use App\Repositories\InvoiceRepository;
use App\Repositories\PaymentMethodRepository;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Str;
use Throwable;

class InvoiceController extends Controller
{
    public function __construct(private readonly InvoiceRepository $invoiceRepository)
    {
    }

    public function index(ClientRepository $clientRepository): View|Factory
    {
        return view('invoices.index', [
            'invoices' => $this->invoiceRepository->getPaginatedWithRelations(),
            'clients' => $clientRepository->getAllForSelector(),
            'user' => auth()->user(),
        ]);
    }

    public function createForm(InvoiceCreateFormRequest $request): Redirector|RedirectResponse
    {
        return redirect(route('invoices.create', ['client' => $request->getClientId()]));
    }

    public function create(PaymentMethodRepository $paymentMethodRepository, Client $client): View|Factory
    {
        return view('invoices.create', [
            'client' => $client,
            'user' => auth()->user(),
            'currencies' => Currency::all(),
            'payment_methods' => $paymentMethodRepository->getActiveForSelector(),
        ]);
    }

    /**
     * @throws Throwable
     */
    public function store(InvoiceStoreRequest $request): RedirectResponse
    {
        $invoice = $this->invoiceRepository->create($request);

        return redirect()
            ->route('invoices.index')
            ->with([
                'status' => __('New invoice ":invoice" successfully added!', ['invoice' => $invoice->invoice_number]),
                'type' => 'success'
            ]);
    }

    public function show(Invoice $invoice): View|Factory
    {
        return view('invoices.show', compact('invoice'));
    }

    public function download(Invoice $invoice): Response
    {
        $invoice->load(['user', 'user.address', 'currency', 'client', 'paymentMethod']);

        $pdf = Pdf::loadView('invoices.templates.invoice1', compact('invoice'));

        return $pdf->download(Str::slug($invoice->invoice_number ?? 'invoice') . '.pdf');
    }

    public function edit(PaymentMethodRepository $paymentMethodRepository, Invoice $invoice): View|Factory
    {
        $invoice->load('client');

        return view('invoices.edit', [
            'invoice' => $invoice,
            'user' => auth()->user(),
            'currencies' => Currency::all(),
            'payment_methods' => $paymentMethodRepository->getActiveForSelector(),
        ]);
    }

    /**
     * @throws AuthorizationException
     */
    public function update(InvoiceStoreRequest $request, Invoice $invoice): RedirectResponse
    {
        $this->authorize('owner', $invoice);

        $this->invoiceRepository->update($invoice, $request);

        return redirect()
            ->route('invoices.index')
            ->with([
                'status' => __('Invoice ":invoice" successfully updated!', ['invoice' => $invoice->invoice_number]),
                'type' => 'success'
            ]);
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(Invoice $invoice): RedirectResponse
    {
        $this->authorize('owner', $invoice);

        $invoice->delete();

        return redirect()->route('invoices.index')->with([
            'status' => __('Invoice ":invoice" deleted!', ['invoice' => $invoice->invoice_number]),
            'type' => 'info'
        ]);
    }
}
