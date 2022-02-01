<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <x-application-logo/>
        </x-slot>
        <div class="alert alert-info">
            <div
                class="text-muted">{{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}</div>
        </div>
        @if (session('status') == 'verification-link-sent')
            <div class="alert alert-success" role="alert">
                <div
                    class="text-muted">{{ __('A new verification link has been sent to the email address you provided during registration.') }}</div>
            </div>
        @endif
        <div class="card card-md">
            <div class="card-body">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <x-button class="btn-primary w-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                             viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <rect x="3" y="5" width="18" height="14" rx="2"/>
                            <polyline points="3 7 12 13 21 7"/>
                        </svg>
                        {{ __('Resend Verification Email') }}
                    </x-button>
                </form>

                <form class="mt-2" method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-button class="btn-secondary">
                        {{ __('Log Out') }}
                    </x-button>
                </form>
            </div>
        </div>
    </x-auth-card>
</x-guest-layout>
