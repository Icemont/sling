<x-app-layout>
    <x-slot name="header">
        <div class="d-flex">
            <ol class="page-title breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                <li class="breadcrumb-item active" aria-current="page">{{ __('Invoices') }}</li>
            </ol>
            <div class="ms-auto">
                <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-add" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-plus" width="24"
                         height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                        <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path>
                        <line x1="12" y1="11" x2="12" y2="17"></line>
                        <line x1="9" y1="14" x2="15" y2="14"></line>
                    </svg>
                    {{ __('Create Invoice') }}
                </a>
            </div>
        </div>
    </x-slot>
    <div class="row row-cards">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if(count($invoices))
                        <div class="table-responsive">
                            <table class="table table-vcenter">
                                <thead>
                                <tr>
                                    <th>{{ __('ID') }}</th>
                                    <th>{{ __('Invoice') }}</th>
                                    <th>{{ __('Total Price') }}</th>
                                    <th>{{ __('Amount Paid') }}</th>
                                    <th>{{ __('Client') }}</th>
                                    <th>{{ __('Invoice Date') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th class="w-1"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($invoices as $invoice)
                                    <tr>
                                        <td>{{ $invoice->id }}</td>
                                        <td>
                                            <a href="{{ route('invoices.show', ['invoice' => $invoice->id]) }}">{{ $invoice->invoice_number }}</a>
                                        </td>
                                        <td class="text-muted">{{ $invoice->product_price }} {{ $invoice->currency->code() }}</td>
                                        <td class="text-muted">{{ round($invoice->amount ?? 0, 2) }} {{ $user->currency->code() }}</td>
                                        <td>
                                            <a href="{{ route('clients.show', ['client' => $invoice->client->id]) }}">{{ $invoice->client->name }}</a>
                                        </td>
                                        <td class="text-muted">{{ $invoice->invoice_date ? $invoice->invoice_date->format('d.m.Y') : '—' }}</td>

                                        <td class="text-nowrap">
                                            @if($invoice->is_paid)
                                                <span class="badge bg-green-lt">{{ __('Paid') }}{{ $invoice->payment_date ? ' ' . $invoice->payment_date->format('d.m.Y') : '' }}</span>
                                            @else
                                                <span class="badge bg-primary-lt">{{ __('Created') }}</span>
                                            @endif
                                        </td>
                                        <td class="text-end text-nowrap">
                                            <a href="{{ route('invoices.edit', ['invoice' => $invoice->id]) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Edit') }}">
                                                <x-icon-edit class="text-red"/>
                                            </a>
                                            <a class="ms-2" href="{{ route('invoices.download', ['invoice' => $invoice->id]) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Download') }}">
                                                <x-icon-download />
                                            </a>
                                            <a class="ms-2" href="{{ route('invoices.show', ['invoice' => $invoice->id]) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Show') }}">
                                                <x-icon-show />
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="card-footer d-flex align-items-center">
                                <p class="m-0 text-muted">{{ __('Showing :first to :last of :total entries', [
                                        'first' => $invoices->firstItem(),
                                        'last' => $invoices->lastItem(),
                                        'total' => $invoices->total(),
                                    ]) }}</p>
                                @if($invoices->hasPages())
                                    <p class="pagination m-0 ms-auto">{{ $invoices->links() }}</p>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="empty">
                            <div class="empty-img">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-lg text-primary"
                                     width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                     fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                                    <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path>
                                    <line x1="9" y1="7" x2="10" y2="7"></line>
                                    <line x1="9" y1="13" x2="15" y2="13"></line>
                                    <line x1="13" y1="17" x2="15" y2="17"></line>
                                </svg>
                            </div>
                            <p class="empty-title">{{ __('Invoices are managed from here') }}</p>
                            <p class="empty-subtitle text-secondary">
                                {{ __('There are no invoices in the database yet') }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="modal modal-blur fade" id="modal-add" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Create invoice') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('invoices.createform') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-label">{{ __('Select Client') }}</div>
                                <select name="client" class="form-select">
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-link link-secondary" data-bs-dismiss="modal">
                            {{ __('Cancel') }}
                        </button>
                        <button type="submit" class="btn btn-primary ms-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-plus"
                                 width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                 fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                                <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path>
                                <line x1="12" y1="11" x2="12" y2="17"></line>
                                <line x1="9" y1="14" x2="15" y2="14"></line>
                            </svg>
                            {{ __('Create Invoice') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
