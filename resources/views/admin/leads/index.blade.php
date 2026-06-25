<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <h1 class="text-2xl font-semibold text-slate-950">Leads</h1>
                <p class="mt-1 text-sm text-slate-500">Property inquiries and viewing requests from the public listing pages.</p>
            </div>
            <a href="{{ route('admin.properties.index') }}" class="inline-flex items-center justify-center rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-emerald-200 hover:text-emerald-700">
                Manage properties
            </a>
        </div>
    </x-slot>

    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="grid gap-4 md:grid-cols-2">
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-500">New inquiries</p>
                <p class="mt-2 text-3xl font-semibold text-slate-950">{{ $newInquiryCount }}</p>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Pending viewings</p>
                <p class="mt-2 text-3xl font-semibold text-slate-950">{{ $pendingViewingCount }}</p>
            </div>
        </div>

        <section class="mt-8 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-100 px-5 py-4">
                <h2 class="text-base font-semibold text-slate-950">Property inquiries</h2>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse ($inquiries as $inquiry)
                    <article class="grid gap-4 px-5 py-5 lg:grid-cols-[1fr_220px]">
                        <div>
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">{{ ucfirst($inquiry->status) }}</span>
                                <span class="text-xs font-medium text-slate-500">{{ $inquiry->created_at->format('M j, Y g:i A') }}</span>
                            </div>
                            <h3 class="mt-3 text-lg font-semibold text-slate-950">{{ $inquiry->property->title }}</h3>
                            <p class="mt-1 text-sm text-slate-500">{{ $inquiry->name }} · {{ $inquiry->email }} @if ($inquiry->phone) · {{ $inquiry->phone }} @endif</p>
                            <p class="mt-3 max-w-3xl text-sm leading-6 text-slate-600">{{ $inquiry->message }}</p>
                        </div>
                        <div class="rounded-2xl bg-slate-50 p-4 text-sm">
                            <p class="font-semibold text-slate-950">Assigned agent</p>
                            <p class="mt-1 text-slate-600">{{ $inquiry->assignedAgent?->name ?? 'Unassigned' }}</p>
                            <p class="mt-4 font-semibold text-slate-950">Next action</p>
                            <p class="mt-1 text-slate-600">{{ $inquiry->next_action ?? 'Review lead' }}</p>
                        </div>
                    </article>
                @empty
                    <p class="px-5 py-8 text-sm text-slate-500">No property inquiries yet.</p>
                @endforelse
            </div>
            <div class="border-t border-slate-100 px-5 py-4">{{ $inquiries->links() }}</div>
        </section>

        <section class="mt-8 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-100 px-5 py-4">
                <h2 class="text-base font-semibold text-slate-950">Viewing requests</h2>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse ($viewingRequests as $viewing)
                    <article class="grid gap-4 px-5 py-5 lg:grid-cols-[1fr_220px]">
                        <div>
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-700">{{ ucfirst($viewing->status) }}</span>
                                <span class="text-xs font-medium text-slate-500">{{ $viewing->created_at->format('M j, Y g:i A') }}</span>
                            </div>
                            <h3 class="mt-3 text-lg font-semibold text-slate-950">{{ $viewing->property->title }}</h3>
                            <p class="mt-1 text-sm text-slate-500">{{ $viewing->name }} · {{ $viewing->email }} @if ($viewing->phone) · {{ $viewing->phone }} @endif</p>
                            <p class="mt-3 text-sm leading-6 text-slate-600">{{ $viewing->message ?: 'No additional message.' }}</p>
                        </div>
                        <div class="rounded-2xl bg-slate-50 p-4 text-sm">
                            <p class="font-semibold text-slate-950">Preferred time</p>
                            <p class="mt-1 text-slate-600">{{ $viewing->preferred_date->format('M j, Y') }} at {{ substr($viewing->preferred_time, 0, 5) }}</p>
                            <p class="mt-4 font-semibold text-slate-950">Viewing type</p>
                            <p class="mt-1 text-slate-600">{{ $viewing->viewing_type === 'virtual' ? 'Virtual' : 'In-person' }}</p>
                        </div>
                    </article>
                @empty
                    <p class="px-5 py-8 text-sm text-slate-500">No viewing requests yet.</p>
                @endforelse
            </div>
            <div class="border-t border-slate-100 px-5 py-4">{{ $viewingRequests->links() }}</div>
        </section>
    </div>
</x-app-layout>
