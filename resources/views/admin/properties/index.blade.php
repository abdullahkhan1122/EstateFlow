<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <h1 class="text-2xl font-semibold text-slate-950">Properties</h1>
                <p class="mt-1 text-sm text-slate-500">Create, publish, and maintain listing inventory.</p>
            </div>
            <x-ui.link-button href="{{ route('admin.properties.create') }}">New property</x-ui.link-button>
        </div>
    </x-slot>

    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <form method="GET" class="mb-6 grid gap-4 rounded-lg border border-slate-200 bg-white p-4 md:grid-cols-5">
            <input name="search" value="{{ request('search') }}" class="rounded-md border-slate-300 focus:border-emerald-600 focus:ring-emerald-600 md:col-span-2" placeholder="Search listings">
            <select name="status" class="rounded-md border-slate-300 focus:border-emerald-600 focus:ring-emerald-600">
                <option value="">Any status</option>
                @foreach (['draft', 'published', 'archived'] as $status)
                    <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
            <select name="type" class="rounded-md border-slate-300 focus:border-emerald-600 focus:ring-emerald-600">
                <option value="">Any type</option>
                @foreach ($types as $type)
                    <option value="{{ $type }}" @selected(request('type') === $type)>{{ $type }}</option>
                @endforeach
            </select>
            <div class="flex gap-2">
                <x-ui.button>Filter</x-ui.button>
                <a href="{{ route('admin.properties.index') }}" class="rounded-md px-3 py-2 text-sm font-semibold text-slate-600">Reset</a>
            </div>
        </form>

        <div class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50 text-left text-slate-500">
                        <tr>
                            <th class="px-5 py-3 font-semibold">Property</th>
                            <th class="px-5 py-3 font-semibold">Agent</th>
                            <th class="px-5 py-3 font-semibold">Status</th>
                            <th class="px-5 py-3 font-semibold">Price</th>
                            <th class="px-5 py-3 font-semibold"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse ($properties as $property)
                            <tr>
                                <td class="px-5 py-4">
                                    <div class="font-medium text-slate-950">{{ $property->title }}</div>
                                    <div class="text-slate-500">{{ $property->city }}, {{ $property->state }} · {{ $property->type }}</div>
                                </td>
                                <td class="px-5 py-4 text-slate-600">{{ $property->agent->name }}</td>
                                <td class="px-5 py-4"><span class="rounded-md bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-700">{{ ucfirst($property->status) }}</span></td>
                                <td class="px-5 py-4 text-slate-600">${{ number_format($property->price) }}</td>
                                <td class="px-5 py-4">
                                    <div class="flex justify-end gap-3">
                                        <a class="font-semibold text-emerald-700" href="{{ route('admin.properties.edit', $property) }}">Edit</a>
                                        <form method="POST" action="{{ route('admin.properties.destroy', $property) }}" onsubmit="return confirm('Delete this property?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="font-semibold text-red-600">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-5 py-8 text-slate-600">No properties found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-6">{{ $properties->links() }}</div>
    </div>
</x-app-layout>
