<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>EstateFlow</title>
        <meta name="description" content="Browse professional real-estate listings, save searches, and request viewings with EstateFlow.">
        <link rel="canonical" href="{{ route('home') }}">
        <meta property="og:title" content="EstateFlow">
        <meta property="og:description" content="Property management made clear.">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="flex min-h-screen flex-col bg-slate-50 font-sans text-slate-900 antialiased">
        <x-public.header />

        <main class="flex-1">
            <section class="relative overflow-hidden bg-slate-950">
                <img class="absolute inset-0 h-full w-full object-cover opacity-55" src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1800&q=85" alt="Modern home exterior with landscaped entry">
                <div class="absolute inset-0 bg-gradient-to-r from-slate-950 via-slate-950/70 to-slate-950/20"></div>
                <div class="relative mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8 lg:py-28">
                    <div class="max-w-3xl">
                        <p class="text-sm font-semibold uppercase tracking-wide text-emerald-300">EstateFlow</p>
                        <h1 class="mt-4 text-5xl font-bold tracking-tight text-white sm:text-6xl">Find a place that feels right.</h1>
                        <p class="mt-5 max-w-2xl text-lg leading-8 text-slate-200">Elegant homes, thoughtful filters, and a simpler path from browsing to booking.</p>
                    </div>

                    <form method="GET" action="{{ route('properties.index') }}" class="mt-10 max-w-5xl overflow-hidden rounded-[2rem] bg-white/95 shadow-[0_24px_70px_rgba(2,6,23,0.28)] backdrop-blur">
                        <div class="flex flex-wrap items-center gap-1 px-4 pt-4 text-sm font-semibold">
                            <label class="cursor-pointer rounded-full px-4 py-2 text-slate-600 transition has-[:checked]:bg-slate-950 has-[:checked]:text-white hover:text-slate-950">
                                <input class="sr-only" type="radio" name="listing_type" value="" checked>
                                Any
                            </label>
                            <label class="cursor-pointer rounded-full px-4 py-2 text-slate-600 transition has-[:checked]:bg-slate-950 has-[:checked]:text-white hover:text-slate-950">
                                <input class="sr-only" type="radio" name="listing_type" value="For Sale">
                                Buy
                            </label>
                            <label class="cursor-pointer rounded-full px-4 py-2 text-slate-600 transition has-[:checked]:bg-slate-950 has-[:checked]:text-white hover:text-slate-950">
                                <input class="sr-only" type="radio" name="listing_type" value="For Rent">
                                Rent
                            </label>
                        </div>
                        <div class="grid items-center px-5 py-4 lg:grid-cols-[minmax(260px,1fr)_1px_210px_auto] lg:gap-5">
                            <label class="flex min-h-14 items-center gap-3">
                                <svg class="h-5 w-5 shrink-0 text-emerald-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                </svg>
                                <div class="w-full">
                                    <span class="block text-[11px] font-bold uppercase tracking-wide text-slate-500">Location</span>
                                    <input name="search" class="mt-1 w-full border-0 bg-transparent p-0 text-lg font-semibold text-slate-950 placeholder:text-slate-400 focus:ring-0" placeholder="City, neighbourhood, or reference">
                                </div>
                            </label>
                            <div class="my-2 hidden h-12 bg-slate-200 lg:block"></div>
                            <label class="mt-4 flex min-h-14 items-center lg:mt-0">
                                <div class="w-full">
                                    <span class="block text-[11px] font-bold uppercase tracking-wide text-slate-500">Property type</span>
                                    <select name="type" class="mt-1 w-full border-0 bg-transparent p-0 text-lg font-semibold text-slate-950 focus:ring-0">
                                        <option value="">Any home</option>
                                        @foreach (\App\Models\Property::TYPES as $type)
                                            <option>{{ $type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </label>
                            <button class="mt-5 min-h-14 rounded-full bg-emerald-600 px-8 text-sm font-bold text-white shadow-lg shadow-emerald-950/20 transition hover:-translate-y-0.5 hover:bg-emerald-700 lg:mt-0">
                                Explore homes
                            </button>
                        </div>
                    </form>

                    <div class="mt-8 flex flex-wrap gap-3 text-sm">
                        <a href="{{ route('properties.index', ['listing_type' => 'For Sale']) }}" class="rounded-full bg-white/10 px-4 py-2 font-semibold text-white ring-1 ring-white/20 backdrop-blur hover:bg-white/20">For sale</a>
                        <a href="{{ route('properties.index', ['listing_type' => 'For Rent']) }}" class="rounded-full bg-white/10 px-4 py-2 font-semibold text-white ring-1 ring-white/20 backdrop-blur hover:bg-white/20">For rent</a>
                        <a href="{{ route('properties.index', ['open_house' => 1]) }}" class="rounded-full bg-white/10 px-4 py-2 font-semibold text-white ring-1 ring-white/20 backdrop-blur hover:bg-white/20">Open houses</a>
                        <a href="{{ route('properties.index', ['price_reduced' => 1]) }}" class="rounded-full bg-white/10 px-4 py-2 font-semibold text-white ring-1 ring-white/20 backdrop-blur hover:bg-white/20">Price drops</a>
                    </div>
                </div>
            </section>

            <section id="featured" class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
                <div class="mb-8 flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
                    <div>
                        <h2 class="text-2xl font-semibold text-slate-950">Featured listings</h2>
                        <p class="mt-2 text-slate-600">Selected from published inventory.</p>
                    </div>
                    <a class="inline-flex items-center gap-1 text-sm font-semibold text-emerald-700 hover:gap-2" href="{{ route('properties.index', ['featured' => 1]) }}">View featured <span aria-hidden="true">→</span></a>
                </div>
                <div class="grid gap-6 md:grid-cols-3">
                    @foreach ($featuredProperties as $property)
                        <x-ui.property-card :property="$property" />
                    @endforeach
                </div>
            </section>

            <section class="border-y border-slate-200 bg-white">
                <div class="mx-auto grid max-w-7xl gap-8 px-4 py-12 sm:px-6 lg:grid-cols-3 lg:px-8">
                    <div>
                        <h2 class="text-xl font-semibold text-slate-950">Properties by city</h2>
                        <div class="mt-4 space-y-2">
                            @foreach ($propertiesByCity as $city)
                                <a class="flex justify-between rounded-md border border-slate-200 px-3 py-2 text-sm hover:-translate-y-0.5 hover:border-emerald-300 hover:bg-emerald-50/50" href="{{ route('properties.index', ['city' => $city->city]) }}"><span>{{ $city->city }}</span><span>{{ $city->total }}</span></a>
                            @endforeach
                        </div>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-slate-950">Properties by type</h2>
                        <div class="mt-4 space-y-2">
                            @foreach ($propertiesByType as $type)
                                <a class="flex justify-between rounded-md border border-slate-200 px-3 py-2 text-sm hover:-translate-y-0.5 hover:border-emerald-300 hover:bg-emerald-50/50" href="{{ route('properties.index', ['type' => $type->type]) }}"><span>{{ $type->type }}</span><span>{{ $type->total }}</span></a>
                            @endforeach
                        </div>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-slate-950">Agent highlights</h2>
                        <div class="mt-4 space-y-3">
                            @foreach ($agents as $agent)
                                <a href="{{ route('agents.show', $agent) }}" class="block rounded-md border border-slate-200 p-3 hover:-translate-y-0.5 hover:border-emerald-300 hover:bg-emerald-50/50">
                                    <p class="font-semibold text-slate-950">{{ $agent->name }}</p>
                                    <p class="text-sm text-slate-500">{{ $agent->properties_count }} active listings</p>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>

            <section class="mx-auto grid max-w-7xl gap-8 px-4 py-12 sm:px-6 lg:grid-cols-2 lg:px-8">
                <div>
                    <h2 class="text-2xl font-semibold text-slate-950">For sale</h2>
                    <div class="mt-5 grid gap-5">
                        @foreach ($saleProperties as $property)
                            <x-ui.property-card :property="$property" />
                        @endforeach
                    </div>
                </div>
                <div>
                    <h2 class="text-2xl font-semibold text-slate-950">For rent</h2>
                    <div class="mt-5 grid gap-5">
                        @foreach ($rentalProperties as $property)
                            <x-ui.property-card :property="$property" />
                        @endforeach
                    </div>
                </div>
            </section>

            <section class="mx-auto max-w-7xl px-4 pb-14 sm:px-6 lg:px-8">
                <div class="grid gap-8 lg:grid-cols-2">
                    <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
                        <h2 class="text-xl font-semibold text-slate-950">Recently reduced</h2>
                        <div class="mt-4 space-y-3">
                            @forelse ($reducedProperties as $property)
                                <a href="{{ route('properties.show', $property) }}" class="flex justify-between rounded-md bg-slate-50 p-3 text-sm hover:bg-emerald-50"><span>{{ $property->title }}</span><span>${{ number_format($property->price) }}</span></a>
                            @empty
                                <p class="text-sm text-slate-500">No reduced listings at the moment.</p>
                            @endforelse
                        </div>
                    </div>
                    <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
                        <h2 class="text-xl font-semibold text-slate-950">Open houses</h2>
                        <div class="mt-4 space-y-3">
                            @forelse ($openHouseProperties as $property)
                                <a href="{{ route('properties.show', $property) }}" class="block rounded-md bg-slate-50 p-3 text-sm hover:bg-emerald-50"><span class="font-medium">{{ $property->title }}</span><span class="block text-slate-500">{{ $property->open_house_at?->format('M j, g:i A') }}</span></a>
                            @empty
                                <p class="text-sm text-slate-500">No open houses currently scheduled.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </section>

            <section id="contact" class="bg-slate-950 text-white">
                <div class="mx-auto grid max-w-7xl items-center gap-8 px-4 py-14 sm:px-6 lg:grid-cols-[1fr_360px] lg:px-8">
                    <div>
                        <h2 class="text-2xl font-semibold">Keep your search moving</h2>
                        <p class="mt-2 max-w-2xl text-slate-300">Create an account to save homes, keep searches, and manage viewing requests in one place.</p>
                    </div>
                    <a href="{{ route('buyer.register') }}" class="inline-flex items-center justify-center gap-2 rounded-md bg-emerald-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:-translate-y-0.5 hover:bg-emerald-700 hover:shadow-lg">Create account <span aria-hidden="true">→</span></a>
                </div>
            </section>
        </main>

        <x-public.footer />
    </body>
</html>
