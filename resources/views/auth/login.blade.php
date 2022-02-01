<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <x-application-logo />
        </x-slot>
        <!-- Session Status -->
        <x-auth-session-status class="mb-2" :status="session('status')"/>
        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-2" :errors="$errors"/>
            <form class="card card-md" method="POST" action="{{ route('login') }}">
                <div class="card-body">
            @csrf
                <div class="mb-3">
                    <x-label for="email" :value="__('Email')"/>
                    <x-input id="email" type="email" name="email" :value="old('email')" required
                             autofocus/>
                </div>
                <div class="mb-2">
                    <x-label for="password">
                        {{ __('Password') }}
                        @if (Route::has('password.request'))
                            <span class="form-label-description">
                                <a href="{{ route('password.request') }}">{{ __('Forgot your password?') }}</a>
                        </span>
                        @endif
                    </x-label>
                    <x-input id="password" class="input-group input-group-flat"
                             type="password"
                             name="password"
                             required autocomplete="current-password"/>
                </div>
                <div class="mb-2">
                    <label for="remember_me" class="form-check">
                        <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                        <span class="form-check-label">{{ __('Remember me') }}</span>
                    </label>
                </div>
                <div class="form-footer">
                    <x-button class="btn-primary w-100">
                        {{ __('Log in') }}
                    </x-button>
                </div>
            </div>
        </form>
        @if (Route::has('register'))
            <div class="text-center text-muted mt-3">
                {{ __("Don't have account yet?") }} <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">{{ __('Register') }}</a>
            </div>
        @endif
    </x-auth-card>
</x-guest-layout>
