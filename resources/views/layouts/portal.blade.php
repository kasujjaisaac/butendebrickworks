<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $pageTitle ?? 'My Portal' }} | Butende Brick Works</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700;playfair+display:600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>[x-cloak]{display:none!important}</style>
    </head>
    <body class="min-h-screen bg-[#f7f4f1] antialiased" style="font-family:'Inter',sans-serif;">

        {{-- ─── MOBILE TOPBAR ────────────────────────────────────────────── --}}
        <div x-data="{ open: false }" class="lg:hidden">
            <div class="flex items-center justify-between border-b border-stone-200 bg-white px-4 py-3 shadow-sm">
                <a href="{{ route('portal.dashboard') }}" class="flex items-center gap-2.5">
                    <div class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-[#6e2f0e] text-xs font-bold text-white tracking-wide">BB</div>
                    <div>
                        <p class="text-[13px] font-semibold text-stone-900 leading-none">Butende Bricks</p>
                        <p class="text-[10px] text-[#b86033] font-medium uppercase tracking-widest mt-0.5">Client Portal</p>
                    </div>
                </a>
                <button @click="open = !open"
                    class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-stone-200 text-stone-500 transition hover:bg-stone-50">
                    <svg x-show="!open" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/></svg>
                    <svg x-show="open" x-cloak class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/></svg>
                </button>
            </div>

            {{-- Mobile drawer --}}
            <div x-show="open" x-cloak
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-x-4"
                 x-transition:enter-end="opacity-100 translate-x-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-x-0"
                 x-transition:leave-end="opacity-0 -translate-x-4"
                 class="fixed inset-0 z-50 flex">
                <div @click="open = false" class="absolute inset-0 bg-black/40"></div>
                <nav class="relative flex w-72 flex-col bg-white shadow-2xl">
                    <div class="flex items-center justify-between border-b border-stone-100 px-5 py-4">
                        <div class="flex items-center gap-2.5">
                            <div class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-[#6e2f0e] text-sm font-bold text-white">BB</div>
                            <div>
                                <p class="text-[13px] font-semibold text-stone-900">Butende Bricks</p>
                                <p class="text-[10px] text-[#b86033] font-medium uppercase tracking-widest">Client Portal</p>
                            </div>
                        </div>
                        <button @click="open = false" class="text-stone-400 hover:text-stone-700">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                    @include('layouts.portal-nav')
                </nav>
            </div>
        </div>

        <div class="min-h-screen lg:flex">

            {{-- ─── DESKTOP SIDEBAR ──────────────────────────────────── --}}
            <aside class="hidden lg:flex lg:w-[15.5rem] lg:shrink-0 lg:flex-col border-r border-stone-200 bg-white">

                {{-- User card --}}
                <div class="px-4 py-4 border-b border-stone-100">
                    <div class="flex items-center gap-3 rounded-xl bg-stone-50 px-3 py-2.5 ring-1 ring-stone-200">
                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[#6e2f0e] text-[13px] font-bold text-white ring-2 ring-[#6e2f0e]/20">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div class="min-w-0">
                            <p class="truncate text-[12.5px] font-semibold text-stone-800">{{ Auth::user()->name }}</p>
                            <p class="truncate text-[11px] text-stone-400 mt-0.5">{{ Auth::user()->organisation ?? 'Client Account' }}</p>
                        </div>
                    </div>
                </div>

                @include('layouts.portal-nav')
            </aside>

            {{-- ─── MAIN AREA ────────────────────────────────────────── --}}
            <div class="flex flex-1 flex-col min-w-0">

                {{-- Desktop topbar --}}
                <header class="hidden lg:flex items-center justify-between border-b border-stone-200 bg-white px-6 py-3 shadow-sm">
                    <div>
                        @isset($header)
                            {{ $header }}
                        @else
                            <p class="text-sm text-stone-500">{{ now()->format('l, d F Y') }}</p>
                        @endisset
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-[#6e2f0e] text-xs font-bold text-white ring-2 ring-[#6e2f0e]/20">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                    </div>
                </header>

                {{-- Page content --}}
                <main class="flex-1">
                    {{ $slot }}
                </main>

                {{-- Footer --}}
                <footer class="border-t border-stone-200 bg-white px-6 py-3">
                    <p class="text-[11px] text-stone-400">&copy; {{ date('Y') }} Butende Brick Works Ltd. &mdash; For support, email <a href="mailto:info@butendesite.com" class="text-[#b86033] hover:underline">info@butendesite.com</a></p>
                </footer>

            </div>
        </div>
        @stack('scripts')
    </body>
</html>
