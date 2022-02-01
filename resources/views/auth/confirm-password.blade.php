<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <x-application-logo/>
        </x-slot>
        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-2" :errors="$errors"/>
        <form class="card card-md" method="POST" action="{{ route('password.confirm') }}">
            @csrf
            <div class="card-body">
                <div class="mb-3">
                    <h2 class="card-title">Secure area</h2>
                    <p class="text-muted">{{ __('This is a secure area of the application. Please confirm your password before continuing.') }}</p>
                </div>
                <div class="mb-3">
                    <x-label for="password" :value="__('Password')"/>
                    <x-input id="password" class="block mt-1 w-full"
                             type="password"
                             name="password"
                             required autocomplete="current-password"/>
                </div>
                <div>
                    <x-button class="btn-primary w-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                             stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                             stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <rect x="5" y="11" width="14" height="10" rx="2"/>
                            <circle cx="12" cy="16" r="1"/>
                            <path d="M8 11v-5a4 4 0 0 1 8 0"/>
                        </svg>
                        {{ __('Confirm') }}
                    </x-button>
                </div>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
