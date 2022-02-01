<x-app-layout>
    <x-slot name="header">
        <div class="d-flex">
            <h2 class="page-title">
                {{ __('Invoices') }}
            </h2>
        </div>
    </x-slot>
    @if ($errors->any())
        <div class="alert alert-danger">
            <h4 class="alert-title">{{ __('Invoice was not updated because there are errors in the form') }}
                :</h4>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row row-cards">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __('Edit invoice ":invoice" for client ":client"', ['invoice' => $invoice->invoice_number, 'client' => $invoice->client->name]) }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('invoices.update', ['invoice' => $invoice->id]) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="row mb-2">
                            <div class="col-lg-8">
                                <div class="mb-3">
                                    <label class="form-label required">{{ __('Product or Service Name') }}</label>
                                    <input type="text" name="product_name" value="{{ $invoice->product_name }}"
                                           class="form-control"
                                           required>
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
                                                   required>
                                        </div>
                                        <div class="col-5">
                                            <select id="currency" class="form-select" name="currency_id">
                                                @foreach($currencies as $currency)
                                                    <option value="{{ $currency->id }}" data-code="{{ $currency->code }}"{!! $currency->id == $invoice->currency_id
                                ? ' selected="selected"' : '' !!}>{{ $currency->symbol }} ({{ $currency->code }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label required">{{ __('Invoice Number') }}</label>
                                    <input type="text" name="invoice_number" value="{{ $invoice->invoice_number }}"
                                           class="form-control" required>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label required">{{ __('Invoice Date') }}</label>
                                    <input class="form-control" id="invoice_date" name="invoice_date"
                                           value="{{ ($invoice->invoice_date ?? now())->format('Y-m-d') }}" required>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label required">{{ __('Payment Method') }}</label>
                                    <select class="form-select" name="payment_method_id">
                                        @foreach($payment_methods as $payment_method)
                                            <option value="{{ $payment_method->id }}"{!! $payment_method->id == $invoice->payment_method_id
                                ? ' selected="selected"' : '' !!}>{{ $payment_method->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-check">
                                        <input class="form-check-input" type="checkbox" id="is_paid" name="is_paid"
                                               value="1"{{ $invoice->is_paid ? ' checked' : '' }}>
                                        <span class="form-check-label">{{ __('Mark as paid') }}</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div id="paid-form" class="row mb-2 d-none">
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label required">{{ __('Payment Date') }}</label>
                                    <input class="form-control" id="payment_date" name="payment_date"
                                           value="{{ ($invoice->payment_date ?? now())->format('Y-m-d') }}">
                                </div>
                            </div>
                            <div id="exchange-rate" class="col-lg-4 d-none">
                                <div class="mb-3">
                                    <label class="form-label required">
                                        {{ __('Exchange Rate') }}
                                        <div class="form-label-description">
                                            <div id="exchange-rate-spinner" class="spinner-border spinner-border-sm text-blue d-none" role="status"></div>
                                            <button type="button" class="btn btn-sm btn-primary" id="exchange-rate-btn">
                                                {{ __('Get From Exchange Rate Provider') }}
                                            </button>
                                        </div>
                                    </label>
                                    <input id="exchange_rate_input" class="form-control" name="exchange_rate"
                                           value="{{ $invoice->exchange_rate }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-8">
                                <div>
                                    <label class="form-label">{{ __('Note') }}</label>
                                    <textarea name="note" class="form-control" rows="3">{{ $invoice->note }}</textarea>
                                </div>
                            </div>
                            <div class="form-footer text-end mt-lg-0">
                                <button type="submit" class="btn btn-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit"
                                         width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                         stroke="currentColor"
                                         fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3"></path>
                                        <path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3"></path>
                                        <line x1="16" y1="5" x2="19" y2="8"></line>
                                    </svg>
                                    {{ __('Update Invoice') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('invoices.partials.form-js', ['currency_id' => $user->currency_id])
</x-app-layout>
