<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $property->title }} | EstateFlow</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="flex min-h-screen flex-col bg-slate-50 font-sans text-slate-900 antialiased">
        <x-public.header />
        <main
            x-data="{
                selectedImage: '{{ $property->images->first()?->path ?? 'https://images.unsplash.com/photo-1560184897-ae75f418493e?auto=format&fit=crop&w=1200&q=80' }}',
                price: {{ (float) $property->price }},
                downPayment: {{ $property->listing_type === 'For Sale' ? max(1, round((float) $property->price * 0.2)) : 1000 }},
                rate: 6.5,
                years: 30,
                get monthlyPayment() {
                    if ('{{ $property->listing_type }}' === 'For Rent') return Math.max(0, this.price + Number(this.downPayment || 0) / 12);
                    const principal = Math.max(0, this.price - Number(this.downPayment || 0));
                    const monthlyRate = Number(this.rate || 0) / 100 / 12;
                    const months = Number(this.years || 30) * 12;
                    if (!monthlyRate) return principal / months;
                    return principal * (monthlyRate * Math.pow(1 + monthlyRate, months)) / (Math.pow(1 + monthlyRate, months) - 1);
                }
            }"
            class="flex-1 mx-auto w-full max-w-7xl px-4 py-8 sm:px-6 lg:px-8"
        >
            <div class="mb-6 flex flex-col justify-between gap-3 sm:flex-row sm:items-center">
                <a class="inline-flex items-center gap-1 text-sm font-semibold text-emerald-700 hover:gap-2" href="{{ route('properties.index') }}"><span aria-hidden="true">←</span> Back to properties</a>
                <div class="flex flex-wrap gap-2">
                    @if (auth()->user()?->isBuyer())
                        <form method="POST" action="{{ route('properties.favorite.toggle', $property) }}">
                            @csrf
                            <button class="rounded-md border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:border-emerald-300 hover:text-emerald-700">Save</button>
                        </form>
                    @elseif (auth()->check())
                        <a href="{{ route('admin.properties.edit', $property) }}" class="rounded-md border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:border-emerald-300 hover:text-emerald-700">Manage listing</a>
                    @else
                        <a href="{{ route('login', ['redirect' => url()->current()]) }}" class="rounded-md border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:border-emerald-300 hover:text-emerald-700">Sign in to save</a>
                    @endif
                </div>
            </div>

            @if (session('status'))
                <div class="mb-6 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">{{ session('status') }}</div>
            @endif

            <div class="grid gap-8 lg:grid-cols-[1.15fr_.85fr]">
                <section>
                    <img class="h-[440px] w-full rounded-lg object-cover shadow-sm" :src="selectedImage" alt="{{ $property->title }}">
                    <div class="mt-3 grid grid-cols-3 gap-3">
                        @foreach ($property->images as $image)
                            <button type="button" @click="selectedImage = '{{ $image->path }}'" class="rounded-md border border-slate-200 bg-white p-1 focus:outline-none focus:ring-2 focus:ring-emerald-600">
                                <img class="h-24 w-full rounded object-cover" src="{{ $image->path }}" alt="{{ $image->alt_text }}">
                            </button>
                        @endforeach
                    </div>
                </section>

                <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="rounded-md bg-emerald-50 px-2 py-1 text-xs font-semibold text-emerald-700">{{ $property->listing_type }}</span>
                        <span class="rounded-md bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-700">{{ $property->reference_number }}</span>
                        <span class="rounded-md bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-700">{{ $property->type }}</span>
                        @if ($property->is_featured)
                            <span class="rounded-md bg-amber-50 px-2 py-1 text-xs font-semibold text-amber-700">Featured</span>
                        @endif
                    </div>
                    <h1 class="mt-4 text-3xl font-semibold text-slate-950">{{ $property->title }}</h1>
                    <p class="mt-2 text-slate-600">{{ $property->address }}, {{ $property->city }}, {{ $property->state }}</p>
                    <p class="mt-6 text-3xl font-semibold text-slate-950">${{ number_format($property->price) }}</p>
                    <dl class="mt-6 grid grid-cols-3 gap-3 text-center">
                        <div class="rounded-md bg-slate-50 p-3"><dt class="text-sm text-slate-500">Beds</dt><dd class="font-semibold">{{ $property->bedrooms }}</dd></div>
                        <div class="rounded-md bg-slate-50 p-3"><dt class="text-sm text-slate-500">Baths</dt><dd class="font-semibold">{{ $property->bathrooms }}</dd></div>
                        <div class="rounded-md bg-slate-50 p-3"><dt class="text-sm text-slate-500">Sqft</dt><dd class="font-semibold">{{ number_format($property->area_sqft) }}</dd></div>
                    </dl>
                    <dl class="mt-3 grid grid-cols-2 gap-3 text-sm">
                        <div class="rounded-md bg-slate-50 p-3"><dt class="text-slate-500">Price / sqft</dt><dd class="font-semibold">${{ number_format($property->pricePerSqft()) }}</dd></div>
                        <div class="rounded-md bg-slate-50 p-3"><dt class="text-slate-500">Built</dt><dd class="font-semibold">{{ $property->year_built ?? 'N/A' }}</dd></div>
                        <div class="rounded-md bg-slate-50 p-3"><dt class="text-slate-500">Availability</dt><dd class="font-semibold">{{ $property->availability_status }}</dd></div>
                        <div class="rounded-md bg-slate-50 p-3"><dt class="text-slate-500">Updated</dt><dd class="font-semibold">{{ $property->updated_at->format('M j, Y') }}</dd></div>
                    </dl>
                    <div class="mt-6 border-t border-slate-200 pt-6">
                        <h2 class="font-semibold text-slate-950">Listing agent</h2>
                        <p class="mt-2 text-slate-700">{{ $property->agent->name }}</p>
                        <p class="text-sm text-slate-500">{{ $property->agent->email }} · {{ $property->agent->phone }}</p>
                    </div>
                </section>
            </div>

            <div class="mt-8 grid gap-8 lg:grid-cols-[1fr_380px]">
                <div class="space-y-8">
                    <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
                        <h2 class="text-xl font-semibold text-slate-950">Overview</h2>
                        <p class="mt-3 leading-7 text-slate-600">{{ $property->description }}</p>
                        <div class="mt-6 flex flex-wrap gap-2">
                            @foreach ($property->features ?? [] as $feature)
                                <span class="rounded-md bg-slate-100 px-3 py-1 text-sm font-medium text-slate-700">{{ $feature }}</span>
                            @endforeach
                        </div>
                    </section>

                    <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
                        <h2 class="text-xl font-semibold text-slate-950">Amenities and location</h2>
                        <div class="mt-4 grid gap-4 md:grid-cols-2">
                            <div>
                                <h3 class="font-semibold text-slate-900">Amenities</h3>
                                <div class="mt-3 flex flex-wrap gap-2">
                                    @foreach ($property->amenities ?? [] as $amenity)
                                        <span class="rounded-md bg-emerald-50 px-3 py-1 text-sm font-medium text-emerald-700">{{ $amenity }}</span>
                                    @endforeach
                                </div>
                            </div>
                            <div class="rounded-md bg-slate-50 p-4">
                                <p class="font-semibold text-slate-950">{{ $property->neighbourhood }}, {{ $property->city }}</p>
                                <p class="mt-1 text-sm text-slate-500">Explore nearby homes in this neighbourhood.</p>
                                <a class="mt-3 inline-block text-sm font-semibold text-emerald-700" href="{{ route('properties.index', ['city' => $property->city, 'area' => $property->neighbourhood, 'view' => 'map']) }}">Search this area</a>
                            </div>
                        </div>
                    </section>

                    <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
                        <h2 class="text-xl font-semibold text-slate-950">Tours and documents</h2>
                        <div class="mt-4 grid gap-3 text-sm md:grid-cols-3">
                            @if ($property->video_url)
                                <a class="rounded-xl border border-slate-200 bg-white p-3 font-semibold text-emerald-700 transition hover:border-emerald-200 hover:bg-emerald-50" href="{{ $property->video_url }}" target="_blank" rel="noopener noreferrer">Video tour</a>
                            @else
                                <span class="cursor-not-allowed rounded-xl border border-slate-200 bg-slate-100 p-3 font-semibold text-slate-400">Video tour unavailable</span>
                            @endif
                            @if ($property->virtual_tour_url)
                                <a class="rounded-xl border border-slate-200 bg-white p-3 font-semibold text-emerald-700 transition hover:border-emerald-200 hover:bg-emerald-50" href="{{ $property->virtual_tour_url }}" target="_blank" rel="noopener noreferrer">Virtual tour</a>
                            @else
                                <span class="cursor-not-allowed rounded-xl border border-slate-200 bg-slate-100 p-3 font-semibold text-slate-400">Virtual tour unavailable</span>
                            @endif
                            <button onclick="window.print()" class="rounded-xl border border-slate-200 bg-white p-3 text-left font-semibold text-emerald-700 transition hover:border-emerald-200 hover:bg-emerald-50">Print brochure</button>
                        </div>
                    </section>

                    <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
                        <h2 class="text-xl font-semibold text-slate-950">{{ $property->listing_type === 'For Sale' ? 'Payment estimate' : 'Move-in estimate' }}</h2>
                        <div class="mt-5 grid gap-4 md:grid-cols-3">
                            <label>
                                <span class="text-sm font-medium text-slate-700">{{ $property->listing_type === 'For Sale' ? 'Down payment' : 'Deposit' }}</span>
                                <input x-model.number="downPayment" type="number" min="0" class="mt-1 w-full rounded-md border-slate-300 focus:border-emerald-600 focus:ring-emerald-600">
                            </label>
                            @if ($property->listing_type === 'For Sale')
                                <label>
                                    <span class="text-sm font-medium text-slate-700">Interest rate</span>
                                    <input x-model.number="rate" type="number" min="0" step="0.1" class="mt-1 w-full rounded-md border-slate-300 focus:border-emerald-600 focus:ring-emerald-600">
                                </label>
                                <label>
                                    <span class="text-sm font-medium text-slate-700">Loan years</span>
                                    <input x-model.number="years" type="number" min="1" class="mt-1 w-full rounded-md border-slate-300 focus:border-emerald-600 focus:ring-emerald-600">
                                </label>
                            @endif
                        </div>
                        <div class="mt-5 rounded-lg bg-slate-50 p-4">
                            <p class="text-sm text-slate-500">{{ $property->listing_type === 'For Sale' ? 'Estimated monthly principal and interest' : 'Estimated monthly cost including deposit spread over 12 months' }}</p>
                            <p class="mt-1 text-3xl font-semibold text-slate-950">$<span x-text="Math.round(monthlyPayment).toLocaleString()"></span></p>
                        </div>
                    </section>
                </div>

                <aside class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
                    @if (auth()->guest())
                        <h2 class="text-xl font-semibold text-slate-950">Like this home?</h2>
                        <p class="mt-2 text-sm leading-6 text-slate-500">Sign in to save it, ask a question, or request a viewing.</p>
                        <div class="mt-5 grid gap-3">
                            <a href="{{ route('login', ['redirect' => url()->current()]) }}" class="rounded-md bg-emerald-600 px-4 py-2 text-center text-sm font-semibold text-white hover:bg-emerald-700">Sign in</a>
                            <a href="{{ route('buyer.register') }}" class="rounded-md border border-slate-300 px-4 py-2 text-center text-sm font-semibold text-slate-700 hover:border-emerald-300 hover:text-emerald-700">Create account</a>
                        </div>
                    @elseif (auth()->user()?->isBuyer())
                        <h2 class="text-xl font-semibold text-slate-950">Ask about this home</h2>
                        <p class="mt-2 text-sm text-slate-500">Send a note to the listing agent.</p>
                        <form method="POST" action="{{ route('properties.inquiries.store', $property) }}" class="mt-5 space-y-4">
                            @csrf
                        <label class="block">
                            <span class="text-sm font-medium text-slate-700">Name</span>
                            <input name="name" value="{{ old('name') }}" class="mt-1 w-full rounded-md border-slate-300 focus:border-emerald-600 focus:ring-emerald-600" required>
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </label>
                        <label class="block">
                            <span class="text-sm font-medium text-slate-700">Email</span>
                            <input name="email" type="email" value="{{ old('email') }}" class="mt-1 w-full rounded-md border-slate-300 focus:border-emerald-600 focus:ring-emerald-600" required>
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </label>
                        <label class="block">
                            <span class="text-sm font-medium text-slate-700">Phone</span>
                            <input name="phone" value="{{ old('phone') }}" class="mt-1 w-full rounded-md border-slate-300 focus:border-emerald-600 focus:ring-emerald-600">
                        </label>
                        <label class="block">
                            <span class="text-sm font-medium text-slate-700">Preferred contact</span>
                            <select name="preferred_contact" class="mt-1 w-full rounded-md border-slate-300 focus:border-emerald-600 focus:ring-emerald-600">
                                <option value="email" @selected(old('preferred_contact') === 'email')>Email</option>
                                <option value="phone" @selected(old('preferred_contact') === 'phone')>Phone</option>
                            </select>
                        </label>
                        <label class="block">
                            <span class="text-sm font-medium text-slate-700">Message</span>
                            <textarea name="message" rows="5" class="mt-1 w-full rounded-md border-slate-300 focus:border-emerald-600 focus:ring-emerald-600" required>{{ old('message', 'I would like to schedule a showing and learn more about this listing.') }}</textarea>
                            <x-input-error :messages="$errors->get('message')" class="mt-2" />
                        </label>
                        <x-ui.button class="w-full">Send inquiry</x-ui.button>
                        </form>
                        <div class="mt-8 border-t border-slate-200 pt-6">
                            <h2 class="text-xl font-semibold text-slate-950">Request a viewing</h2>
                            <form method="POST" action="{{ route('properties.viewings.store', $property) }}" class="mt-4 space-y-4">
                                @csrf
                            <label class="block"><span class="text-sm font-medium text-slate-700">Date</span><input name="preferred_date" type="date" class="mt-1 w-full rounded-md border-slate-300 focus:border-emerald-600 focus:ring-emerald-600" required></label>
                            <label class="block"><span class="text-sm font-medium text-slate-700">Time</span><input name="preferred_time" type="time" class="mt-1 w-full rounded-md border-slate-300 focus:border-emerald-600 focus:ring-emerald-600" required></label>
                            <label class="block"><span class="text-sm font-medium text-slate-700">Viewing type</span><select name="viewing_type" class="mt-1 w-full rounded-md border-slate-300"><option value="in_person">In-person</option><option value="virtual">Virtual</option></select></label>
                            <label class="block"><span class="text-sm font-medium text-slate-700">Name</span><input name="name" value="{{ old('name') }}" class="mt-1 w-full rounded-md border-slate-300" required></label>
                            <label class="block"><span class="text-sm font-medium text-slate-700">Email</span><input name="email" type="email" value="{{ old('email') }}" class="mt-1 w-full rounded-md border-slate-300" required></label>
                            <label class="block"><span class="text-sm font-medium text-slate-700">Phone</span><input name="phone" value="{{ old('phone') }}" class="mt-1 w-full rounded-md border-slate-300"></label>
                            <textarea name="message" rows="3" class="w-full rounded-md border-slate-300" placeholder="Preferred details"></textarea>
                            <x-ui.button class="w-full">Request viewing</x-ui.button>
                            </form>
                        </div>
                    @else
                        <h2 class="text-xl font-semibold text-slate-950">Staff view</h2>
                        <p class="mt-2 text-sm leading-6 text-slate-500">This public page is visible to clients when the listing is published.</p>
                        <a href="{{ route('admin.properties.edit', $property) }}" class="mt-5 inline-flex w-full items-center justify-center rounded-md bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">Edit listing</a>
                    @endif
                </aside>
            </div>

            <section class="mt-8 grid gap-8 lg:grid-cols-3">
                @foreach ([['Related listings', $relatedProperties], ['Similar price', $similarPriceProperties], ['Nearby properties', $nearbyProperties]] as [$heading, $items])
                    <div class="rounded-lg border border-slate-200 bg-white p-5">
                        <h2 class="font-semibold text-slate-950">{{ $heading }}</h2>
                        <div class="mt-4 space-y-3">
                            @forelse ($items as $item)
                                <a href="{{ route('properties.show', $item) }}" class="block rounded-md bg-slate-50 p-3 text-sm font-medium">{{ $item->title }}<span class="block text-slate-500">${{ number_format($item->price) }}</span></a>
                            @empty
                                <p class="text-sm text-slate-500">No matches yet.</p>
                            @endforelse
                        </div>
                    </div>
                @endforeach
            </section>
        </main>
        <x-public.footer />
    </body>
</html>
