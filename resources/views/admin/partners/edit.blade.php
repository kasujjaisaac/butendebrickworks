@extends('layouts.admin')

@section('admin-content')

    {{-- Page header --}}
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-stone-900">Edit Partner</h1>
            <p class="mt-0.5 text-sm text-stone-500">Update the details for <span class="font-medium text-stone-700">{{ $partner['name'] }}</span>.</p>
        </div>
        <a
            href="{{ route('admin.partners.index') }}"
            class="inline-flex items-center gap-1.5 rounded-sm border border-[#d8c0ad] bg-white px-3.5 py-2 text-sm font-medium text-stone-700 shadow-sm transition hover:bg-stone-50"
        >
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
            </svg>
            Back to Partners
        </a>
    </div>

    <form
        action="{{ route('admin.partners.update', $index) }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf
        @method('PUT')

        @include('admin.partners._form')

        {{-- Submit --}}
        <div class="mt-6 flex items-center justify-end gap-3">
            <a
                href="{{ route('admin.partners.index') }}"
                class="rounded-sm border border-[#d8c0ad] bg-white px-5 py-2.5 text-sm font-medium text-stone-700 shadow-sm transition hover:bg-stone-50"
            >
                Cancel
            </a>
            <button
                type="submit"
                class="inline-flex items-center gap-2 rounded-sm bg-[#b86033] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#6e2f0e] focus:outline-none focus:ring-2 focus:ring-[#b86033]/40"
            >
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>
                </svg>
                Save Changes
            </button>
        </div>

    </form>

@endsection
