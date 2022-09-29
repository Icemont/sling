<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceStoreRequest;
use App\Http\Requests\InvoiceUpdateRequest;
use App\Models\Client;
use App\Models\Currency;
use App\Models\Invoice;
use App\Models\PaymentMethod;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class InvoiceController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();
        $invoices = Invoice::getPaginated();
        $clients = Client::all(['id', 'name']);

        return view('invoices.index', compact('invoices', 'clients', 'user'));
    }

    public function createForm(Request $request): RedirectResponse
    {
        $request->validate(['client' => [
            'required',
            'integer',
            Rule::exists('clients', 'id')->where(function ($query) {
                return $query->where('user_id', auth()->id());
            }),
        ]]);

        return redirect(route('invoices.create', ['client' => $request->client]));
    }

    public function create(Client $client): View
    {
        $user = auth()->user();
        $currencies = Currency::all();
        $payment_methods = PaymentMethod::active()->get(['id', 'name']);

        return view('invoices.create', compact('client', 'user', 'currencies', 'payment_methods'));
    }

    public function store(InvoiceStoreRequest $request): RedirectResponse
    {
        $invoice = auth()->user()->createInvoice($request->validated());

        return redirect()
            ->route('invoices.index')
            ->with([
                'status' => __('New invoice ":invoice" successfully added!', ['invoice' => $invoice->invoice_number]),
                'type' => 'success'
            ]);
    }

    public function show(Invoice $invoice): View
    {
        return view('invoices.show', compact('invoice'));
    }

    public function download(Invoice $invoice): Response
    {
        $invoice->load(['user', 'user.address', 'currency', 'client', 'paymentMethod']);

        $pdf = Pdf::loadView('invoices.templates.invoice1', compact('invoice'));

        return $pdf->download(Str::slug($invoice->invoice_number ?? 'invoice') . '.pdf');
    }

    public function edit(Invoice $invoice): View
    {
        $invoice->load('client');

        $user = auth()->user();
        $currencies = Currency::all();
        $payment_methods = PaymentMethod::active()->get(['id', 'name']);

        return view('invoices.edit', compact('invoice', 'user', 'currencies', 'payment_methods'));
    }

    /**
     * @throws AuthorizationException
     */
    public function update(InvoiceUpdateRequest $request, Invoice $invoice): RedirectResponse
    {
        $this->authorize('owner', $invoice);

        $invoice->updateInvoice($request->validated());

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
