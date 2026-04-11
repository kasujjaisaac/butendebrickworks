@extends('layouts.admin')
@section('admin-content')
    <div class="flex flex-col items-center justify-center rounded-lg border border-dashed border-[#c8906a] bg-white py-24 text-center shadow-sm">
        <div class="inline-flex h-16 w-16 items-center justify-center rounded-full bg-[#fff0e6] text-[#6e2f0e]">
            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17 17.25 21A2.652 2.652 0 0 0 21 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 1 1-3.586-3.586l5.654-4.654m5.879-4.182a9.013 9.013 0 0 0-7.136-7.136c3.195.434 6.002 2.085 7.136 7.136Z" />
            </svg>
        </div>
        <h2 class="mt-5 font-sans text-2xl font-semibold text-[#6e2f0e]">{{ $pageTitle }} — Coming Soon</h2>
        <p class="mt-3 max-w-sm text-sm leading-7 text-stone-500">This section is under construction. The full management interface will be available shortly.</p>
        <a href="{{ route('admin.dashboard') }}" class="mt-8 inline-flex items-center gap-2 rounded-md bg-[#6e2f0e] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#8c3d12]">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/></svg>
            Back to Dashboard
        </a>
    </div>
@endsection
