<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <x-application-logo/>
        </x-slot>
        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-2" :errors="$errors"/>
        <form class="card card-md" method="POST" action="{{ route('password.update') }}">
            <div class="card-body">
            @csrf
            <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">
                <!-- Email Address -->
                <div class="mb-3">
                    <x-label for="email" :value="__('Email')"/>
                    <x-input id="email" type="email" name="email" :value="old('email', $request->email)" required
                             autofocus/>
                </div>
                <!-- Password -->
                <div class="mb-3">
                    <x-label for="password" :value="__('Password')"/>
                    <x-input id="password" class="block mt-1 w-full" type="password" name="password" required/>
                </div>
                <!-- Confirm Password -->
                <div class="mb-3">
                    <x-label for="password_confirmation" :value="__('Confirm Password')"/>
                    <x-input id="password_confirmation" class="block mt-1 w-full"
                             type="password"
                             name="password_confirmation" required/>
                </div>
                <div class="form-footer">
                    <x-button class="btn-primary w-100">
                        {{ __('Reset Password') }}
                    </x-button>
                </div>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
