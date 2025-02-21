<x-app-layout>
    <x-slot name="header">
        <div class="d-flex">
            <ol class="page-title breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                <li class="breadcrumb-item"><a href="{{ route('clients.index') }}">{{ __('Clients') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('Edit #:id', ['id' => $client->id]) }}</li>
            </ol>
        </div>
    </x-slot>
    <x-errors :errors="$errors" title="{{ __('Client was not updated because there are errors in the form') }}" />
    <div class="row row-cards">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('clients.update', ['client' => $client->id]) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="row border-bottom pb-2">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label required">{{ __('Client Name') }}</label>
                                    <input type="text" name="name" value="{{ old('name', $client->name) }}" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Company') }}</label>
                                    <input type="text" name="company" value="{{ old('company', $client->company) }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label required">{{ __('E-mail') }}</label>
                                    <input type="email" name="email" value="{{ old('email', $client->email) }}" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Phone Number') }}</label>
                                    <input type="text" name="phone" value="{{ old('phone', $client->phone) }}" class="form-control"
                                           data-mask="[000000000000000]" data-mask-visible="false">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label required">{{ __('Invoice Number Prefix') }}</label>
                                    <div class="input-group input-group-flat">
                                        <input type="text" name="invoice_prefix" value="{{ old('invoice_prefix', $client->invoice_prefix) }}"
                                               class="form-control text-end pe-0" autocomplete="off" required>
                                        <span class="input-group-text">0000</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label required">{{ __('Invoice Number Index') }}</label>
                                    <input type="text" name="invoice_index" value="{{ old('invoice_index', $client->invoice_index) }}" class="form-control"
                                           data-mask="[00000000]" data-mask-visible="false" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label required">{{ __('Country') }}</label>
                                    <input type="text" name="country" value="{{ old('country', $client->address?->country) }}" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('State') }} / {{ __('Region') }} / {{ __('Province') }}</label>
                                    <input type="text" name="state" value="{{ old('state', $client->address?->state) }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label required">{{ __('City') }}</label>
                                    <input type="text" name="city" value="{{ old('city', $client->address?->city) }}" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('ZIP') }} / {{ __('Postal Code') }}</label>
                                    <input type="text" name="zip" value="{{ old('zip', $client->address?->zip) }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label required">{{ __('Address Line 1') }}</label>
                                    <input type="text" name="street1" value="{{ old('street1', $client->address?->street1) }}" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Address Line 2') }}</label>
                                    <input type="text" name="street2" value="{{ old('street2', $client->address?->street2) }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div>
                                    <label class="form-label">{{ __('Note') }}</label>
                                    <textarea name="note" class="form-control" rows="3">{{ old('note', $client->note) }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-footer text-end">
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteConfirm">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M4 7h16" />
                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                    <path d="M10 12l4 4m0 -4l-4 4" />
                                </svg>
                                {{ __('Delete') }}
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit"
                                     width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                     fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3"></path>
                                    <path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3"></path>
                                    <line x1="16" y1="5" x2="19" y2="8"></line>
                                </svg>
                                {{ __('Update Client') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteConfirm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteConfirmLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('Close') }}"></button>
                <div class="modal-status bg-danger"></div>
                <div class="modal-body text-center py-4">
                    <i class="fa-solid fa-triangle-exclamation text-danger mb-2" style="font-size:xxx-large"></i>
                    <h3>{{ __('Delete confirmation') }}</h3>
                    <div class="text-muted">{{ __('Are you sure you want to delete this client along with the invoices?') }}</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fa-solid fa-ban"></i>&nbsp;{{ __('Cancel') }}
                    </button>
                    <form class="ms-auto" method="post"
                          action="{{ route('clients.destroy', ['client' => $client->id]) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fa-solid fa-trash-can"></i>&nbsp;{{ __('Delete') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
