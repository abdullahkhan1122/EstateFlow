<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'EstateFlow') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-950 font-sans text-slate-900 antialiased">
        <div class="grid min-h-screen lg:grid-cols-[1.05fr_0.95fr]">
            <div class="relative hidden overflow-hidden bg-slate-950 lg:block">
                <img class="absolute inset-0 h-full w-full object-cover opacity-50" src="https://images.unsplash.com/photo-1518780664697-55e3ad937233?auto=format&fit=crop&w=1600&q=80" alt="Modern property interior">
                <div class="absolute inset-0 bg-gradient-to-br from-slate-950 via-slate-950/65 to-emerald-950/20"></div>
                <div class="relative flex h-full flex-col justify-between p-10 text-white">
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-2.5 text-lg font-bold">
                        <x-application-logo class="h-10 w-10 fill-current text-emerald-400" />
                        EstateFlow
                    </a>
                    <div class="max-w-xl">
                        <p class="text-sm font-semibold uppercase tracking-[0.24em] text-emerald-300">Property discovery</p>
                        <h1 class="mt-4 text-5xl font-bold tracking-tight">A cleaner way to browse homes.</h1>
                        <p class="mt-5 max-w-lg text-base leading-7 text-slate-200">Minimal forms, clear account access, and a consistent flow for buyers and staff.</p>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-center bg-slate-50 px-4 py-8 sm:px-6 lg:px-10">
                <div class="w-full max-w-md">
                    <div class="mb-6 flex items-center justify-between lg:hidden">
                        <a href="{{ route('home') }}" class="flex items-center gap-2 text-lg font-bold text-slate-950">
                            <x-application-logo class="h-9 w-9 fill-current text-emerald-600" />
                            EstateFlow
                        </a>
                    </div>
                    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-[0_20px_60px_rgba(15,23,42,0.08)]">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
