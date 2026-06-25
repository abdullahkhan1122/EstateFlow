@csrf
@if ($errors->any())
    <div class="mb-5 rounded-md border border-red-200 bg-red-50 p-4 text-sm text-red-700">
        <p class="font-semibold">Please correct the highlighted fields.</p>
    </div>
@endif

<div class="grid gap-5 md:grid-cols-2">
    <label>
        <span class="text-sm font-medium text-slate-700">Name</span>
        <input name="name" value="{{ old('name', $agent->name) }}" class="mt-1 w-full rounded-md border-slate-300 focus:border-emerald-600 focus:ring-emerald-600" required>
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </label>
    <label>
        <span class="text-sm font-medium text-slate-700">Email</span>
        <input name="email" type="email" value="{{ old('email', $agent->email) }}" class="mt-1 w-full rounded-md border-slate-300 focus:border-emerald-600 focus:ring-emerald-600" required>
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </label>
    <label>
        <span class="text-sm font-medium text-slate-700">Phone</span>
        <input name="phone" value="{{ old('phone', $agent->phone) }}" class="mt-1 w-full rounded-md border-slate-300 focus:border-emerald-600 focus:ring-emerald-600">
    </label>
    <label>
        <span class="text-sm font-medium text-slate-700">Password</span>
        <input name="password" type="password" class="mt-1 w-full rounded-md border-slate-300 focus:border-emerald-600 focus:ring-emerald-600" @required(! $agent->exists)>
        <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </label>
    <label>
        <span class="text-sm font-medium text-slate-700">Confirm password</span>
        <input name="password_confirmation" type="password" class="mt-1 w-full rounded-md border-slate-300 focus:border-emerald-600 focus:ring-emerald-600" @required(! $agent->exists)>
    </label>
    <label class="flex items-end gap-2 pb-2">
        <input name="is_active" type="checkbox" value="1" @checked(old('is_active', $agent->is_active)) class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-600">
        <span class="text-sm font-medium text-slate-700">Active account</span>
    </label>
    <label class="md:col-span-2">
        <span class="text-sm font-medium text-slate-700">Bio</span>
        <textarea name="bio" rows="5" class="mt-1 w-full rounded-md border-slate-300 focus:border-emerald-600 focus:ring-emerald-600">{{ old('bio', $agent->bio) }}</textarea>
    </label>
</div>

<div class="mt-6 flex gap-3">
    <x-ui.button>{{ $button }}</x-ui.button>
    <x-ui.link-button href="{{ route('admin.agents.index') }}" variant="secondary">Cancel</x-ui.link-button>
</div>
