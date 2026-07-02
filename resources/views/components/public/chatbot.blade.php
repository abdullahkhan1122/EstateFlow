<div
    x-data="estateFlowChatbot('{{ route('chatbot.message') }}')"
    class="fixed bottom-5 right-5 z-50 flex flex-col items-end"
>
    <div
        x-cloak
        x-show="open"
        x-transition
        class="mb-4 flex h-[560px] w-[min(380px,calc(100vw-2.5rem))] flex-col overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-[0_24px_80px_rgba(15,23,42,0.22)]"
    >
        <div class="bg-slate-950 px-5 py-4 text-white">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-sm font-semibold">EstateFlow Assistant</p>
                    <p class="mt-1 text-xs text-slate-300">AI-powered property guidance and viewing help.</p>
                </div>
                <button type="button" @click="open = false" class="rounded-full p-1 text-slate-300 transition hover:bg-white/10 hover:text-white" aria-label="Close chat">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <div x-ref="messages" class="flex-1 space-y-4 overflow-y-auto bg-slate-50 px-4 py-4">
            <div class="rounded-2xl border border-amber-100 bg-amber-50 px-3 py-2 text-xs leading-5 text-amber-900">
                AI responses may be inaccurate. Please verify important property details before making decisions.
            </div>

            <template x-for="message in messages" :key="message.id">
                <div>
                    <div :class="message.role === 'user' ? 'justify-end' : 'justify-start'" class="flex">
                        <div :class="message.role === 'user' ? 'bg-emerald-600 text-white' : 'border border-slate-200 bg-white text-slate-700'" class="inline-block w-fit max-w-[88%] rounded-2xl px-4 py-3 text-sm leading-6 shadow-sm">
                            <p x-text="message.text"></p>
                        </div>
                    </div>
                    <template x-if="message.properties && message.properties.length">
                        <div class="mt-3 grid gap-2">
                            <template x-for="property in message.properties" :key="property.url">
                                <a :href="property.url" class="group flex gap-3 rounded-2xl border border-slate-200 bg-white p-3 shadow-sm transition hover:border-emerald-200 hover:bg-emerald-50">
                                    <img x-show="property.image" :src="property.image" :alt="property.title" class="h-16 w-20 rounded-xl object-cover">
                                    <div class="min-w-0">
                                        <p class="truncate text-sm font-semibold text-slate-950 group-hover:text-emerald-700" x-text="property.title"></p>
                                        <p class="mt-1 text-xs text-slate-500" x-text="property.meta"></p>
                                        <p class="mt-1 text-xs font-semibold text-slate-700" x-text="property.price + ' · ' + property.details"></p>
                                    </div>
                                </a>
                            </template>
                        </div>
                    </template>
                    <template x-if="message.suggestions && message.suggestions.length">
                        <div class="mt-3 flex flex-wrap gap-2">
                            <template x-for="suggestion in message.suggestions" :key="suggestion">
                                <button type="button" @click="send(suggestion)" class="rounded-full border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-600 transition hover:border-emerald-200 hover:text-emerald-700" x-text="suggestion"></button>
                            </template>
                        </div>
                    </template>
                </div>
            </template>
        </div>

        <form @submit.prevent="send()" class="border-t border-slate-200 bg-white p-3">
            <div class="flex items-center gap-2 rounded-full border border-slate-200 bg-slate-50 px-3 py-2 focus-within:border-emerald-300 focus-within:bg-white focus-within:ring-2 focus-within:ring-emerald-100">
                <input x-model="draft" class="min-w-0 flex-1 border-0 bg-transparent p-0 text-sm text-slate-900 placeholder:text-slate-400 focus:ring-0" placeholder="Ask about homes, budgets, cities...">
                <button type="submit" :disabled="loading" class="rounded-full bg-emerald-600 px-4 py-2 text-xs font-bold text-white transition hover:bg-emerald-700 disabled:cursor-not-allowed disabled:opacity-60">
                    <span x-show="!loading">Send</span>
                    <span x-show="loading">...</span>
                </button>
            </div>
        </form>
    </div>

    <button
        type="button"
        @click="open = !open"
        class="flex items-center gap-3 rounded-full bg-slate-950 px-5 py-4 text-sm font-bold text-white shadow-[0_18px_50px_rgba(15,23,42,0.28)] transition hover:-translate-y-0.5 hover:bg-slate-800"
        aria-label="Open EstateFlow assistant"
    >
        <svg class="h-5 w-5 text-emerald-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8.625 9.75h6.75m-6.75 3h3.75M21 12c0 4.142-4.03 7.5-9 7.5a10.4 10.4 0 0 1-3.73-.675L3 20.25l1.43-3.575A6.86 6.86 0 0 1 3 12c0-4.142 4.03-7.5 9-7.5s9 3.358 9 7.5Z" />
        </svg>
        <span class="hidden sm:inline">Ask EstateFlow</span>
    </button>
</div>
