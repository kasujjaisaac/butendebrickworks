@extends('layouts.admin')

@section('admin-content')

    {{-- Page header --}}
    <div class="mb-6 flex flex-wrap items-start justify-between gap-3">
        <div>
            <a href="{{ route('admin.products.index') }}"
               class="inline-flex items-center gap-1 text-xs text-stone-400 transition hover:text-[#b86033]">
                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5"/></svg>
                Back to Products
            </a>
            <h2 class="mt-1 text-xl font-bold text-stone-900 tracking-tight">Edit: {{ $product->name }}</h2>
            <p class="mt-0.5 text-sm text-stone-500">Update the product details below.</p>
        </div>
        <form method="POST" action="{{ route('admin.products.destroy', $product) }}"
              onsubmit="return confirm('Delete this product permanently? This cannot be undone.')">
            @csrf @method('DELETE')
            <button type="submit"
                    class="inline-flex items-center gap-2 rounded-lg border border-red-200 bg-red-50 px-4 py-2.5 text-sm font-medium text-red-600 transition hover:bg-red-100 hover:border-red-300">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/></svg>
                Delete Product
            </button>
        </form>
    </div>

    <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
        @csrf @method('PUT')

        @include('admin.products._form')

        {{-- Action bar --}}
        <div class="mt-6 flex flex-wrap items-center justify-end gap-3 rounded-xl border border-[#e8d5c5] bg-white px-6 py-4 shadow-sm">
            <a href="{{ route('admin.products.index') }}"
               class="rounded-lg border border-[#d8c0ad] bg-white px-5 py-2.5 text-sm font-medium text-stone-700 transition hover:bg-stone-50">
                Cancel
            </a>
            <button type="submit"
                    class="inline-flex items-center gap-2 rounded-lg bg-[#6e2f0e] px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#8c3d12] focus:outline-none focus:ring-2 focus:ring-[#6e2f0e] focus:ring-offset-2">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                Update Product
            </button>
        </div>
    </form>

@endsection
