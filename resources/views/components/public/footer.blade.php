<footer class="mt-auto border-t border-slate-200 bg-white">
    <div class="mx-auto grid max-w-7xl gap-8 px-4 py-10 text-sm text-slate-600 sm:px-6 md:grid-cols-[1.2fr_1fr_1fr_1fr] lg:px-8">
        <div>
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 font-bold text-slate-950">
                <x-application-logo class="h-8 w-8 fill-current text-emerald-600" />
                EstateFlow
            </a>
            <p class="mt-4 max-w-sm leading-6">A polished real-estate platform for browsing homes, saving favorites, and booking viewings.</p>
        </div>
        <div>
            <p class="font-semibold text-slate-950">Explore</p>
            <div class="mt-3 space-y-2">
                <a class="block transition hover:text-emerald-700" href="{{ route('properties.index') }}">Properties</a>
                <a class="block transition hover:text-emerald-700" href="{{ route('login', ['redirect' => url()->current()]) }}">Login</a>
                <a class="block transition hover:text-emerald-700" href="{{ route('buyer.register') }}">Create account</a>
            </div>
        </div>
        <div>
            <p class="font-semibold text-slate-950">Contact</p>
            <div class="mt-3 space-y-2">
                <p>120 Market Street, Austin, TX</p>
                <p>(555) 010-1000</p>
                <p>hello@estateflow.test</p>
            </div>
        </div>
        <div>
            <p class="font-semibold text-slate-950">Legal</p>
            <div class="mt-3 space-y-2">
                <a class="block transition hover:text-emerald-700" href="#">Privacy</a>
                <a class="block transition hover:text-emerald-700" href="#">Terms</a>
                <a class="block transition hover:text-emerald-700" href="#">Fair housing</a>
            </div>
        </div>
    </div>
</footer>
