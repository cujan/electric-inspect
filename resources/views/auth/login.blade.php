<x-layouts.auth :title="__('Log in')">
<div class="space-y-6">
    <!-- Header -->
    <div>
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Welcome back</h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Please sign in to your account</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <x-form method="post" :action="route('login')" class="space-y-5">
        <div>
            <x-input
                type="email"
                :label="__('Email address')"
                name="email"
                required
                autofocus
                autocomplete="email"
                placeholder="you@example.com"
            />
        </div>

        <div>
            <div class="flex items-center justify-between mb-1">
                <x-label for="password" value="{{ __('Password') }}" />
                @if (Route::has('password.request'))
                    <x-link class="text-sm" :href="route('password.request')">
                        {{ __('Forgot password?') }}
                    </x-link>
                @endif
            </div>
            <x-input
                type="password"
                name="password"
                required
                autocomplete="current-password"
                placeholder="Enter your password"
            />
        </div>

        <div>
            <x-checkbox name="remember" :label="__('Remember me for 30 days')" />
        </div>

        <div>
            <x-button class="w-full justify-center">
                {{ __('Sign in') }}
            </x-button>
        </div>
    </x-form>
</div>
</x-layouts.auth>
