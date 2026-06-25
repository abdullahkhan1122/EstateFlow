<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-semibold text-slate-950">New agent</h1>
    </x-slot>

    <div class="mx-auto max-w-4xl px-4 py-8 sm:px-6 lg:px-8">
        <form method="POST" action="{{ route('admin.agents.store') }}" class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
            @include('admin.agents._form', ['button' => 'Create agent'])
        </form>
    </div>
</x-app-layout>
