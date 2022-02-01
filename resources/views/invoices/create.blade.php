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
            <h4 class="alert-title">{{ __('New invoice was not added because there are errors in the form') }}
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
                    <h4 class="card-title">{{ __('Create an invoice for the client ":client"', ['client' => $client->name]) }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('invoices.store') }}" method="post">
                        @csrf
                        <input type="hidden" name="client_id" value="{{ $client->id }}">
                        <div class="row mb-2">
                            <div class="col-lg-8">
                                <div class="mb-3">
                                    <label class="form-label required">{{ __('Product or Service Name') }}</label>
                                    <input type="text" name="product_name" value="{{ old('product_name') }}"
                                           class="form-control"
                                           required>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Price') }}</label>
                                    <div class="row">
                                        <div class="col-7">
                                            <input type="text" name="product_price" value="{{ old('product_price') }}"
                                                   class="form-control"
                                                   required>
                                        </div>
                                        <div class="col-5">
                                            <select id="currency" class="form-select" name="currency_id">
                                                @foreach($currencies as $currency)
                                                    <option value="{{ $currency->id }}" data-code="{{ $currency->code }}"{!! $currency->id == ( old('currency_id') ?? $user->currency_id ?? '1')
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
                                    <input type="text" name="invoice_number" value="{{ old('invoice_number') ??
$client->invoice_prefix . Str::padLeft($client->invoice_index, config('app.invoice_index_length'), '0') }}"
                                           class="form-control" required>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label required">{{ __('Invoice Date') }}</label>
                                    <input type="text" class="form-control" id="invoice_date" name="invoice_date"
                                           value="{{ old('invoice_date') ?? now()->format('Y-m-d') }}" required>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label required">{{ __('Payment Method') }}</label>
                                    <select class="form-select" name="payment_method_id">
                                        @foreach($payment_methods as $payment_method)
                                            <option
                                                value="{{ $payment_method->id }}"{!! $payment_method->id == old('payment_method_id')
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
                                               value="1"{{ old('is_paid') ? ' checked' : '' }}>
                                        <span class="form-check-label">{{ __('Mark as paid') }}</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div id="paid-form" class="row mb-2 d-none">
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label required">{{ __('Payment Date') }}</label>
                                    <input type="text" class="form-control" id="payment_date" name="payment_date"
                                           value="{{ old('payment_date') ?? now()->format('Y-m-d') }}">
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
                                    <input id="exchange_rate_input" type="text" class="form-control" name="exchange_rate"
                                           value="{{ old('exchange_rate') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-8">
                                <div>
                                    <label class="form-label">{{ __('Note') }}</label>
                                    <textarea name="note" class="form-control" rows="3">{{ old('note') }}</textarea>
                                </div>
                            </div>
                            <div class="form-footer text-end mt-lg-0">
                                <button type="submit" class="btn btn-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="icon icon-tabler icon-tabler-file-plus"
                                         width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                         stroke="currentColor"
                                         fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                                        <path
                                            d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path>
                                        <line x1="12" y1="11" x2="12" y2="17"></line>
                                        <line x1="9" y1="14" x2="15" y2="14"></line>
                                    </svg>
                                    {{ __('Create Invoice') }}
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
