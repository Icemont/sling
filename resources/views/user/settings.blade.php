<x-app-layout>
    <x-slot name="header">
        <div class="d-flex">
            <h2 class="page-title">
                {{ __('Profile settings') }}
            </h2>
        </div>
    </x-slot>
    @if ($errors->any())
        <div class="alert alert-danger">
            <h4 class="alert-title">{{ __('Profile settings was not updated because there are errors in the form') }}:</h4>
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
                    <form action="{{ route('user.settings.update') }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="row border-bottom pb-2">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label required">{{ __('User Name') }}</label>
                                    <input type="text" name="name" value="{{ $user->name }}" class="form-control"
                                           required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('E-mail') }}</label>
                                    <input type="email" name="email" value="{{ $user->email }}" class="form-control"
                                           readonly>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label required">{{ __('Phone Number') }}</label>
                                    <input type="text" name="phone" value="{{ $user->phone }}" class="form-control"
                                           data-mask="[000000000000000]" data-mask-visible="false" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label required">{{ __('Business Name') }}</label>
                                    <input type="text" name="business[name]" value="{{ $user->business->name }}"
                                           class="form-control" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Identification Number') }}</label>
                                    <input type="text" name="business[code]" value="{{ $user->business->code }}"
                                           class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label required">{{ __('Country') }}</label>
                                    <input type="text" name="country" value="{{ $address->country }}"
                                           class="form-control" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('State') }} / {{ __('Region') }}
                                        / {{ __('Province') }}</label>
                                    <input type="text" name="state" value="{{ $address->state }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label required">{{ __('City') }}</label>
                                    <input type="text" name="city" value="{{ $address->city }}" class="form-control"
                                           required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('ZIP') }} / {{ __('Postal Code') }}</label>
                                    <input type="text" name="zip" value="{{ $address->zip }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label required">{{ __('Address Line 1') }}</label>
                                    <input type="text" name="street1" value="{{ $address->street1 }}"
                                           class="form-control" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Address Line 2') }}</label>
                                    <input type="text" name="street2" value="{{ $address->street2 }}"
                                           class="form-control">
                                </div>
                            </div>
                            <div class="form-footer text-end">
                                <button type="submit" class="btn btn-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="icon icon-tabler icon-tabler-settings" width="24" height="24"
                                         viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                         stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path
                                            d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                    {{ __('Save Settings') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
