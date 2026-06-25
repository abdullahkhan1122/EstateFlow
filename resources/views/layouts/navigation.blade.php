<nav x-data="{ open: false }" class="border-b border-slate-200 bg-white/95 backdrop-blur">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 justify-between">
            <div class="flex">
                <a href="{{ Auth::user()->isBuyer() ? route('buyer.dashboard') : route('dashboard') }}" class="flex items-center gap-2 font-semibold text-slate-950">
                    <x-application-logo class="h-8 w-8 fill-current text-emerald-600" />
                    EstateFlow
                </a>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @if (Auth::user()->isBuyer())
                        <x-nav-link :href="route('home')" :active="request()->routeIs('home')">Home</x-nav-link>
                        <x-nav-link :href="route('properties.index')" :active="request()->routeIs('properties.*')">Properties</x-nav-link>
                        <x-nav-link :href="route('buyer.dashboard')" :active="request()->routeIs('buyer.dashboard')">Saved</x-nav-link>
                    @else
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">Dashboard</x-nav-link>
                        <x-nav-link :href="route('admin.properties.index')" :active="request()->routeIs('admin.properties.*')">Properties</x-nav-link>
                        <x-nav-link :href="route('admin.leads.index')" :active="request()->routeIs('admin.leads.*')">Leads</x-nav-link>
                        @if (Auth::user()->isAdmin())
                            <x-nav-link :href="route('admin.agents.index')" :active="request()->routeIs('admin.agents.*')">Agents</x-nav-link>
                        @endif
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-3 rounded-full border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-800 shadow-sm transition hover:border-emerald-200 hover:text-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:ring-offset-2">
                            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-slate-950 text-xs font-bold text-white">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                            <span class="max-w-36 truncate">{{ Auth::user()->name }}</span>
                            <svg class="h-4 w-4 fill-current text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="border-b border-slate-100 px-4 py-3">
                            <p class="truncate text-sm font-semibold text-slate-950">{{ Auth::user()->name }}</p>
                            <p class="truncate text-xs text-slate-500">{{ Auth::user()->email }}</p>
                        </div>
                        <x-dropdown-link :href="route('profile.edit')">Profile</x-dropdown-link>
                        @if (! Auth::user()->isBuyer())
                            <x-dropdown-link :href="route('home')">View public site</x-dropdown-link>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">Log Out</x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center rounded-md p-2 text-slate-500 transition hover:bg-slate-100 hover:text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-600" aria-label="Toggle navigation">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="space-y-1 pb-3 pt-2">
            @if (Auth::user()->isBuyer())
                <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">Home</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('properties.index')" :active="request()->routeIs('properties.*')">Properties</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('buyer.dashboard')" :active="request()->routeIs('buyer.dashboard')">Saved</x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">Dashboard</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.properties.index')" :active="request()->routeIs('admin.properties.*')">Properties</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.leads.index')" :active="request()->routeIs('admin.leads.*')">Leads</x-responsive-nav-link>
                @if (Auth::user()->isAdmin())
                    <x-responsive-nav-link :href="route('admin.agents.index')" :active="request()->routeIs('admin.agents.*')">Agents</x-responsive-nav-link>
                @endif
            @endif
        </div>

        <div class="border-t border-slate-200 pb-1 pt-4">
            <div class="px-4">
                <div class="text-base font-medium text-slate-800">{{ Auth::user()->name }}</div>
                <div class="text-sm font-medium text-slate-500">{{ Auth::user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">Profile</x-responsive-nav-link>
                @if (! Auth::user()->isBuyer())
                    <x-responsive-nav-link :href="route('home')">View public site</x-responsive-nav-link>
                @endif
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">Log Out</x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
