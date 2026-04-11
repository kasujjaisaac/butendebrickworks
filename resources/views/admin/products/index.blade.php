@extends('layouts.admin')

@section('admin-content')

    {{-- Header bar --}}
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-lg font-bold text-stone-900">Products</h2>
            <p class="mt-0.5 text-sm text-stone-500">Manage brick products and their specifications.</p>
        </div>
        <a href="{{ route('admin.products.create') }}"
           class="inline-flex items-center gap-2 rounded-lg bg-[#6e2f0e] px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#8c3d12]">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            Add Product
        </a>
    </div>

    {{-- Flash message --}}
    @if (session('success'))
        <div class="mb-4 flex items-center gap-3 rounded-lg border border-green-200 bg-green-50 px-5 py-3">
            <svg class="h-5 w-5 shrink-0 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
        </div>
    @endif

    {{-- Filters --}}
    <form method="GET" action="{{ route('admin.products.index') }}" class="mb-5 flex flex-wrap items-end gap-3">
        <div>
            <label class="block text-xs font-semibold text-stone-500 mb-1">Category</label>
            <select name="category" class="rounded-lg border border-[#d8c0ad] bg-white px-3 py-2 text-sm text-stone-800 focus:border-[#b86033] focus:outline-none focus:ring-2 focus:ring-[#b86033]/20">
                <option value="">All Categories</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs font-semibold text-stone-500 mb-1">Status</label>
            <select name="status" class="rounded-lg border border-[#d8c0ad] bg-white px-3 py-2 text-sm text-stone-800 focus:border-[#b86033] focus:outline-none focus:ring-2 focus:ring-[#b86033]/20">
                <option value="">All</option>
                <option value="active"   {{ request('status') === 'active'   ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
        <button type="submit" class="rounded-lg border border-[#d8c0ad] bg-white px-4 py-2 text-sm font-medium text-stone-700 transition hover:bg-[#fff7f0] hover:text-[#b86033]">
            Filter
        </button>
        @if (request()->hasAny(['category', 'status']))
            <a href="{{ route('admin.products.index') }}" class="text-xs text-stone-400 hover:text-[#b86033] underline self-center">Clear</a>
        @endif
    </form>

    {{-- Table --}}
    <div class="overflow-hidden rounded-sm border border-[#d8c0ad] bg-white shadow-[0_8px_24px_rgba(0,0,0,0.05)]">
        @if ($products->isEmpty())
            <div class="flex flex-col items-center justify-center px-8 py-20 text-center">
                <div class="inline-flex h-14 w-14 items-center justify-center rounded-full bg-[#fff0e6] text-[#b86033]">
                    <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z"/></svg>
                </div>
                <p class="mt-4 text-base font-semibold text-stone-900">No products found</p>
                <p class="mt-1 text-sm text-stone-500">Add your first product to get started.</p>
                <a href="{{ route('admin.products.create') }}" class="mt-5 inline-flex items-center gap-1.5 rounded-lg bg-[#6e2f0e] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#8c3d12]">
                    Add Product
                </a>
            </div>
        @else
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b border-[#ead7c9] bg-[#fff9f4]">
                        <th class="w-16 px-4 py-3.5 text-xs font-semibold uppercase tracking-[0.18em] text-stone-500">Image</th>
                        <th class="px-4 py-3.5 text-xs font-semibold uppercase tracking-[0.18em] text-stone-500">Product</th>
                        <th class="hidden px-4 py-3.5 text-xs font-semibold uppercase tracking-[0.18em] text-stone-500 md:table-cell">Category</th>
                        <th class="hidden px-4 py-3.5 text-xs font-semibold uppercase tracking-[0.18em] text-stone-500 lg:table-cell">Dimensions</th>
                        <th class="hidden px-4 py-3.5 text-xs font-semibold uppercase tracking-[0.18em] text-stone-500 lg:table-cell">Weight</th>
                        <th class="hidden px-4 py-3.5 text-xs font-semibold uppercase tracking-[0.18em] text-stone-500 lg:table-cell">Coverage</th>
                        <th class="px-4 py-3.5 text-xs font-semibold uppercase tracking-[0.18em] text-stone-500">Status</th>
                        <th class="px-4 py-3.5"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#f0e8e1]">
                    @foreach ($products as $product)
                        <tr class="transition hover:bg-[#fff7f2]">
                            <td class="px-4 py-3">
                                @if ($product->image)
                                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}"
                                         class="h-12 w-12 rounded-md object-cover border border-stone-200">
                                @else
                                    <div class="flex h-12 w-12 items-center justify-center rounded-md bg-stone-100 text-stone-400">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"/></svg>
                                    </div>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <p class="font-semibold text-stone-900">{{ $product->name }}</p>
                                @if ($product->description)
                                    <p class="mt-0.5 text-xs text-stone-400 line-clamp-1">{{ $product->description }}</p>
                                @endif
                            </td>
                            <td class="hidden px-4 py-3 text-stone-600 md:table-cell">
                                <span class="inline-block rounded-full bg-[#fff0e6] px-2.5 py-0.5 text-xs font-medium text-[#b86033]">
                                    {{ $product->category ?? '—' }}
                                </span>
                            </td>
                            <td class="hidden px-4 py-3 text-stone-600 lg:table-cell">
                                <span class="font-mono text-xs">{{ $product->formatted_dimensions ?? '—' }}</span>
                            </td>
                            <td class="hidden px-4 py-3 text-stone-600 lg:table-cell">
                                @if ($product->weight_kg)
                                    <span class="font-mono text-xs">{{ $product->weight_kg }} kg</span>
                                @else
                                    <span class="text-stone-400">—</span>
                                @endif
                            </td>
                            <td class="hidden px-4 py-3 text-stone-600 lg:table-cell">
                                @if ($product->coverage > 0)
                                    <span class="font-mono text-xs">{{ number_format($product->coverage, 4) }} m²/unit</span>
                                @else
                                    <span class="text-stone-400">—</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <form method="POST" action="{{ route('admin.products.toggle-active', $product) }}">
                                    @csrf @method('PATCH')
                                    <button type="submit"
                                            class="inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-semibold transition
                                                {{ $product->is_active ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-stone-100 text-stone-500 hover:bg-stone-200' }}">
                                        <span class="h-1.5 w-1.5 rounded-full {{ $product->is_active ? 'bg-green-500' : 'bg-stone-400' }}"></span>
                                        {{ $product->is_active ? 'Active' : 'Inactive' }}
                                    </button>
                                </form>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.products.edit', $product) }}"
                                       class="inline-flex items-center gap-1 rounded-sm border border-[#d8c0ad] px-3 py-1.5 text-xs font-medium text-stone-700 transition hover:bg-[#fff0e6] hover:text-[#b86033]">
                                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z"/></svg>
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}"
                                          onsubmit="return confirm('Delete this product? This cannot be undone.')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-1 rounded-sm border border-red-200 px-3 py-1.5 text-xs font-medium text-red-600 transition hover:bg-red-50">
                                            <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/></svg>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @if ($products->hasPages())
                <div class="border-t border-[#ead7c9] px-5 py-4">
                    {{ $products->links() }}
                </div>
            @endif
        @endif
    </div>

@endsection
