<x-guest-layout>
    <div class="border-b border-slate-200 px-8 py-6">
        <p class="text-sm font-semibold uppercase tracking-[0.22em] text-emerald-700">{{ $mode === 'admin' ? 'Admin access' : 'Welcome back' }}</p>
        <h1 class="mt-2 text-3xl font-bold tracking-tight text-slate-950">{{ $mode === 'admin' ? 'Sign in to manage listings.' : 'Sign in to your account.' }}</h1>
        <p class="mt-2 text-sm leading-6 text-slate-600">{{ $mode === 'admin' ? 'Use your staff account to reach the admin dashboard.' : 'Continue saving homes and booking viewings.' }}</p>
    </div>

    <div class="px-8 py-6">
        <div class="mb-6 flex gap-2 rounded-full bg-slate-100 p-1 text-sm font-semibold">
            <a href="{{ route('login') }}" class="rounded-full px-4 py-2 {{ $mode === 'user' ? 'bg-white text-slate-950 shadow-sm' : 'text-slate-600' }}">User login</a>
            <a href="{{ route('buyer.register') }}" class="rounded-full px-4 py-2 text-slate-600 transition hover:text-slate-950">Create account</a>
            <a href="{{ route('admin.login') }}" class="rounded-full px-4 py-2 {{ $mode === 'admin' ? 'bg-white text-slate-950 shadow-sm' : 'text-slate-600' }}">Admin login</a>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="mt-1 block w-full rounded-xl border-slate-300" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="mt-1 block w-full rounded-xl border-slate-300" type="password" name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="flex items-center justify-between">
                <label for="remember_me" class="inline-flex items-center gap-2 text-sm text-slate-600">
                    <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-600" name="remember">
                    <span>{{ __('Remember me') }}</span>
                </label>
                @if (Route::has('password.request'))
                    <a class="text-sm font-semibold text-emerald-700 hover:text-emerald-800" href="{{ route('password.request') }}">Forgot password?</a>
                @endif
            </div>

            <x-primary-button class="w-full justify-center rounded-xl py-3">
                {{ $mode === 'admin' ? __('Admin sign in') : __('Sign in') }}
            </x-primary-button>
        </form>
    </div>
</x-guest-layout>
