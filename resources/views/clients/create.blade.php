<x-app-layout>
    <x-slot name="header">
        <div class="d-flex">
            <ol class="page-title breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                <li class="breadcrumb-item"><a href="{{ route('clients.index') }}">{{ __('Clients') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('Create') }}</li>
            </ol>
        </div>
    </x-slot>
    <x-errors :errors="$errors" title="{{ __('Client was not created because there are errors in the form') }}" />
    <div class="row row-cards">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('clients.store') }}" method="post">
                        @csrf
                        <div class="row border-bottom pb-2">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label required">{{ __('Client Name') }}</label>
                                    <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
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
                                    <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
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
                                        <input type="text" name="invoice_prefix" value="{{ old('invoice_prefix') }}" class="form-control text-end pe-0" autocomplete="off" required>
                                        <span class="input-group-text">0000</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label required">{{ __('Invoice Number Index') }}</label>
                                    <input type="text" name="invoice_index" value="{{ old('invoice_index') }}" class="form-control"
                                           data-mask="[00000000]" data-mask-visible="false" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label required">{{ __('Country') }}</label>
                                    <input type="text" name="country" value="{{ old('country') }}" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('State') }} / {{ __('Region') }} / {{ __('Province') }}</label>
                                    <input type="text" name="state" value="{{ old('state') }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label required">{{ __('City') }}</label>
                                    <input type="text" name="city" value="{{ old('city') }}" class="form-control" required>
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
                                    <input type="text" name="street1" value="{{ old('street1') }}" class="form-control" required>
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
                        <div class="form-footer text-end">
                            <button type="submit" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                    <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                    <path d="M16 11h6m-3 -3v6"></path>
                                </svg>
                                {{ __('Add Client') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
