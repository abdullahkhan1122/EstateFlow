@props(['variant' => 'primary'])

@php
    $classes = [
        'primary' => 'bg-emerald-600 text-white hover:bg-emerald-700 focus:ring-emerald-600',
        'secondary' => 'border border-slate-300 bg-white text-slate-700 hover:bg-slate-50 focus:ring-emerald-600',
        'danger' => 'bg-red-600 text-white hover:bg-red-700 focus:ring-red-600',
    ][$variant];
@endphp

<button {{ $attributes->merge(['class' => "inline-flex items-center justify-center rounded-md px-4 py-2 text-sm font-semibold transition focus:outline-none focus:ring-2 focus:ring-offset-2 {$classes}"]) }}>
    {{ $slot }}
</button>
