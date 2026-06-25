<form method="GET" class="sticky top-24 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
    <input type="hidden" name="view" value="{{ request('view', 'grid') }}">

    <div class="border-b border-slate-100 px-5 py-4">
        <div class="flex items-center justify-between gap-3">
            <div>
                <h2 class="text-base font-semibold text-slate-950">Refine search</h2>
                <p class="mt-1 text-sm text-slate-500">Location, budget, and home details.</p>
            </div>
            <a href="{{ route('properties.index') }}" class="text-sm font-semibold text-slate-500 transition hover:text-emerald-700">Reset</a>
        </div>
    </div>

    <div class="space-y-5 p-5">
        <label class="block">
            <span class="text-xs font-semibold uppercase tracking-wide text-slate-500">Keyword</span>
            <input name="search" value="{{ request('search') }}" class="mt-2 h-12 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 text-sm text-slate-900 shadow-inner shadow-slate-100 placeholder:text-slate-400 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-100" placeholder="Title, address, reference">
        </label>

        <div class="grid grid-cols-2 gap-3">
            <label class="block">
                <span class="text-xs font-semibold uppercase tracking-wide text-slate-500">City</span>
                <select name="city" class="mt-2 h-12 w-full rounded-xl border border-slate-200 bg-slate-50 px-3 text-sm text-slate-900 shadow-inner shadow-slate-100 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-100">
                    <option value="">Any city</option>
                    @foreach ($cities as $city)
                        <option value="{{ $city }}" @selected(request('city') === $city)>{{ $city }}</option>
                    @endforeach
                </select>
            </label>
            <label class="block">
                <span class="text-xs font-semibold uppercase tracking-wide text-slate-500">Reference</span>
                <input name="reference_number" value="{{ request('reference_number') }}" class="mt-2 h-12 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 text-sm shadow-inner shadow-slate-100 placeholder:text-slate-400 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-100" placeholder="EF-01001">
            </label>
        </div>

        <label class="block">
            <span class="text-xs font-semibold uppercase tracking-wide text-slate-500">Area or neighbourhood</span>
            <input name="area" value="{{ request('area') }}" class="mt-2 h-12 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 text-sm shadow-inner shadow-slate-100 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-100">
        </label>

        <div class="grid grid-cols-2 gap-3">
            <label>
                <span class="text-xs font-semibold uppercase tracking-wide text-slate-500">Type</span>
                <select name="type" class="mt-2 h-12 w-full rounded-xl border border-slate-200 bg-slate-50 px-3 text-sm shadow-inner shadow-slate-100 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-100">
                    @foreach (['' => 'Any'] + array_combine($types, $types) as $value => $label)
                        <option value="{{ $value }}" @selected(request('type') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </label>
            <label>
                <span class="text-xs font-semibold uppercase tracking-wide text-slate-500">Sale / rent</span>
                <select name="listing_type" class="mt-2 h-12 w-full rounded-xl border border-slate-200 bg-slate-50 px-3 text-sm shadow-inner shadow-slate-100 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-100">
                    @foreach (['' => 'Any'] + array_combine($listingTypes, $listingTypes) as $value => $label)
                        <option value="{{ $value }}" @selected(request('listing_type') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </label>
        </div>

        <div>
            <span class="text-xs font-semibold uppercase tracking-wide text-slate-500">Budget</span>
            <div class="mt-2 grid grid-cols-2 gap-3">
                <input name="min_price" type="number" value="{{ request('min_price') }}" class="h-12 rounded-xl border border-slate-200 bg-slate-50 px-4 text-sm shadow-inner shadow-slate-100 placeholder:text-slate-400 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-100" placeholder="Min">
                <input name="max_price" type="number" value="{{ request('max_price') }}" class="h-12 rounded-xl border border-slate-200 bg-slate-50 px-4 text-sm shadow-inner shadow-slate-100 placeholder:text-slate-400 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-100" placeholder="Max">
            </div>
        </div>

        <div>
            <span class="text-xs font-semibold uppercase tracking-wide text-slate-500">Rooms</span>
            <div class="mt-2 grid grid-cols-2 gap-3">
                <input name="bedrooms" type="number" min="0" value="{{ request('bedrooms') }}" class="h-12 rounded-xl border border-slate-200 bg-slate-50 px-4 text-sm shadow-inner shadow-slate-100 placeholder:text-slate-400 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-100" placeholder="Beds">
                <input name="bathrooms" type="number" min="0" value="{{ request('bathrooms') }}" class="h-12 rounded-xl border border-slate-200 bg-slate-50 px-4 text-sm shadow-inner shadow-slate-100 placeholder:text-slate-400 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-100" placeholder="Baths">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-3">
            <label>
                <span class="text-xs font-semibold uppercase tracking-wide text-slate-500">Min area</span>
                <input name="min_area" type="number" value="{{ request('min_area') }}" class="mt-2 h-12 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 text-sm shadow-inner shadow-slate-100 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-100" placeholder="Sqft">
            </label>
            <label>
                <span class="text-xs font-semibold uppercase tracking-wide text-slate-500">Furnishing</span>
                <select name="furnishing_status" class="mt-2 h-12 w-full rounded-xl border border-slate-200 bg-slate-50 px-3 text-sm shadow-inner shadow-slate-100 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-100">
                    <option value="">Any</option>
                    @foreach ($furnishingStatuses as $status)
                        <option value="{{ $status }}" @selected(request('furnishing_status') === $status)>{{ $status }}</option>
                    @endforeach
                </select>
            </label>
        </div>

        <fieldset>
            <legend class="text-xs font-semibold uppercase tracking-wide text-slate-500">Highlights</legend>
            <div class="mt-3 grid grid-cols-2 gap-2 text-sm">
                @foreach ([['featured', 'Featured'], ['open_house', 'Open house'], ['price_reduced', 'Price drop'], ['recently_added', 'New']] as [$name, $label])
                    <label class="flex h-10 cursor-pointer items-center justify-center rounded-full border px-3 font-semibold transition {{ request($name) ? 'border-emerald-600 bg-emerald-50 text-emerald-700' : 'border-slate-200 bg-white text-slate-600 hover:border-emerald-200 hover:text-emerald-700' }}">
                        <input name="{{ $name }}" value="1" type="checkbox" @checked(request($name)) class="sr-only">
                        {{ $label }}
                    </label>
                @endforeach
            </div>
        </fieldset>

        <fieldset>
            <legend class="text-xs font-semibold uppercase tracking-wide text-slate-500">Amenities</legend>
            <div class="mt-3 flex flex-wrap gap-2 text-sm">
                @foreach ($amenities as $amenity)
                    <label class="cursor-pointer rounded-full border px-3 py-2 font-medium transition {{ in_array($amenity, (array) request('amenities', [])) ? 'border-emerald-600 bg-emerald-50 text-emerald-700' : 'border-slate-200 bg-white text-slate-600 hover:border-emerald-200 hover:text-emerald-700' }}">
                        <input name="amenities[]" value="{{ $amenity }}" type="checkbox" @checked(in_array($amenity, (array) request('amenities', []))) class="sr-only">
                        {{ $amenity }}
                    </label>
                @endforeach
            </div>
        </fieldset>

        <label class="block">
            <span class="text-xs font-semibold uppercase tracking-wide text-slate-500">Sort</span>
            <select name="sort" class="mt-2 h-12 w-full rounded-xl border border-slate-200 bg-slate-50 px-3 text-sm shadow-inner shadow-slate-100 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-100">
                <option value="">Newest</option>
                <option value="price_asc" @selected(request('sort') === 'price_asc')>Price low to high</option>
                <option value="price_desc" @selected(request('sort') === 'price_desc')>Price high to low</option>
                <option value="area_desc" @selected(request('sort') === 'area_desc')>Largest area</option>
                <option value="oldest" @selected(request('sort') === 'oldest')>Oldest</option>
            </select>
        </label>
    </div>

    <div class="border-t border-slate-100 bg-slate-50 p-4">
        <button class="w-full rounded-full bg-slate-950 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:-translate-y-0.5 hover:bg-slate-800">Apply filters</button>
    </div>
</form>
