@props(['property'])

<article class="group overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:border-emerald-200 hover:shadow-lg">
    <a href="{{ route('properties.show', $property) }}" class="block overflow-hidden focus:outline-none focus:ring-2 focus:ring-emerald-600">
        <img loading="lazy" class="h-56 w-full object-cover transition duration-300 group-hover:scale-[1.03]" src="{{ $property->primaryImage?->path ?? 'https://images.unsplash.com/photo-1560184897-ae75f418493e?auto=format&fit=crop&w=1200&q=80' }}" alt="{{ $property->title }}">
    </a>
    <div class="space-y-4 p-5">
        <div>
            <div class="mb-2 flex items-center justify-between gap-3 text-sm">
                <span class="font-semibold text-emerald-700">{{ $property->listing_type }}</span>
                <span class="text-slate-500">{{ $property->type }}</span>
            </div>
            <h3 class="text-lg font-semibold text-slate-950">
                <a class="transition hover:text-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-600" href="{{ route('properties.show', $property) }}">{{ $property->title }}</a>
            </h3>
            <p class="mt-1 text-sm text-slate-500">{{ $property->city }}, {{ $property->state }}</p>
        </div>
        <div class="flex items-center justify-between gap-3 border-t border-slate-200 pt-4">
            <p class="font-semibold text-slate-950">${{ number_format($property->price) }}</p>
            <p class="text-sm text-slate-500">{{ $property->bedrooms }} bd · {{ $property->bathrooms }} ba · {{ number_format($property->area_sqft) }} sqft</p>
        </div>
        @if (auth()->user()?->isBuyer())
            <form method="POST" action="{{ route('properties.favorite.toggle', $property) }}">
                @csrf
                <button type="submit" class="w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm font-semibold text-slate-700 transition hover:border-emerald-300 hover:bg-emerald-50 hover:text-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:ring-offset-2">
                    Save to shortlist
                </button>
            </form>
        @elseif (auth()->check())
            <a href="{{ route('admin.properties.edit', $property) }}" class="block w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-center text-sm font-semibold text-slate-700 transition hover:border-emerald-300 hover:bg-emerald-50 hover:text-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:ring-offset-2">
                Manage listing
            </a>
        @else
            <a href="{{ route('login', ['redirect' => route('properties.show', $property)]) }}" class="block w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-center text-sm font-semibold text-slate-700 transition hover:border-emerald-300 hover:bg-emerald-50 hover:text-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:ring-offset-2">
                Sign in to save
            </a>
        @endif
    </div>
</article>
