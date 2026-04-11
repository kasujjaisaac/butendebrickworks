@php
    $isActive = fn(string|array $patterns) => request()->routeIs((array)$patterns);

    $link = function(bool $active) {
        return 'group relative flex items-center gap-3 rounded-lg px-3 py-2.5 text-[13px] font-medium transition-all ' .
            ($active
                ? 'bg-[#f9ede6] text-[#6e2f0e] font-semibold'
                : 'text-stone-500 hover:bg-stone-50 hover:text-stone-800');
    };

    $indicator = fn(bool $active) =>
        'absolute left-0 top-1/2 h-5 w-[3px] -translate-y-1/2 rounded-r-full bg-[#6e2f0e] transition-all ' .
        ($active ? 'opacity-100' : 'opacity-0');

    $icon = fn(bool $active) =>
        'flex h-7 w-7 shrink-0 items-center justify-center rounded-lg transition ' .
        ($active ? 'bg-[#6e2f0e] text-white shadow-sm' : 'bg-stone-100 text-stone-400 group-hover:bg-stone-200 group-hover:text-stone-600');
@endphp

<nav class="flex-1 overflow-y-auto px-3 py-4 space-y-0.5">

    <a href="{{ route('portal.dashboard') }}" class="{{ $link($isActive('portal.dashboard')) }}">
        <span class="{{ $indicator($isActive('portal.dashboard')) }}"></span>
        <span class="{{ $icon($isActive('portal.dashboard')) }}">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z"/></svg>
        </span>
        Overview
    </a>

    <p class="mt-4 mb-1.5 px-3 text-[10px] font-bold uppercase tracking-[0.2em] text-stone-300">My Account</p>

    <a href="{{ route('quotation.index') }}" class="{{ $link($isActive('quotation.*')) }}">
        <span class="{{ $indicator($isActive('quotation.*')) }}"></span>
        <span class="{{ $icon($isActive('quotation.*')) }}">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z"/></svg>
        </span>
        Quotations
    </a>

    <a href="{{ route('orders.index') }}" class="{{ $link($isActive('orders.*')) }}">
        <span class="{{ $indicator($isActive('orders.*')) }}"></span>
        <span class="{{ $icon($isActive('orders.*')) }}">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z"/></svg>
        </span>
        My Orders
    </a>

    <p class="mt-4 mb-1.5 px-3 text-[10px] font-bold uppercase tracking-[0.2em] text-stone-300">Tools</p>

    <a href="{{ route('calculator') }}" class="{{ $link($isActive('calculator')) }}">
        <span class="{{ $indicator($isActive('calculator')) }}"></span>
        <span class="{{ $icon($isActive('calculator')) }}">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 15.75V18m-7.5-6.75h.008v.008H8.25v-.008Zm0 2.25h.008v.008H8.25V13.5Zm0 2.25h.008v.008H8.25v-.008Zm0 2.25h.008v.008H8.25V18Zm2.498-6.75h.007v.008h-.007v-.008Zm0 2.25h.007v.008h-.007V13.5Zm0 2.25h.007v.008h-.007v-.008Zm0 2.25h.007v.008h-.007V18Zm2.504-6.75h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V13.5Zm0 2.25h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V18Zm2.498-6.75h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V13.5ZM8.25 6h7.5v2.25h-7.5V6ZM12 2.25c-1.892 0-3.758.11-5.593.322C5.307 2.7 4.5 3.616 4.5 4.698V18a2.25 2.25 0 0 0 2.25 2.25h10.5A2.25 2.25 0 0 0 19.5 18V4.698c0-1.082-.807-1.998-1.907-2.126A48.32 48.32 0 0 0 12 2.25Z"/></svg>
        </span>
        Products Calculator
    </a>

    <p class="mt-4 mb-1.5 px-3 text-[10px] font-bold uppercase tracking-[0.2em] text-stone-300">Settings</p>

    <a href="{{ route('profile.edit') }}" class="{{ $link($isActive('profile.*')) }}">
        <span class="{{ $indicator($isActive('profile.*')) }}"></span>
        <span class="{{ $icon($isActive('profile.*')) }}">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/></svg>
        </span>
        Profile & Settings
    </a>

</nav>

{{-- Bottom --}}
<div class="flex-shrink-0 border-t border-stone-100 px-3 py-3 space-y-0.5">
    <a href="{{ route('home') }}"
       class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-[13px] font-medium text-stone-400 transition hover:bg-stone-50 hover:text-stone-700">
        <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-stone-100">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/></svg>
        </span>
        Back to Website
    </a>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit"
            class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-[13px] font-medium text-stone-400 transition hover:bg-rose-50 hover:text-rose-600">
            <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-stone-100">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9"/></svg>
            </span>
            Sign Out
        </button>
    </form>
</div>
