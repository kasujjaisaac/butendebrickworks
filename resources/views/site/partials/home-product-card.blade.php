@php
    $index = $index ?? null;
    $useLabel = match ($product['slug'] ?? null) {
        'bricks' => 'Walling',
        'floor-tiles' => 'Flooring',
        'decorative-bricks' => 'Decor',
        'ventilators' => 'Airflow',
        default => 'Supporting',
    };
@endphp

<a href="{{ $product['path'] }}" class="home-product-card group flex flex-col p-6 bg-[#b86033]">
    <div class="text-[0.68rem] font-semibold uppercase tracking-[0.22em] text-white/70">
        {{ $useLabel }}
    </div>

    <h3 class="mt-4 font-display text-[1.25rem] font-semibold leading-snug text-white">
        {{ $product['name'] }}
    </h3>

    <span class="mt-6 inline-flex items-center gap-2 text-sm font-semibold text-white">
        View product
        <span class="inline-flex h-9 w-9 items-center justify-center rounded-sm border border-white bg-white/10 text-white transition group-hover:bg-white group-hover:text-[#b86033]">
            <svg viewBox="0 0 24 24" class="h-4 w-4 fill-current" aria-hidden="true">
                <path d="M13.2 5.8 19.4 12l-6.2 6.2-1.4-1.4 3.8-3.8H5v-2h10.6l-3.8-3.8 1.4-1.4Z"/>
            </svg>
        </span>
    </span>
</a>
