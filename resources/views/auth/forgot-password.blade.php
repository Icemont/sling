<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <x-application-logo />
        </x-slot>
        <!-- Session Status -->
        <x-auth-session-status class="mb-2" :status="session('status')" />
        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-2" :errors="$errors" />
        <form class="card card-md" method="POST" action="{{ route('password.email') }}">
            <div class="card-body">
            @csrf
                <p class="text-muted mb-4">{{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}</p>
                <div class="mb-3">
                    <x-label for="email" :value="__('Email')" />
                    <x-input id="email" type="email" name="email" :value="old('email')" required autofocus />
                </div>
                <div class="form-footer">
                    <x-button class="btn-primary w-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="3" y="5" width="18" height="14" rx="2" /><polyline points="3 7 12 13 21 7" /></svg>
                        {{ __('Email Password Reset Link') }}
                    </x-button>
                </div>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
