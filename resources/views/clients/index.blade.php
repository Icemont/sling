<x-app-layout>
    <x-slot name="header">
        <div class="d-flex">
            <h2 class="page-title">
                {{ __('Clients') }}
            </h2>
            <div class="ms-auto">
                <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-add" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-plus" width="24"
                         height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                        <path d="M16 11h6m-3 -3v6"></path>
                    </svg>
                    {{ __('Add client') }}
                </a>
            </div>
        </div>
    </x-slot>
    @if ($errors->any())
        <div class="alert alert-danger">
            <h4 class="alert-title">{{ __('New client was not added because there are errors in the form') }}:</h4>
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
                    @if(count($clients))
                        <div class="table-responsive">
                            <script type="text/javascript">
                                function deleteConfirm() {
                                    return confirm('{{ __('Are you sure you want to delete this client along with the invoices?') }}');
                                }
                            </script>
                            <table
                                class="table table-vcenter">
                                <thead>
                                <tr>
                                    <th>{{ __('ID') }}</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('E-mail') }}</th>
                                    <th>{{ __('Phone') }}</th>
                                    <th>{{ __('Created') }}</th>
                                    <th class="w-1"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($clients as $client)
                                    <tr>
                                        <td>{{ $client->id }}</td>
                                        <td>
                                            <a href="{{ route('clients.show', ['client' => $client->id]) }}">{{ $client->name }}</a>
                                        </td>
                                        <td class="text-muted">{{ $client->email }}</td>
                                        <td class="text-muted">{{ $client->phone ?: '—' }}</td>
                                        <td class="text-muted">{{ $client->created_at->format('d.m.Y') }}</td>
                                        <td>
                                            <div class="btn-list flex-nowrap">
                                                <a class="btn btn-outline-primary"
                                                   href="{{ route('clients.edit', ['client' => $client->id]) }}">{{ __('Edit') }}</a>
                                                <form class="d-inline"
                                                      action="{{ route('clients.destroy', ['client' => $client->id]) }}"
                                                      method="post" onsubmit="return deleteConfirm();">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="btn btn-outline-danger">{{ __('Delete') }}</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            @if($clients->hasPages())
                                <div class="card-footer d-flex align-items-center">
                                    <p class="m-0 text-muted">{{ __('Showing :first to :last of :total entries',
['first' => $clients->firstItem(), 'last' => $clients->lastItem(), 'total' => $clients->total()]) }}</p>
                                    <p class="pagination m-0 ms-auto">
                                        {{ $clients->links() }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    @else
                        {{ __('There are no clients in the database yet!') }}
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-blur fade" id="modal-add" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Add client') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('clients.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label required">{{ __('Client Name') }}</label>
                                    <input type="text" name="name" value="{{ old('name') }}" class="form-control"
                                           required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Company') }}</label>
                                    <input type="text" name="company" value="{{ old('company') }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label required">{{ __('E-mail') }}</label>
                                    <input type="email" name="email" value="{{ old('email') }}" class="form-control"
                                           required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Phone Number') }}</label>
                                    <input type="text" name="phone" value="{{ old('phone') }}" class="form-control"
                                           data-mask="[000000000000000]" data-mask-visible="false">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label required">{{ __('Invoice Number Prefix') }}</label>
                                    <div class="input-group input-group-flat">
                                        <input type="text" name="invoice_prefix" value="{{ old('invoice_prefix') }}"
                                               class="form-control text-end pe-0" autocomplete="off" required>
                                        <span class="input-group-text">0000</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label required">{{ __('Invoice Number Index') }}</label>
                                    <input type="text" name="invoice_index" value="{{ old('invoice_index') ?? '1' }}" class="form-control"
                                           data-mask="[00000000]" data-mask-visible="false" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label required">{{ __('Country') }}</label>
                                    <input type="text" name="country" value="{{ old('country') }}" class="form-control"
                                           required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('State') }} / {{ __('Region') }}
                                        / {{ __('Province') }}</label>
                                    <input type="text" name="state" value="{{ old('state') }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label required">{{ __('City') }}</label>
                                    <input type="text" name="city" value="{{ old('city') }}" class="form-control"
                                           required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('ZIP') }} / {{ __('Postal Code') }}</label>
                                    <input type="text" name="zip" value="{{ old('zip') }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label required">{{ __('Address Line 1') }}</label>
                                    <input type="text" name="street1" value="{{ old('street1') }}" class="form-control"
                                           required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Address Line 2') }}</label>
                                    <input type="text" name="street2" value="{{ old('street2') }}" class="form-control">
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div>
                                    <label class="form-label">{{ __('Note') }}</label>
                                    <textarea name="note" class="form-control" rows="3">{{ old('note') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-link link-secondary" data-bs-dismiss="modal">
                            {{ __('Cancel') }}
                        </button>
                        <button type="submit" class="btn btn-primary ms-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-plus"
                                 width="24"
                                 height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                <path d="M16 11h6m-3 -3v6"></path>
                            </svg>
                            {{ __('Add New Client') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
