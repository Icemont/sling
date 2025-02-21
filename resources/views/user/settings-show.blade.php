<x-app-layout>
    <x-slot name="header">
        <div class="d-flex">
            <ol class="page-title breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                <li class="breadcrumb-item active" aria-current="page">{{ __('Profile settings') }}</li>
            </ol>
            <div class="ms-auto">
                <a href="{{ route('user.settings.edit') }}" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon ">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                        <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                        <path d="M16 5l3 3" />
                    </svg>
                    {{ __('Edit Settings') }}
                </a>
            </div>
        </div>
    </x-slot>
    <div class="row row-cards">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                        <div class="row border-bottom pb-2">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('User Name') }}</label>
                                    <input type="text" name="name" value="{{ $user->name }}" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('E-mail') }}</label>
                                    <input type="email" name="email" value="{{ $user->email }}" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Phone Number') }}</label>
                                    <input type="text" name="phone" value="{{ $user->phone }}" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Business Name') }}</label>
                                    <input type="text" name="business[name]" value="{{ $user->business->name }}" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Identification Number') }}</label>
                                    <input type="text" name="business[code]" value="{{ $user->business->code }}" class="form-control" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Country') }}</label>
                                    <input type="text" name="country" value="{{ $user->address?->country }}" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('State') }} / {{ __('Region') }} / {{ __('Province') }}</label>
                                    <input type="text" name="state" value="{{ $user->address?->state }}" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('City') }}</label>
                                    <input type="text" name="city" value="{{ $user->address?->city }}" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('ZIP') }} / {{ __('Postal Code') }}</label>
                                    <input type="text" name="zip" value="{{ $user->address?->zip }}" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Address Line 1') }}</label>
                                    <input type="text" name="street1" value="{{ $user->address?->street1 }}" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Address Line 2') }}</label>
                                    <input type="text" name="street2" value="{{ $user->address?->street2 }}" class="form-control" disabled>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
