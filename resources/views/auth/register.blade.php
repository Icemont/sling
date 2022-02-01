<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <x-application-logo/>
        </x-slot>
        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-2" :errors="$errors"/>
        <form class="card card-md" method="POST" action="{{ route('register') }}">
            <div class="card-body">
                @csrf
                <h2 class="card-title text-center mb-4">{{ __('Create new account') }}</h2>
                <div class="mb-3">
                    <x-label for="name" :value="__('Name')"/>
                    <x-input id="name" type="text" name="name" :value="old('name')" required autofocus/>
                </div>
                <div class="mb-3">
                    <x-label for="email" :value="__('Email')"/>
                    <x-input id="email" type="email" name="email" :value="old('email')" required/>
                </div>
                <div class="mb-3">
                    <x-label for="currency" :value="__('Currency')"/>
                    <select id="currency" class="form-select" name="currency">
                        @foreach($currencies as $currency)
                            <option value="{{ $currency->id }}"{!!  $currency->code == config('app.default_currency')
                                ? ' selected="selected"' : '' !!}>{{ $currency->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <x-label for="password" :value="__('Password')"/>
                    <x-input id="password"
                             type="password"
                             name="password"
                             required autocomplete="new-password"/>
                </div>
                <div class="mb-3">
                    <x-label for="password_confirmation" :value="__('Confirm Password')"/>
                    <x-input id="password_confirmation"
                             type="password"
                             name="password_confirmation" required/>
                </div>
                <div class="form-footer">
                    <x-button class="btn-primary w-100">
                        {{ __('Register') }}
                    </x-button>
                </div>
            </div>
        </form>
        <div class="text-center text-muted mt-3">
            <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>
        </div>
    </x-auth-card>
</x-guest-layout>
