<x-app-layout>
    <x-slot name="header">
        <div class="d-flex">
            <h2 class="page-title">
                {{ __('Password change') }}
            </h2>
        </div>
    </x-slot>
    @if ($errors->any())
        <div class="alert alert-danger">
            <h4 class="alert-title">{{ __('Password was not updated because there are errors in the form') }}:</h4>
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
                    <form action="{{ route('user.password.update') }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-lg-6 offset-lg-3">
                                <div class="mb-3">
                                    <label class="form-label required">{{ __('Current Password') }}</label>
                                    <input type="password" name="current_password" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label required">{{ __('New Password') }}</label>
                                    <input type="password" name="new_password" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label required">{{ __('Confirm New Password') }}</label>
                                    <input type="password" name="new_password_confirmation" class="form-control" required>
                                </div>

                                <div class="form-footer text-end">
                                    <button type="submit" class="btn btn-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-key"
                                             width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                             stroke="currentColor"
                                             fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <circle cx="8" cy="15" r="4"></circle>
                                            <line x1="10.85" y1="12.15" x2="19" y2="4"></line>
                                            <line x1="18" y1="5" x2="20" y2="7"></line>
                                            <line x1="15" y1="8" x2="17" y2="10"></line>
                                        </svg>
                                        {{ __('Change Password') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
