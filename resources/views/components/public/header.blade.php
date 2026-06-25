<header class="sticky top-0 z-40 border-b border-slate-200/80 bg-white/95 backdrop-blur">
    <div class="mx-auto flex h-16 max-w-7xl items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">
        <a href="{{ route('home') }}" class="group flex items-center gap-2.5 font-semibold text-slate-950 transition hover:text-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:ring-offset-2">
            <x-application-logo class="h-8 w-8 shrink-0 fill-current text-emerald-600 transition group-hover:text-emerald-700" />
            <span class="text-base font-bold tracking-tight">EstateFlow</span>
        </a>

        <nav class="hidden items-center gap-6 text-sm font-semibold text-slate-600 md:flex">
            <a class="transition hover:text-emerald-700" href="{{ route('properties.index') }}">Properties</a>
            <a class="transition hover:text-emerald-700" href="{{ route('home') }}#featured">Featured</a>
            <a class="transition hover:text-emerald-700" href="{{ route('home') }}#contact">Contact</a>
        </nav>

        <div x-data="{ open: false }" class="relative flex items-center">
            @auth
                <button type="button" @click="open = !open" @keydown.escape.window="open = false" class="inline-flex items-center gap-3 rounded-full border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-800 shadow-sm transition hover:border-emerald-200 hover:text-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:ring-offset-2">
                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-slate-950 text-xs font-bold text-white">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                    <span class="hidden max-w-36 truncate sm:block">{{ auth()->user()->name }}</span>
                    <svg class="h-4 w-4 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.94l3.71-3.71a.75.75 0 1 1 1.06 1.06l-4.24 4.25a.75.75 0 0 1-1.06 0L5.21 8.29a.75.75 0 0 1 .02-1.08Z" clip-rule="evenodd" />
                    </svg>
                </button>
                <div x-cloak x-show="open" @click.outside="open = false" x-transition class="absolute right-0 top-12 w-60 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-lg">
                    <div class="border-b border-slate-100 px-4 py-3">
                        <p class="text-sm font-semibold text-slate-950">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-slate-500">{{ auth()->user()->email }}</p>
                    </div>
                    <a class="block px-4 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-50 hover:text-emerald-700" href="{{ auth()->user()->isBuyer() ? route('buyer.dashboard') : route('dashboard') }}">{{ auth()->user()->isBuyer() ? 'Saved activity' : 'Dashboard' }}</a>
                    <a class="block px-4 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-50 hover:text-emerald-700" href="{{ route('profile.edit') }}">Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full px-4 py-3 text-left text-sm font-medium text-slate-700 transition hover:bg-slate-50 hover:text-emerald-700">Log out</button>
                    </form>
                </div>
            @else
                <button type="button" @click="open = !open" @keydown.escape.window="open = false" class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-slate-950 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:-translate-y-0.5 hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:ring-offset-2">
                    <span>Sign in / Join</span>
                    <svg class="h-4 w-4 text-slate-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.94l3.71-3.71a.75.75 0 1 1 1.06 1.06l-4.24 4.25a.75.75 0 0 1-1.06 0L5.21 8.29a.75.75 0 0 1 .02-1.08Z" clip-rule="evenodd" />
                    </svg>
                </button>
                <div x-cloak x-show="open" @click.outside="open = false" x-transition class="absolute right-0 top-12 w-60 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-lg">
                    <a class="block px-4 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-50 hover:text-emerald-700" href="{{ route('login', ['redirect' => url()->current()]) }}">User login</a>
                    <a class="block px-4 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-50 hover:text-emerald-700" href="{{ route('buyer.register') }}">Create account</a>
                    <a class="block px-4 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-50 hover:text-emerald-700" href="{{ route('admin.login') }}">Admin login</a>
                </div>
            @endauth
        </div>
    </div>
</header>
