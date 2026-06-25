@csrf
@if ($errors->any())
    <div class="rounded-md border border-red-200 bg-red-50 p-4 text-sm text-red-700">
        <p class="font-semibold">Please correct the highlighted fields.</p>
    </div>
@endif

<div class="grid gap-5 md:grid-cols-2">
    <label>
        <span class="text-sm font-medium text-slate-700">Title</span>
        <input name="title" value="{{ old('title', $property->title) }}" class="mt-1 w-full rounded-md border-slate-300 focus:border-emerald-600 focus:ring-emerald-600" required>
        <x-input-error :messages="$errors->get('title')" class="mt-2" />
    </label>
    <label>
        <span class="text-sm font-medium text-slate-700">Agent</span>
        <select name="agent_id" class="mt-1 w-full rounded-md border-slate-300 focus:border-emerald-600 focus:ring-emerald-600" required>
            @foreach ($agents as $agent)
                <option value="{{ $agent->id }}" @selected((int) old('agent_id', $property->agent_id ?: auth()->id()) === $agent->id)>{{ $agent->name }}</option>
            @endforeach
        </select>
    </label>
    <label>
        <span class="text-sm font-medium text-slate-700">Type</span>
        <select name="type" class="mt-1 w-full rounded-md border-slate-300 focus:border-emerald-600 focus:ring-emerald-600" required>
            @foreach ($types as $type)
                <option value="{{ $type }}" @selected(old('type', $property->type) === $type)>{{ $type }}</option>
            @endforeach
        </select>
    </label>
    <label>
        <span class="text-sm font-medium text-slate-700">Listing type</span>
        <select name="listing_type" class="mt-1 w-full rounded-md border-slate-300 focus:border-emerald-600 focus:ring-emerald-600" required>
            @foreach ($listingTypes as $listingType)
                <option value="{{ $listingType }}" @selected(old('listing_type', $property->listing_type) === $listingType)>{{ $listingType }}</option>
            @endforeach
        </select>
    </label>
    <label>
        <span class="text-sm font-medium text-slate-700">Status</span>
        <select name="status" class="mt-1 w-full rounded-md border-slate-300 focus:border-emerald-600 focus:ring-emerald-600" required>
            @foreach (['draft', 'published', 'archived'] as $status)
                <option value="{{ $status }}" @selected(old('status', $property->status) === $status)>{{ ucfirst($status) }}</option>
            @endforeach
        </select>
        <p class="mt-1 text-xs text-slate-500">Published listings appear on the public website.</p>
    </label>
    <label>
        <span class="text-sm font-medium text-slate-700">Price</span>
        <input name="price" type="number" min="1" value="{{ old('price', $property->price) }}" class="mt-1 w-full rounded-md border-slate-300 focus:border-emerald-600 focus:ring-emerald-600" required>
    </label>
    <label>
        <span class="text-sm font-medium text-slate-700">Original price</span>
        <input name="original_price" type="number" min="1" value="{{ old('original_price', $property->original_price) }}" class="mt-1 w-full rounded-md border-slate-300 focus:border-emerald-600 focus:ring-emerald-600" placeholder="Optional">
    </label>
    <label>
        <span class="text-sm font-medium text-slate-700">Bedrooms</span>
        <input name="bedrooms" type="number" min="0" value="{{ old('bedrooms', $property->bedrooms) }}" class="mt-1 w-full rounded-md border-slate-300 focus:border-emerald-600 focus:ring-emerald-600" required>
    </label>
    <label>
        <span class="text-sm font-medium text-slate-700">Bathrooms</span>
        <input name="bathrooms" type="number" min="0" value="{{ old('bathrooms', $property->bathrooms) }}" class="mt-1 w-full rounded-md border-slate-300 focus:border-emerald-600 focus:ring-emerald-600" required>
    </label>
    <label>
        <span class="text-sm font-medium text-slate-700">Area sqft</span>
        <input name="area_sqft" type="number" min="100" value="{{ old('area_sqft', $property->area_sqft) }}" class="mt-1 w-full rounded-md border-slate-300 focus:border-emerald-600 focus:ring-emerald-600" required>
    </label>
    <label>
        <span class="text-sm font-medium text-slate-700">Furnishing</span>
        <select name="furnishing_status" class="mt-1 w-full rounded-md border-slate-300 focus:border-emerald-600 focus:ring-emerald-600" required>
            @foreach (\App\Models\Property::FURNISHING_STATUSES as $status)
                <option value="{{ $status }}" @selected(old('furnishing_status', $property->furnishing_status ?: 'Unfurnished') === $status)>{{ $status }}</option>
            @endforeach
        </select>
    </label>
    <label>
        <span class="text-sm font-medium text-slate-700">Availability</span>
        <input name="availability_status" value="{{ old('availability_status', $property->availability_status ?: 'Available') }}" class="mt-1 w-full rounded-md border-slate-300 focus:border-emerald-600 focus:ring-emerald-600" required>
    </label>
    <label>
        <span class="text-sm font-medium text-slate-700">Primary image URL</span>
        <input name="image_path" type="url" value="{{ old('image_path', $property->primaryImage?->path) }}" class="mt-1 w-full rounded-md border-slate-300 focus:border-emerald-600 focus:ring-emerald-600">
    </label>
    <label>
        <span class="text-sm font-medium text-slate-700">Upload image</span>
        <input name="image" type="file" accept="image/*" class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-sm file:mr-3 file:rounded-md file:border-0 file:bg-slate-100 file:px-3 file:py-1.5 file:font-semibold file:text-slate-700 focus:border-emerald-600 focus:ring-emerald-600">
        <x-input-error :messages="$errors->get('image')" class="mt-2" />
    </label>
    <label class="md:col-span-2">
        <span class="text-sm font-medium text-slate-700">Address</span>
        <input name="address" value="{{ old('address', $property->address) }}" class="mt-1 w-full rounded-md border-slate-300 focus:border-emerald-600 focus:ring-emerald-600" required>
    </label>
    <label>
        <span class="text-sm font-medium text-slate-700">City</span>
        <input name="city" value="{{ old('city', $property->city) }}" class="mt-1 w-full rounded-md border-slate-300 focus:border-emerald-600 focus:ring-emerald-600" required>
    </label>
    <label>
        <span class="text-sm font-medium text-slate-700">Area</span>
        <input name="area" value="{{ old('area', $property->area) }}" class="mt-1 w-full rounded-md border-slate-300 focus:border-emerald-600 focus:ring-emerald-600" placeholder="Downtown, Pearl District">
    </label>
    <label>
        <span class="text-sm font-medium text-slate-700">Neighbourhood</span>
        <input name="neighbourhood" value="{{ old('neighbourhood', $property->neighbourhood) }}" class="mt-1 w-full rounded-md border-slate-300 focus:border-emerald-600 focus:ring-emerald-600" placeholder="Community or local area">
    </label>
    <label>
        <span class="text-sm font-medium text-slate-700">State</span>
        <input name="state" value="{{ old('state', $property->state) }}" class="mt-1 w-full rounded-md border-slate-300 focus:border-emerald-600 focus:ring-emerald-600" required>
    </label>
    <label>
        <span class="text-sm font-medium text-slate-700">ZIP code</span>
        <input name="zip_code" value="{{ old('zip_code', $property->zip_code) }}" class="mt-1 w-full rounded-md border-slate-300 focus:border-emerald-600 focus:ring-emerald-600">
    </label>
    <label>
        <span class="text-sm font-medium text-slate-700">Available from</span>
        <input name="availability_date" type="date" value="{{ old('availability_date', optional($property->availability_date)->format('Y-m-d')) }}" class="mt-1 w-full rounded-md border-slate-300 focus:border-emerald-600 focus:ring-emerald-600">
    </label>
    <label>
        <span class="text-sm font-medium text-slate-700">Listing expires</span>
        <input name="listing_expiry_date" type="date" value="{{ old('listing_expiry_date', optional($property->listing_expiry_date)->format('Y-m-d')) }}" class="mt-1 w-full rounded-md border-slate-300 focus:border-emerald-600 focus:ring-emerald-600">
    </label>
    <label>
        <span class="text-sm font-medium text-slate-700">Condition</span>
        <input name="condition" value="{{ old('condition', $property->condition) }}" class="mt-1 w-full rounded-md border-slate-300 focus:border-emerald-600 focus:ring-emerald-600" placeholder="Excellent, Good, Renovated">
    </label>
    <label>
        <span class="text-sm font-medium text-slate-700">Community</span>
        <input name="community" value="{{ old('community', $property->community) }}" class="mt-1 w-full rounded-md border-slate-300 focus:border-emerald-600 focus:ring-emerald-600">
    </label>
    <label>
        <span class="text-sm font-medium text-slate-700">Floor number</span>
        <input name="floor_number" type="number" min="0" value="{{ old('floor_number', $property->floor_number) }}" class="mt-1 w-full rounded-md border-slate-300 focus:border-emerald-600 focus:ring-emerald-600">
    </label>
    <label>
        <span class="text-sm font-medium text-slate-700">Total floors</span>
        <input name="total_floors" type="number" min="0" value="{{ old('total_floors', $property->total_floors) }}" class="mt-1 w-full rounded-md border-slate-300 focus:border-emerald-600 focus:ring-emerald-600">
    </label>
    <label>
        <span class="text-sm font-medium text-slate-700">Year built</span>
        <input name="year_built" type="number" min="1800" value="{{ old('year_built', $property->year_built) }}" class="mt-1 w-full rounded-md border-slate-300 focus:border-emerald-600 focus:ring-emerald-600">
    </label>
    <label>
        <span class="text-sm font-medium text-slate-700">Energy rating</span>
        <input name="energy_rating" value="{{ old('energy_rating', $property->energy_rating) }}" class="mt-1 w-full rounded-md border-slate-300 focus:border-emerald-600 focus:ring-emerald-600" placeholder="A, B, C">
    </label>
    <label>
        <span class="text-sm font-medium text-slate-700">Latitude</span>
        <input name="latitude" type="number" step="0.0000001" value="{{ old('latitude', $property->latitude) }}" class="mt-1 w-full rounded-md border-slate-300 focus:border-emerald-600 focus:ring-emerald-600">
    </label>
    <label>
        <span class="text-sm font-medium text-slate-700">Longitude</span>
        <input name="longitude" type="number" step="0.0000001" value="{{ old('longitude', $property->longitude) }}" class="mt-1 w-full rounded-md border-slate-300 focus:border-emerald-600 focus:ring-emerald-600">
    </label>
    <label class="flex items-end gap-2 pb-2">
        <input name="is_featured" type="checkbox" value="1" @checked(old('is_featured', $property->is_featured)) class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-600">
        <span class="text-sm font-medium text-slate-700">Feature on homepage</span>
    </label>
    <label class="flex items-end gap-2 pb-2">
        <input name="has_open_house" type="checkbox" value="1" @checked(old('has_open_house', $property->has_open_house)) class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-600">
        <span class="text-sm font-medium text-slate-700">Open house</span>
    </label>
    <label>
        <span class="text-sm font-medium text-slate-700">Open house time</span>
        <input name="open_house_at" type="datetime-local" value="{{ old('open_house_at', optional($property->open_house_at)->format('Y-m-d\TH:i')) }}" class="mt-1 w-full rounded-md border-slate-300 focus:border-emerald-600 focus:ring-emerald-600">
    </label>
    <label class="md:col-span-2">
        <span class="text-sm font-medium text-slate-700">Features</span>
        <input name="features" value="{{ old('features', implode(', ', $property->features ?? [])) }}" class="mt-1 w-full rounded-md border-slate-300 focus:border-emerald-600 focus:ring-emerald-600" placeholder="Garage, Patio, Near transit">
    </label>
    <label class="md:col-span-2">
        <span class="text-sm font-medium text-slate-700">Amenities</span>
        <input name="amenities" value="{{ old('amenities', implode(', ', $property->amenities ?? [])) }}" class="mt-1 w-full rounded-md border-slate-300 focus:border-emerald-600 focus:ring-emerald-600" placeholder="Pool, Garage, Security, Gym">
    </label>
    <label>
        <span class="text-sm font-medium text-slate-700">Video URL</span>
        <input name="video_url" type="url" value="{{ old('video_url', $property->video_url) }}" class="mt-1 w-full rounded-md border-slate-300 focus:border-emerald-600 focus:ring-emerald-600">
    </label>
    <label>
        <span class="text-sm font-medium text-slate-700">Virtual tour URL</span>
        <input name="virtual_tour_url" type="url" value="{{ old('virtual_tour_url', $property->virtual_tour_url) }}" class="mt-1 w-full rounded-md border-slate-300 focus:border-emerald-600 focus:ring-emerald-600">
    </label>
    <label class="md:col-span-2">
        <span class="text-sm font-medium text-slate-700">Description</span>
        <textarea name="description" rows="6" class="mt-1 w-full rounded-md border-slate-300 focus:border-emerald-600 focus:ring-emerald-600" required>{{ old('description', $property->description) }}</textarea>
        <x-input-error :messages="$errors->get('description')" class="mt-2" />
    </label>
</div>

<div class="mt-6 flex gap-3">
    <x-ui.button>{{ $button }}</x-ui.button>
    <x-ui.link-button href="{{ route('admin.properties.index') }}" variant="secondary">Cancel</x-ui.link-button>
</div>
