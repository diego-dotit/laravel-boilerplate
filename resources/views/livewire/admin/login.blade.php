<?php

use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Features;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;
use App\UserRoles\AdminRole;

new
#[Layout('components.layouts.auth', ['title' => 'admin.login.title'])]
class extends Component {
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
        try {
            $this->validate();
            $this->ensureIsNotRateLimited();
            $this->validateAdminRole();
            $user = $this->validateCredentials();
        } catch (ValidationException $e) {
            $this->dispatch('alert', __('auth.error'), $e->getMessage(), 'destructive', 'shield-exclamation');

            return;
        }

        // if (Features::canManageTwoFactorAuthentication() && $user->hasEnabledTwoFactorAuthentication()) {
        //     Session::put([
        //         'login.id' => $user->getKey(),
        //         'login.remember' => $this->remember,
        //     ]);

        //     $this->redirect(route('two-factor.login'), navigate: true);

        //     return;
        // }

        Auth::login($user, $this->remember);

        RateLimiter::clear($this->throttleKey());
        Session::regenerate();

        $this->redirectIntended(default: route('admin.dashboard', absolute: false), navigate: true);
    }

    /**
     * Validate the user's credentials.
     */
    protected function validateCredentials(): User
    {
        $user = Auth::getProvider()->retrieveByCredentials(['email' => $this->email, 'password' => $this->password]);

        if (! $user || ! Auth::getProvider()->validateCredentials($user, ['password' => $this->password])) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        return $user;
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

    protected function validateAdminRole(): void
    {
        $user = Auth::getProvider()->retrieveByCredentials(['email' => $this->email, 'password' => $this->password]);

        if(!$user) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        if(!($user->role() instanceof AdminRole)) {
            throw ValidationException::withMessages([
                'email' => __('auth.no_access'),
            ]);
        }
    }
}; ?>

<div class="flex items-center justify-center">
    <x-form method="POST" wire:submit="login" class="max-w-full space-y-4 w-96">
        @csrf

        <x-form.input
            type="email"
            :label="__('field.email.label')"
            :placeholder="__('field.email.placeholder')"
            wire:model="email"
            required
            autofocus
            autocomplete="email"
        />

        <x-form.input
            type="password"
            :label="__('field.password.label')"
            :placeholder="__('field.password.placeholder')"
            wire:model="password"
            required
            autocomplete="current-password"
        />

        <div class="flex items-center space-x-2">
            <x-checkbox
                id="remember"
                wire:model="remember"
            />
            <x-label
                htmlFor="remember"
                class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
            >
                {{ __('field.remember.label') }}
            </x-label>
        </div>

        <div class="flex justify-center">
            <x-button type="submit" data-test="login-button">{{ __('button.log_in') }}</x-button>
        </div>
    </x-form>
</div>
