<x-app-layout>
    <x-slot name="header">
        <div class="d-flex">
            <h2 class="page-title">
                {{ __('Clients') }}
            </h2>
        </div>
    </x-slot>

    <div class="row row-cards">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __('Client #:client information', ['client' => $client->id]) }}</h4>
                </div>
                <div class="card-body">
                    <div class="row border-bottom pb-2">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">{{ __('Client Name') }}</label>
                                <input type="text" name="name" value="{{ $client->name }}" class="form-control"
                                       readonly>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">{{ __('Company') }}</label>
                                <input type="text" name="company" value="{{ $client->company }}" class="form-control"
                                       readonly>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">{{ __('E-mail') }}</label>
                                <input type="email" name="email" value="{{ $client->email }}" class="form-control"
                                       readonly>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">{{ __('Phone Number') }}</label>
                                <input type="text" name="phone" value="{{ $client->phone }}" class="form-control"
                                       readonly>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">{{ __('Invoice Number Prefix') }}</label>
                                <input type="text" name="invoice_prefix" value="{{ $client->invoice_prefix }}"
                                       class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label required">{{ __('Invoice Number Index') }}</label>
                                <input type="text" name="invoice_index" value="{{ $client->invoice_index }}"
                                       class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">{{ __('Country') }}</label>
                                <input type="text" name="country" value="{{ $address->country }}"
                                       class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">{{ __('State') }} / {{ __('Region') }}
                                    / {{ __('Province') }}</label>
                                <input type="text" name="state" value="{{ $address->state }}" class="form-control"
                                       readonly>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">{{ __('City') }}</label>
                                <input type="text" name="city" value="{{ $address->city }}" class="form-control"
                                       readonly>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">{{ __('ZIP') }} / {{ __('Postal Code') }}</label>
                                <input type="text" name="zip" value="{{ $address->zip }}" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">{{ __('Address Line 1') }}</label>
                                <input type="text" name="street1" value="{{ $address->street1 }}"
                                       class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">{{ __('Address Line 2') }}</label>
                                <input type="text" name="street2" value="{{ $address->street2 }}"
                                       class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div>
                                <label class="form-label">{{ __('Note') }}</label>
                                <textarea name="note" class="form-control" rows="3"
                                          readonly>{{ $client->note }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-footer text-end">
                        <a class="btn btn-primary" href="{{ route('clients.edit', ['client' => $client->id]) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit"
                                 width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                 fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3"></path>
                                <path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3"></path>
                                <line x1="16" y1="5" x2="19" y2="8"></line>
                            </svg>
                            {{ __('Edit Client') }}
                        </a>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
