<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $pageTitle ?? 'Admin' }} | Butende Brick Works</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600;playfair+display:600,700;poppins:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-[#f5f0eb] font-sans text-stone-900 antialiased">

        @php
            $_unreadMsgs   = \App\Models\ContactMessage::query()->unread()->count();
            $_pendingQuotes = \App\Models\Quotation::where('status', 'pending')->count();
            $_pendingOrders = \App\Models\Order::where('order_status', 'pending')->count();

            // Helper: is current route within a given prefix group?
            $inGroup = fn(array $patterns) => collect($patterns)->contains(fn($p) => request()->routeIs($p));
        @endphp

        {{-- ─── MOBILE TOPBAR ──────────────────────────────────────────── --}}
        <div class="flex items-center justify-between border-b border-[#3a1608]/20 bg-[#6e2f0e] px-5 py-3 lg:hidden">
            <div class="flex items-center">
                <div class="overflow-hidden rounded-lg bg-white px-3 py-1.5 shadow ring-1 ring-white/20">
                    <img src="{{ asset('images/butende-logo.jpg') }}" alt="Butende Brick Works" class="h-8 w-auto object-contain">
                </div>
            </div>
            {{-- Hamburger --}}
            <button
                id="sidebar-toggle"
                class="inline-flex items-center justify-center rounded-md p-2 text-white/80 transition hover:bg-white/10 hover:text-white"
                aria-label="Toggle navigation"
            >
                <svg id="icon-menu" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/></svg>
                <svg id="icon-close" class="hidden h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <div class="min-h-screen lg:grid lg:grid-cols-[17rem_1fr]">

            {{-- ─── SIDEBAR ─────────────────────────────────────────────── --}}
            <aside
                id="sidebar"
                class="fixed inset-y-0 left-0 z-40 hidden w-[17rem] flex-col overflow-y-auto bg-[#6e2f0e] lg:relative lg:flex lg:inset-auto"
                style="font-family: 'Poppins', sans-serif;"
            >
                {{-- Logo --}}
                <div class="flex-shrink-0 border-b border-white/10">
                    <a href="{{ route('admin.dashboard') }}" class="block">
                        <div class="overflow-hidden rounded-none bg-white px-5 py-4 shadow-md w-full">
                            <img src="{{ asset('images/butende-logo.jpg') }}" alt="Butende Brick Works" class="h-10 w-full object-contain">
                        </div>
                        <p class="px-5 py-2.5 text-[10px] font-semibold uppercase tracking-[0.22em] text-white/35">Control Panel</p>
                    </a>
                </div>

                {{-- Scrollable nav area --}}
                <nav class="flex-1 overflow-y-auto px-3 py-5 space-y-0.5">

                    {{-- 1. OVERVIEW --}}
                    <a
                        href="{{ route('admin.dashboard') }}"
                        class="group flex items-center gap-3 rounded-lg px-3.5 py-2.5 text-[13px] font-medium transition
                            {{ request()->routeIs('admin.dashboard') ? 'bg-white/15 text-white shadow-sm' : 'text-white/70 hover:bg-white/10 hover:text-white' }}"
                    >
                        <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-md {{ request()->routeIs('admin.dashboard') ? 'bg-white/20' : 'bg-white/8 group-hover:bg-white/15' }} transition">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z"/></svg>
                        </span>
                        Dashboard
                    </a>

                    {{-- 2. PRODUCTS --}}
                    @php $productsOpen = $inGroup(['admin.products.*']); @endphp
                    <a
                        href="{{ route('admin.products.index') }}"
                        class="group flex items-center gap-3 rounded-lg px-3.5 py-2.5 text-[13px] font-medium transition
                            {{ $productsOpen ? 'bg-white/15 text-white shadow-sm' : 'text-white/70 hover:bg-white/10 hover:text-white' }}"
                    >
                        <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-md {{ $productsOpen ? 'bg-white/20' : 'bg-white/8 group-hover:bg-white/15' }} transition">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z"/></svg>
                        </span>
                        Products
                    </a>

                    {{-- 3. QUOTATIONS --}}
                    @php $quotesOpen = $inGroup(['admin.quotations.*']); @endphp
                    <a
                        href="{{ route('admin.quotations.index') }}"
                        class="group flex items-center gap-3 rounded-lg px-3.5 py-2.5 text-[13px] font-medium transition
                            {{ $quotesOpen ? 'bg-white/15 text-white shadow-sm' : 'text-white/70 hover:bg-white/10 hover:text-white' }}"
                    >
                        <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-md {{ $quotesOpen ? 'bg-white/20' : 'bg-white/8 group-hover:bg-white/15' }} transition">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/></svg>
                        </span>
                        <span class="flex-1">Quotations</span>
                        @if ($_pendingQuotes > 0)
                            <span class="ml-auto inline-flex h-5 min-w-5 items-center justify-center rounded-full bg-yellow-400 px-1 text-[10px] font-bold text-[#6e2f0e]">{{ $_pendingQuotes }}</span>
                        @endif
                    </a>

                    {{-- 4. ORDERS --}}
                    @php $ordersOpen = $inGroup(['admin.orders.*']); @endphp
                    <a
                        href="{{ route('admin.orders.index') }}"
                        class="group flex items-center gap-3 rounded-lg px-3.5 py-2.5 text-[13px] font-medium transition
                            {{ $ordersOpen ? 'bg-white/15 text-white shadow-sm' : 'text-white/70 hover:bg-white/10 hover:text-white' }}"
                    >
                        <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-md {{ $ordersOpen ? 'bg-white/20' : 'bg-white/8 group-hover:bg-white/15' }} transition">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/></svg>
                        </span>
                        <span class="flex-1">Orders</span>
                        @if ($_pendingOrders > 0)
                            <span class="ml-auto inline-flex h-5 min-w-5 items-center justify-center rounded-full bg-orange-400 px-1 text-[10px] font-bold text-white">{{ $_pendingOrders }}</span>
                        @endif
                    </a>

                    {{-- 5. CLIENTS --}}
                    <a
                        href="{{ route('admin.users.index') }}"
                        class="group flex items-center gap-3 rounded-lg px-3.5 py-2.5 text-[13px] font-medium transition
                            {{ request()->routeIs('admin.users.*') ? 'bg-white/15 text-white shadow-sm' : 'text-white/70 hover:bg-white/10 hover:text-white' }}"
                    >
                        <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-md {{ request()->routeIs('admin.users.*') ? 'bg-white/20' : 'bg-white/8 group-hover:bg-white/15' }} transition">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/></svg>
                        </span>
                        Clients
                    </a>

                    {{-- 6. MESSAGES & INQUIRIES --}}
                    @php $msgsOpen = $inGroup(['admin.messages.*']); @endphp
                    <a
                        href="{{ route('admin.messages.index') }}"
                        class="group flex items-center gap-3 rounded-lg px-3.5 py-2.5 text-[13px] font-medium transition
                            {{ $msgsOpen ? 'bg-white/15 text-white shadow-sm' : 'text-white/70 hover:bg-white/10 hover:text-white' }}"
                    >
                        <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-md {{ $msgsOpen ? 'bg-white/20' : 'bg-white/8 group-hover:bg-white/15' }} transition">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75"/></svg>
                        </span>
                        <span class="flex-1">Messages & Inquiries</span>
                        @if ($_unreadMsgs > 0)
                            <span class="ml-auto inline-flex h-5 min-w-5 items-center justify-center rounded-full bg-red-400 px-1 text-[10px] font-bold text-white">{{ $_unreadMsgs }}</span>
                        @endif
                    </a>

                    {{-- 7. CUSTOMER REVIEWS --}}
                    @php $reviewsOpen = $inGroup(['admin.reviews.*']); @endphp
                    <a
                        href="{{ route('admin.reviews.index') }}"
                        class="group flex items-center gap-3 rounded-lg px-3.5 py-2.5 text-[13px] font-medium transition
                            {{ $reviewsOpen ? 'bg-white/15 text-white shadow-sm' : 'text-white/70 hover:bg-white/10 hover:text-white' }}"
                    >
                        <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-md {{ $reviewsOpen ? 'bg-white/20' : 'bg-white/8 group-hover:bg-white/15' }} transition">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z"/></svg>
                        </span>
                        Customer Reviews
                    </a>

                    {{-- 8. NEWS & BLOG --}}
                    @php $newsOpen = $inGroup(['admin.news.*']); @endphp
                    <a
                        href="{{ route('admin.news.index') }}"
                        class="group flex items-center gap-3 rounded-lg px-3.5 py-2.5 text-[13px] font-medium transition
                            {{ $newsOpen ? 'bg-white/15 text-white shadow-sm' : 'text-white/70 hover:bg-white/10 hover:text-white' }}"
                    >
                        <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-md {{ $newsOpen ? 'bg-white/20' : 'bg-white/8 group-hover:bg-white/15' }} transition">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18a2.25 2.25 0 0 0 2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 0 0 2.25 2.25h13.5M6 7.5h3v3H6v-3Z"/></svg>
                        </span>
                        News & Blog
                    </a>

                    {{-- ── UTILITIES ── --}}
                    <div class="mt-4 border-t border-white/[0.10] pt-4 space-y-0.5">
                        <a
                            href="{{ route('home') }}"
                            target="_blank"
                            rel="noreferrer"
                            class="group flex items-center gap-3 rounded-lg px-3.5 py-2.5 text-[13px] font-medium text-white/50 transition hover:bg-white/10 hover:text-white"
                        >
                            <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-md bg-white/8 group-hover:bg-white/15 transition">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                            </span>
                            View Public Site
                        </a>
                    </div>
                </nav>

                {{-- User footer --}}
                <div class="flex-shrink-0 border-t border-white/10 px-4 py-4">
                    <div class="flex items-center gap-3">
                        <div class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white/15 text-xs font-bold text-white uppercase">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="truncate text-[12.5px] font-semibold text-white">{{ auth()->user()->name }}</p>
                            <p class="truncate text-[11px] text-white/45">{{ auth()->user()->email }}</p>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" title="Sign out" class="rounded-md p-1.5 text-white/40 transition hover:bg-white/10 hover:text-white">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </aside>

            {{-- ─── MAIN ─────────────────────────────────────────────────── --}}
            <div class="flex min-h-screen flex-col">
                <header class="sticky top-0 z-30 border-b border-stone-200 bg-white/95 backdrop-blur">
                    <div class="flex items-center justify-between gap-4 px-5 py-4 lg:px-8">
                        <div>
                            <h1 class="font-sans text-xl font-semibold tracking-tight text-stone-950">
                                {{ $pageTitle ?? 'Dashboard' }}
                            </h1>
                        </div>
                        <div class="hidden items-center gap-3 lg:flex">
                            <div class="rounded-md border border-stone-200 bg-stone-50 px-3 py-1.5 text-xs text-stone-500">
                                Signed in as <span class="font-semibold text-stone-800">{{ auth()->user()->name }}</span>
                            </div>
                            <a href="{{ route('profile.edit') }}" class="inline-flex items-center gap-1.5 rounded-md border border-stone-200 bg-white px-3 py-1.5 text-xs font-medium text-stone-700 transition hover:bg-stone-50">
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/></svg>
                                Profile
                            </a>
                        </div>
                    </div>
                </header>

                <main class="flex-1 bg-white px-5 py-7 lg:px-8">
                    @if (session('status'))
                        <div class="mb-5 flex items-center gap-3 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                            <svg class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-5 flex items-center gap-3 rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                            <svg class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z"/></svg>
                            Please review the highlighted fields and try again.
                        </div>
                    @endif

                    @yield('admin-content')
                </main>
            </div>
        </div>

        {{-- Sidebar backdrop for mobile --}}
        <div id="sidebar-backdrop" class="fixed inset-0 z-30 hidden bg-black/40 backdrop-blur-sm lg:hidden"></div>

        <script>
            (function () {
                const toggle    = document.getElementById('sidebar-toggle');
                const sidebar   = document.getElementById('sidebar');
                const backdrop  = document.getElementById('sidebar-backdrop');
                const iconMenu  = document.getElementById('icon-menu');
                const iconClose = document.getElementById('icon-close');

                function openSidebar() {
                    sidebar.classList.remove('hidden');
                    sidebar.classList.add('flex');
                    backdrop.classList.remove('hidden');
                    iconMenu.classList.add('hidden');
                    iconClose.classList.remove('hidden');
                    document.body.classList.add('overflow-hidden');
                }

                function closeSidebar() {
                    sidebar.classList.add('hidden');
                    sidebar.classList.remove('flex');
                    backdrop.classList.add('hidden');
                    iconMenu.classList.remove('hidden');
                    iconClose.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                }

                toggle.addEventListener('click', function () {
                    sidebar.classList.contains('hidden') ? openSidebar() : closeSidebar();
                });

                backdrop.addEventListener('click', closeSidebar);
            })();
        </script>

        @stack('scripts')
    </body>
</html>
