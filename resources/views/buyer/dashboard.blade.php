<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Saved Activity | EstateFlow</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="flex min-h-screen flex-col bg-slate-50 font-sans text-slate-900 antialiased">
        <x-public.header />

        <main class="flex-1">
            <section class="border-b border-slate-200 bg-white">
                <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
                    <p class="text-sm font-semibold uppercase tracking-wide text-emerald-700">Your account</p>
                    <h1 class="mt-2 text-3xl font-semibold tracking-tight text-slate-950">Saved activity</h1>
                    <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-600">Saved homes, searches, viewing requests, and recently viewed listings.</p>
                </div>
            </section>

            <div class="mx-auto grid max-w-7xl gap-6 px-4 py-8 sm:px-6 lg:grid-cols-2 lg:px-8">
                <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <h2 class="font-semibold text-slate-950">Saved properties</h2>
                    <div class="mt-4 space-y-3">
                        @forelse ($favorites as $favorite)
                            <a href="{{ route('properties.show', $favorite->property) }}" class="block rounded-xl bg-slate-50 p-3 text-sm font-medium transition hover:bg-emerald-50 hover:text-emerald-700">{{ $favorite->property->title }}</a>
                        @empty
                            <p class="text-sm text-slate-500">No saved properties yet.</p>
                        @endforelse
                    </div>
                </section>

                <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <h2 class="font-semibold text-slate-950">Saved searches</h2>
                    <div class="mt-4 space-y-3">
                        @forelse ($savedSearches as $search)
                            <a href="{{ route('properties.index', $search->filters) }}" class="block rounded-xl bg-slate-50 p-3 text-sm font-medium transition hover:bg-emerald-50 hover:text-emerald-700">{{ $search->name }}<span class="block text-slate-500">{{ count($search->filters) }} filters</span></a>
                        @empty
                            <p class="text-sm text-slate-500">No saved searches yet.</p>
                        @endforelse
                    </div>
                </section>

                <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <h2 class="font-semibold text-slate-950">Viewing requests</h2>
                    <div class="mt-4 space-y-3">
                        @forelse ($viewingRequests as $viewing)
                            <div class="rounded-xl bg-slate-50 p-3 text-sm">
                                <p class="font-medium">{{ $viewing->property->title }}</p>
                                <p class="text-slate-500">{{ $viewing->preferred_date->format('M j, Y') }} · {{ substr($viewing->preferred_time, 0, 5) }} · {{ ucfirst($viewing->status) }}</p>
                            </div>
                        @empty
                            <p class="text-sm text-slate-500">No viewing requests yet.</p>
                        @endforelse
                    </div>
                </section>

                <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <h2 class="font-semibold text-slate-950">Recently viewed</h2>
                    <div class="mt-4 space-y-3">
                        @forelse ($recentViews as $view)
                            <a href="{{ route('properties.show', $view->property) }}" class="block rounded-xl bg-slate-50 p-3 text-sm font-medium transition hover:bg-emerald-50 hover:text-emerald-700">{{ $view->property->title }}</a>
                        @empty
                            <p class="text-sm text-slate-500">No recent views yet.</p>
                        @endforelse
                    </div>
                </section>
            </div>
        </main>

        <x-public.footer />
    </body>
</html>
