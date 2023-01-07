<x-app-layout>
    <x-slot name="header">
        <div class="d-flex">
            <h2 class="page-title">
                {{ __('Clients') }}
            </h2>
        </div>
    </x-slot>
    @if ($errors->any())
        <div class="alert alert-danger">
            <h4 class="alert-title">{{ __('Client was not updated because there are errors in the form') }}:</h4>
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
                    <h4 class="card-title">{{ __('Edit client #:client', ['client' => $client->id]) }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('clients.update', ['client' => $client->id]) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="row border-bottom pb-2">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label required">{{ __('Client Name') }}</label>
                                    <input type="text" name="name" value="{{ $client->name }}" class="form-control"
                                           required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Company') }}</label>
                                    <input type="text" name="company" value="{{ $client->company }}"
                                           class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label required">{{ __('E-mail') }}</label>
                                    <input type="email" name="email" value="{{ $client->email }}" class="form-control"
                                           required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Phone Number') }}</label>
                                    <input type="text" name="phone" value="{{ $client->phone }}" class="form-control"
                                           data-mask="[000000000000000]" data-mask-visible="false">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label required">{{ __('Invoice Number Prefix') }}</label>
                                    <div class="input-group input-group-flat">
                                        <input type="text" name="invoice_prefix" value="{{ $client->invoice_prefix }}"
                                               class="form-control text-end pe-0" autocomplete="off" required>
                                        <span class="input-group-text">0000</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label required">{{ __('Invoice Number Index') }}</label>
                                    <input type="text" name="invoice_index" value="{{ $client->invoice_index }}" class="form-control"
                                           data-mask="[00000000]" data-mask-visible="false" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label required">{{ __('Country') }}</label>
                                    <input type="text" name="country" value="{{ $client->address?->country }}"
                                           class="form-control" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('State') }} / {{ __('Region') }}
                                        / {{ __('Province') }}</label>
                                    <input type="text" name="state" value="{{ $client->address?->state }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label required">{{ __('City') }}</label>
                                    <input type="text" name="city" value="{{ $client->address?->city }}" class="form-control"
                                           required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('ZIP') }} / {{ __('Postal Code') }}</label>
                                    <input type="text" name="zip" value="{{ $client->address?->zip }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label required">{{ __('Address Line 1') }}</label>
                                    <input type="text" name="street1" value="{{ $client->address?->street1 }}"
                                           class="form-control" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Address Line 2') }}</label>
                                    <input type="text" name="street2" value="{{ $client->address?->street2 }}"
                                           class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div>
                                    <label class="form-label">{{ __('Note') }}</label>
                                    <textarea name="note" class="form-control" rows="3">{{ $client->note }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-footer text-end">
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
</x-app-layout>
