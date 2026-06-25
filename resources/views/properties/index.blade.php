<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Properties | EstateFlow</title>
        <meta name="robots" content="index,follow">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="flex min-h-screen flex-col bg-slate-50 font-sans text-slate-900 antialiased">
        <x-public.header />

        <main x-data="{ mobileFilters: false, view: '{{ $viewMode }}' }" class="flex-1 mx-auto w-full max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            <section class="mb-8 overflow-hidden rounded-3xl bg-slate-950 shadow-xl">
                <div class="grid lg:grid-cols-[1fr_360px]">
                    <div class="p-6 sm:p-8">
                        <p class="text-sm font-semibold uppercase tracking-wide text-emerald-300">Property search</p>
                        <h1 class="mt-2 text-3xl font-bold tracking-tight text-white">Explore homes with less noise.</h1>
                        <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-300">Choose a location, tune the details, and keep moving.</p>
                        <form method="GET" class="mt-6 overflow-hidden rounded-[1.5rem] bg-white/95 shadow-2xl backdrop-blur">
                            <input type="hidden" name="view" value="{{ request('view', 'grid') }}">
                            <div class="flex flex-wrap items-center gap-1 px-4 pt-4 text-sm font-semibold">
                                @foreach ([null => 'Any', 'For Sale' => 'Buy', 'For Rent' => 'Rent'] as $value => $label)
                                    <label class="cursor-pointer rounded-full px-4 py-2 text-slate-600 transition has-[:checked]:bg-slate-950 has-[:checked]:text-white hover:text-slate-950">
                                        <input class="sr-only" type="radio" name="listing_type" value="{{ $value }}" @checked(request('listing_type') === $value || ($value === null && ! request('listing_type')))>
                                        {{ $label }}
                                    </label>
                                @endforeach
                            </div>
                            <div class="grid items-center px-5 py-4 xl:grid-cols-[minmax(240px,1fr)_1px_185px_auto] xl:gap-5">
                                <label class="flex min-h-12 items-center gap-3">
                                    <svg class="h-5 w-5 shrink-0 text-emerald-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                    </svg>
                                    <input name="search" value="{{ request('search') }}" class="w-full border-0 bg-transparent p-0 text-base font-semibold text-slate-950 placeholder:text-slate-400 focus:ring-0" placeholder="City, area, reference">
                                </label>
                                <div class="my-2 hidden h-10 bg-slate-200 xl:block"></div>
                                <label class="mt-4 block xl:mt-0">
                                    <span class="block text-[11px] font-bold uppercase tracking-wide text-slate-500">Type</span>
                                    <select name="type" class="mt-1 w-full border-0 bg-transparent p-0 text-base font-semibold text-slate-950 focus:ring-0">
                                        <option value="">Any home</option>
                                        @foreach ($types as $type)
                                            <option value="{{ $type }}" @selected(request('type') === $type)>{{ $type }}</option>
                                        @endforeach
                                    </select>
                                </label>
                                <button class="mt-5 min-h-12 rounded-full bg-emerald-600 px-7 text-sm font-bold text-white shadow-lg shadow-emerald-950/20 transition hover:-translate-y-0.5 hover:bg-emerald-700 xl:mt-0">Search</button>
                            </div>
                        </form>
                        <div class="mt-4 flex flex-wrap gap-2">
                            <a href="{{ route('properties.index', ['featured' => 1]) }}" class="rounded-full bg-white/10 px-3 py-1.5 text-sm font-semibold text-white ring-1 ring-white/15 hover:bg-white/20">Featured</a>
                            <a href="{{ route('properties.index', ['open_house' => 1]) }}" class="rounded-full bg-white/10 px-3 py-1.5 text-sm font-semibold text-white ring-1 ring-white/15 hover:bg-white/20">Open house</a>
                            <a href="{{ route('properties.index', ['price_reduced' => 1]) }}" class="rounded-full bg-white/10 px-3 py-1.5 text-sm font-semibold text-white ring-1 ring-white/15 hover:bg-white/20">Price drops</a>
                        </div>
                    </div>
                    <div class="hidden bg-[url('https://images.unsplash.com/photo-1600566753190-17f0baa2a6c3?auto=format&fit=crop&w=900&q=80')] bg-cover bg-center lg:block"></div>
                </div>
            </section>

            <div class="mb-6 flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
                <div>
                    <h1 class="text-3xl font-semibold text-slate-950">Homes to explore</h1>
                    <p class="mt-2 text-slate-600">{{ $resultCount }} {{ Str::plural('listing', $resultCount) }} available.</p>
                </div>
                <div class="flex flex-wrap gap-2">
                    <button type="button" @click="mobileFilters = true" class="rounded-full border border-slate-300 bg-white px-4 py-2 text-sm font-semibold lg:hidden">Filters</button>
                    <a href="{{ request()->fullUrlWithQuery(['view' => 'grid']) }}" class="rounded-full border border-slate-300 px-4 py-2 text-sm font-semibold hover:border-emerald-300 hover:text-emerald-700">Grid</a>
                    <a href="{{ request()->fullUrlWithQuery(['view' => 'list']) }}" class="rounded-full border border-slate-300 px-4 py-2 text-sm font-semibold hover:border-emerald-300 hover:text-emerald-700">List</a>
                    <a href="{{ request()->fullUrlWithQuery(['view' => 'map']) }}" class="rounded-full border border-slate-300 px-4 py-2 text-sm font-semibold hover:border-emerald-300 hover:text-emerald-700">Area view</a>
                </div>
            </div>

            @if ($activeFilters->isNotEmpty())
                <div class="mb-5 flex flex-wrap items-center gap-2">
                    @foreach ($activeFilters as $key => $value)
                        <span class="rounded-full bg-emerald-50 px-3 py-1 text-sm font-medium text-emerald-800">{{ Str::headline($key) }}: {{ is_array($value) ? implode(', ', $value) : $value }}</span>
                    @endforeach
                    <a href="{{ route('properties.index') }}" class="text-sm font-semibold text-slate-600">Clear all</a>
                </div>
            @endif

            <div class="grid gap-8 lg:grid-cols-[320px_1fr]">
                <aside class="hidden lg:block">
                    @include('properties.partials.filters')
                </aside>

                <section>
                    <div class="mb-5 flex flex-col justify-between gap-3 rounded-xl border border-slate-200 bg-white p-4 shadow-sm sm:flex-row sm:items-center">
                        <p class="text-sm text-slate-600">{{ $resultCount }} curated {{ Str::plural('match', $resultCount) }}</p>
                        @if (auth()->user()?->isBuyer())
                            <form method="POST" action="{{ route('saved-searches.store') }}" class="flex gap-2">
                                @csrf
                                @foreach (request()->except(['page']) as $key => $value)
                                    @if (is_array($value))
                                        @foreach ($value as $item)
                                            <input type="hidden" name="{{ $key }}[]" value="{{ $item }}">
                                        @endforeach
                                    @else
                                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                    @endif
                                @endforeach
                                <input type="hidden" name="name" value="Saved search {{ now()->format('M j') }}">
                                <button class="rounded-md bg-emerald-600 px-3 py-2 text-sm font-semibold text-white">Save search</button>
                            </form>
                        @elseif (auth()->check())
                            <a href="{{ route('admin.properties.index') }}" class="text-sm font-semibold text-emerald-700">Manage inventory</a>
                        @else
                            <a href="{{ route('login', ['redirect' => url()->current()]) }}" class="text-sm font-semibold text-emerald-700">Sign in to save this search</a>
                        @endif
                    </div>

                    @if ($viewMode === 'map')
                        <div class="mb-6 rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                            <h2 class="font-semibold text-slate-950">Explore by area</h2>
                            <p class="mt-2 text-sm text-slate-600">Browse listings grouped by their neighbourhoods.</p>
                            <div class="mt-4 grid gap-3 md:grid-cols-2">
                                @foreach ($properties as $property)
                                    <a href="{{ route('properties.show', $property) }}" class="rounded-xl bg-slate-50 p-4 text-sm hover:bg-emerald-50">
                                        <span class="font-semibold">{{ $property->title }}</span>
                                        <span class="block text-slate-500">{{ $property->neighbourhood }}, {{ $property->city }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="{{ $viewMode === 'list' ? 'space-y-5' : 'grid gap-6 md:grid-cols-2 xl:grid-cols-3' }}">
                        @forelse ($properties as $property)
                            @if ($viewMode === 'list')
                                <article class="grid gap-4 rounded-lg border border-slate-200 bg-white p-4 shadow-sm hover:-translate-y-0.5 hover:border-emerald-200 hover:shadow-md sm:grid-cols-[220px_1fr]">
                                    <img class="h-44 w-full rounded-md object-cover" src="{{ $property->primaryImage?->path }}" alt="{{ $property->title }}">
                                    <div>
                                        <p class="text-sm font-semibold text-emerald-700">{{ $property->reference_number }} · {{ $property->listing_type }}</p>
                                        <h2 class="mt-1 text-xl font-semibold"><a href="{{ route('properties.show', $property) }}">{{ $property->title }}</a></h2>
                                        <p class="mt-1 text-slate-500">{{ $property->neighbourhood }}, {{ $property->city }}</p>
                                        <p class="mt-3 font-semibold">${{ number_format($property->price) }} · {{ $property->bedrooms }} bd · {{ $property->bathrooms }} ba · {{ number_format($property->area_sqft) }} sqft</p>
                                    </div>
                                </article>
                            @else
                                <x-ui.property-card :property="$property" />
                            @endif
                        @empty
                            <div class="rounded-lg border border-slate-200 bg-white p-8 text-slate-600">No properties match the current filters. Clear filters or broaden your search criteria.</div>
                        @endforelse
                    </div>
                    <div class="mt-8">{{ $properties->links() }}</div>
                </section>
            </div>

            <div x-show="mobileFilters" x-cloak class="fixed inset-0 z-50 bg-slate-950/50 lg:hidden">
                <div class="ml-auto h-full w-full max-w-sm overflow-y-auto bg-white p-5">
                    <div class="mb-4 flex items-center justify-between">
                        <h2 class="font-semibold">Filters</h2>
                        <button @click="mobileFilters = false" class="rounded-md border px-3 py-1 text-sm">Close</button>
                    </div>
                    @include('properties.partials.filters')
                </div>
            </div>

        </main>

        <x-public.footer />
    </body>
</html>
