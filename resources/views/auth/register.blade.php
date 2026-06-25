<x-guest-layout>
    <div class="border-b border-slate-200 px-8 py-6">
        <p class="text-sm font-semibold uppercase tracking-[0.22em] text-emerald-700">Create account</p>
        <h1 class="mt-2 text-3xl font-bold tracking-tight text-slate-950">Start saving homes faster.</h1>
        <p class="mt-2 text-sm leading-6 text-slate-600">One account for saved homes, searches, and viewing requests.</p>
    </div>

    <div class="px-8 py-6">
        <div class="mb-6 flex gap-2 rounded-full bg-slate-100 p-1 text-sm font-semibold">
            <a href="{{ route('login') }}" class="rounded-full px-4 py-2 text-slate-600 transition hover:text-slate-950">User login</a>
            <a href="{{ route('buyer.register') }}" class="rounded-full px-4 py-2 bg-white text-slate-950 shadow-sm">Create account</a>
            <a href="{{ route('admin.login') }}" class="rounded-full px-4 py-2 text-slate-600 transition hover:text-slate-950">Admin login</a>
        </div>

        <form method="POST" action="{{ route('buyer.register.store') }}" class="space-y-5">
            @csrf
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="mt-1 block w-full rounded-xl border-slate-300" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="mt-1 block w-full rounded-xl border-slate-300" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="mt-1 block w-full rounded-xl border-slate-300" type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="password_confirmation" class="mt-1 block w-full rounded-xl border-slate-300" type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-between">
                <a class="text-sm font-semibold text-emerald-700 hover:text-emerald-800" href="{{ route('login') }}">Already have an account?</a>
                <x-primary-button class="rounded-xl px-5 py-3">
                    {{ __('Create account') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
