<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $agent->name }} | EstateFlow</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="flex min-h-screen flex-col bg-slate-50 font-sans text-slate-900">
        <x-public.header />
        <main class="flex-1 mx-auto w-full max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-1 text-sm font-semibold text-emerald-700 hover:gap-2"><span aria-hidden="true">←</span> Back home</a>
            <section class="mt-6 grid gap-8 rounded-lg border border-slate-200 bg-white p-6 shadow-sm lg:grid-cols-[260px_1fr]">
                <img class="h-64 w-full rounded-lg object-cover" src="{{ $agent->photo_url ?? 'https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=600&q=80' }}" alt="{{ $agent->name }}">
                <div>
                    <h1 class="text-3xl font-semibold text-slate-950">{{ $agent->name }}</h1>
                    <p class="mt-2 text-slate-600">{{ $agent->bio }}</p>
                    <dl class="mt-6 grid gap-4 text-sm sm:grid-cols-2">
                        <div><dt class="font-semibold text-slate-950">Phone</dt><dd class="text-slate-600">{{ $agent->phone }}</dd></div>
                        <div><dt class="font-semibold text-slate-950">Email</dt><dd class="text-slate-600">{{ $agent->email }}</dd></div>
                        <div><dt class="font-semibold text-slate-950">Languages</dt><dd class="text-slate-600">{{ implode(', ', $agent->languages ?? []) }}</dd></div>
                        <div><dt class="font-semibold text-slate-950">Service areas</dt><dd class="text-slate-600">{{ implode(', ', $agent->service_areas ?? []) }}</dd></div>
                        <div><dt class="font-semibold text-slate-950">Specialities</dt><dd class="text-slate-600">{{ implode(', ', $agent->specialities ?? []) }}</dd></div>
                        <div><dt class="font-semibold text-slate-950">Office</dt><dd class="text-slate-600">{{ $agent->office_name }}</dd></div>
                    </dl>
                </div>
            </section>
            <section class="mt-8">
                <h2 class="text-2xl font-semibold text-slate-950">Active listings</h2>
                <div class="mt-5 grid gap-6 md:grid-cols-3">
                    @foreach ($agent->properties as $property)
                        <x-ui.property-card :property="$property" />
                    @endforeach
                </div>
            </section>
        </main>
        <x-public.footer />
    </body>
</html>
