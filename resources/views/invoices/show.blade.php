<x-app-layout>
    <x-slot name="header">
        <div class="d-flex">
            <h2 class="page-title">
                {{ __('Invoices') }}
            </h2>
        </div>
    </x-slot>
    <div class="row row-cards">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __('Invoice ":invoice" information', ['invoice' => $invoice->invoice_number]) }}</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-lg-8">
                            <div class="mb-3">
                                <label class="form-label">{{ __('Product or Service Name') }}</label>
                                <input type="text" name="product_name" value="{{ $invoice->product_name }}"
                                       class="form-control"
                                       readonly>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">{{ __('Price') }}</label>
                                <div class="row">
                                    <div class="col-7">
                                        <input type="text" name="product_price"
                                               value="{{ $invoice->product_price }}"
                                               class="form-control"
                                               readonly>
                                    </div>
                                    <div class="col-5">
                                        <select id="currency" class="form-select" name="currency_id" disabled>
                                            <option selected="selected">{{ $invoice->currency->symbol }}
                                                ({{ $invoice->currency->code }})
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">{{ __('Invoice Number') }}</label>
                                <input type="text" name="invoice_number" value="{{ $invoice->invoice_number }}"
                                       class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">{{ __('Invoice Date') }}</label>
                                <input class="form-control" id="invoice_date" name="invoice_date"
                                       value="{{ $invoice->invoice_date ? $invoice->invoice_date->format('Y-m-d') : '' }}"
                                       readonly>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">{{ __('Payment Method') }}</label>
                                <select class="form-select" disabled>
                                    <option selected="selected">{{ $invoice->paymentMethod->name }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-12">
                            <div class="mb-3">
                                @if($invoice->is_paid)
                                    <span class="badge bg-success me-1">{{ __('Paid') }}</span>
                                @else
                                    <span class="badge bg-primary me-1">{{ __('Created') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @if($invoice->is_paid)
                        <div class="row mb-2">
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Payment Date') }}</label>
                                    <input class="form-control"
                                           value="{{ $invoice->payment_date ? $invoice->payment_date->format('Y-m-d') : '' }}"
                                           readonly>
                                </div>
                            </div>
                            @if($invoice->currency_id != auth()->user()->currency_id)
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">
                                            {{ __('Exchange Rate') }}
                                        </label>
                                        <input class="form-control" name="exchange_rate"
                                               value="{{ $invoice->exchange_rate }}" readonly>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-lg-8">
                            <div>
                                <label class="form-label">{{ __('Note') }}</label>
                                <textarea name="note" class="form-control" rows="3"
                                          readonly>{{ $invoice->note }}</textarea>
                            </div>
                        </div>
                        <div class="form-footer text-end mt-lg-0">
                            <a class="btn btn-primary"
                               href="{{ route('invoices.edit', ['invoice' => $invoice->id]) }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit"
                                     width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                     fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3"></path>
                                    <path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3"></path>
                                    <line x1="16" y1="5" x2="19" y2="8"></line>
                                </svg>
                                {{ __('Edit Invoice') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
