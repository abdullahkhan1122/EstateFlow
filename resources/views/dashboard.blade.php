<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <h1 class="text-2xl font-semibold text-slate-950">Dashboard</h1>
                <p class="mt-1 text-sm text-slate-500">Portfolio activity and listing status.</p>
            </div>
            <x-ui.link-button href="{{ route('admin.properties.create') }}">New property</x-ui.link-button>
        </div>
    </x-slot>

    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="grid gap-4 md:grid-cols-3 xl:grid-cols-6">
            @foreach ([['Properties', $propertyCount], ['Published', $publishedCount], ['Drafts', $draftCount], ['Agents', $agentCount], ['New leads', $leadCount], ['Viewings', $viewingCount]] as [$label, $value])
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm text-slate-500">{{ $label }}</p>
                    <p class="mt-2 text-3xl font-semibold text-slate-950">{{ $value }}</p>
                </div>
            @endforeach
        </div>

        <section class="mt-8 overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 px-5 py-4">
                <h2 class="font-semibold text-slate-950">Recent properties</h2>
            </div>
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
                        @foreach ($latestProperties as $property)
                            <tr>
                                <td class="px-5 py-4 font-medium text-slate-900">{{ $property->title }}</td>
                                <td class="px-5 py-4 text-slate-600">{{ $property->agent->name }}</td>
                                <td class="px-5 py-4"><span class="rounded-md bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-700">{{ ucfirst($property->status) }}</span></td>
                                <td class="px-5 py-4 text-slate-600">${{ number_format($property->price) }}</td>
                                <td class="px-5 py-4 text-right"><a class="font-semibold text-emerald-700" href="{{ route('admin.properties.edit', $property) }}">Edit</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</x-app-layout>
