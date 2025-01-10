<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    
    <div class="text-center">
        <h4 class="text-uppercase">Project Management System</h4>
        <p class="text-muted">{{ __('Please login in to your account') }}</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-3">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" placeholder="john@example.com" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger" />
        </div>

        <!-- Password -->
        <div class="mb-3">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="form-control" type="password" name="password" placeholder="••••••••" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger" />
        </div>

        <!-- Remember Me -->
        {{-- <div class="mb-3 form-check">
            <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
            <label for="remember_me" class="form-check-label text-muted">{{ __('Remember me') }}</label>
        </div> --}}

        <div class="d-flex justify-content-between align-items-center mb-3">
            <x-primary-button class="w-100 btn btn-primary">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
        
        @if (Route::has('password.request'))
            <div class="text-center">
                <a class="text-muted text-decoration-none" href="{{ route('password.request') }}">
                    <small>{{ __('Forgot your password?') }}</small>
                </a>            
            </div>
        @endif
    </form>
</x-guest-layout>
