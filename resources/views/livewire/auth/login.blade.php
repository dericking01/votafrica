<?php

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->ensureIsNotRateLimited();

        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email).'|'.request()->ip());
    }
}; ?>

<div>
    <div class="text-center mb-6 sm:mb-8">
        <img src="{{ asset('images/votafricalogo-removebg.png') }}" alt="VotAfrica" class="mx-auto mb-5 h-10 sm:mb-6 sm:h-12">
        <h1 class="text-xl font-bold text-white sm:text-2xl">Admin Portal</h1>
        <p class="text-slate-400 text-sm mt-1">Sign in to manage applications</p>
    </div>

    <div style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);border-radius:20px;padding:22px;backdrop-filter:blur(12px);" class="sm:p-8">
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form wire:submit="login" class="space-y-5">
            <flux:input
                wire:model="email"
                label="{{ __('Email address') }}"
                type="email"
                name="email"
                required
                autofocus
                autocomplete="email"
                placeholder="admin@example.com"
            />

            <div>
                <flux:input
                    wire:model="password"
                    label="{{ __('Password') }}"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    placeholder="••••••••"
                />
                @if (Route::has('password.request'))
                    <div class="text-right mt-2">
                        <a href="{{ route('password.request') }}" class="text-xs text-slate-400 hover:text-red-400 transition-colors">
                            {{ __('Forgot your password?') }}
                        </a>
                    </div>
                @endif
            </div>

            <flux:checkbox wire:model="remember" label="{{ __('Remember me') }}" />

            <flux:button type="submit" class="w-full" variant="primary">
                {{ __('Sign in') }}
            </flux:button>
        </form>
    </div>

    <p class="text-center text-xs text-slate-600 mt-6">VotAfrica &copy; {{ date('Y') }} &mdash; Admin Portal</p>
</div>
