<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <h1 class="text-2xl font-semibold text-slate-950">Agents</h1>
                <p class="mt-1 text-sm text-slate-500">Manage staff accounts that own property listings.</p>
            </div>
            <x-ui.link-button href="{{ route('admin.agents.create') }}">New agent</x-ui.link-button>
        </div>
    </x-slot>

    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50 text-left text-slate-500">
                        <tr>
                            <th class="px-5 py-3 font-semibold">Agent</th>
                            <th class="px-5 py-3 font-semibold">Phone</th>
                            <th class="px-5 py-3 font-semibold">Listings</th>
                            <th class="px-5 py-3 font-semibold">Status</th>
                            <th class="px-5 py-3 font-semibold"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse ($agents as $agent)
                            <tr>
                                <td class="px-5 py-4">
                                    <div class="font-medium text-slate-950">{{ $agent->name }}</div>
                                    <div class="text-slate-500">{{ $agent->email }}</div>
                                </td>
                                <td class="px-5 py-4 text-slate-600">{{ $agent->phone }}</td>
                                <td class="px-5 py-4 text-slate-600">{{ $agent->properties_count }}</td>
                                <td class="px-5 py-4"><span class="rounded-md bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-700">{{ $agent->is_active ? 'Active' : 'Inactive' }}</span></td>
                                <td class="px-5 py-4">
                                    <div class="flex justify-end gap-3">
                                        <a class="font-semibold text-emerald-700" href="{{ route('admin.agents.edit', $agent) }}">Edit</a>
                                        <form method="POST" action="{{ route('admin.agents.destroy', $agent) }}" onsubmit="return confirm('Delete this agent?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="font-semibold text-red-600">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-5 py-8 text-slate-600">No agents found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-6">{{ $agents->links() }}</div>
    </div>
</x-app-layout>
