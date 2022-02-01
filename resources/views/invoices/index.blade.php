<x-app-layout>
    <x-slot name="header">
        <div class="d-flex">
            <h2 class="page-title">
                {{ __('Invoices') }}
            </h2>
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
    @if ($errors->any())
        <div class="alert alert-danger">
            <h4 class="alert-title">{{ __('New invoice was not added because there are errors in the form') }}:</h4>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session('status'))
        <x-alert :type="session('type')" :message="session('status')" class="mb-2"/>
    @endif
    <div class="row row-cards">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if(count($invoices))
                        <div class="table-responsive" style="min-height:20em;">
                            <script type="text/javascript">
                                function deleteConfirm() {
                                    return confirm('{{ __('Are you sure you want to delete this invoice?') }}');
                                }
                            </script>
                            <table
                                class="table table-vcenter">
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
                                        <td class="text-muted">{{ $invoice->product_price }} {{ $invoice->currency->code }}</td>
                                        <td class="text-muted">{{ round($invoice->amount ?? 0, 2) }} {{ $user->currency->code }}</td>
                                        <td>
                                            <a href="{{ route('clients.show', ['client' => $invoice->client->id]) }}">{{ $invoice->client->name }}</a>
                                        </td>
                                        <td class="text-muted">{{ $invoice->invoice_date ? $invoice->invoice_date->format('d.m.Y') : '—' }}</td>
                                        <td class="small">
                                            @if($invoice->is_paid)
                                                <span
                                                    class="badge bg-success">{{ __('Paid') }}{{ $invoice->payment_date ? ' ' . $invoice->payment_date->format('d.m.Y') : '' }}</span>
                                            @else
                                                <span class="badge bg-primary">{{ __('Created') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-list flex-nowrap">
                                                <div class="dropdown">
                                                    <button class="btn dropdown-toggle align-text-top"
                                                            data-bs-toggle="dropdown">
                                                        Actions
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a class="dropdown-item"
                                                           href="{{ route('invoices.edit', ['invoice' => $invoice->id]) }}">
                                                            {{ __('Edit') }}{{ $invoice->is_paid ? '' : ' / ' . __('Mark as paid') }}
                                                        </a>
                                                        <a class="dropdown-item"
                                                           href="{{ route('invoices.download', ['invoice' => $invoice->id]) }}">
                                                            {{ __('Download') }}
                                                        </a>
                                                        <form class="d-inline"
                                                              action="{{ route('invoices.destroy', ['invoice' => $invoice->id]) }}"
                                                              method="post" onsubmit="return deleteConfirm();">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                    class="dropdown-item">{{ __('Delete') }}</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            @if($invoices->hasPages())
                                <div class="card-footer d-flex align-items-center">
                                    <p class="m-0 text-muted">{{ __('Showing :first to :last of :total entries',
['first' => $invoices->firstItem(), 'last' => $invoices->lastItem(), 'total' => $invoices->total()]) }}</p>
                                    <p class="pagination m-0 ms-auto">
                                        {{ $invoices->links() }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    @else
                        {{ __('There are no invoices in the database yet!') }}
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
