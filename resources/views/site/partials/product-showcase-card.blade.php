@php
    $index = $index ?? null;
    $eyebrow = $eyebrow ?? 'Clay collection';
    $description = $description ?? $product['tagline'];
    $applications = array_slice($product['applications'] ?? [], 0, 1);
@endphp

<article class="group relative isolate aspect-square overflow-hidden border border-[#b86033]/30 bg-[#b86033] shadow-md">
    <img
        src="{{ $product['image'] }}"
        alt="{{ $product['name'] }}"
        class="absolute inset-0 h-full w-full object-cover transition duration-700 group-hover:scale-[1.06]"
    >
    <div class="absolute inset-0 bg-[linear-gradient(180deg,rgba(138,58,20,0.2)_0%,rgba(138,58,20,0.5)_38%,rgba(100,40,12,0.92)_100%)]"></div>
    <div class="absolute inset-0 opacity-40" style="background-image:linear-gradient(rgba(255,255,255,0.06)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.05)_1px,transparent_1px);background-size:5rem 5rem;"></div>
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(196,106,54,0.28),transparent_18rem)]"></div>

    <div class="relative flex h-full flex-col justify-between p-6 md:p-7">
        <div class="flex items-start justify-between gap-4">
            <div class="inline-flex items-center gap-3">
                @if ($index !== null)
                    <span class="text-xs font-semibold uppercase tracking-[0.28em] text-white/80">
                        {{ str_pad((string) $index, 2, '0', STR_PAD_LEFT) }}
                    </span>
                @endif
                <span class="inline-flex border border-white/10 bg-black/20 px-3 py-1 text-[0.68rem] font-semibold uppercase tracking-[0.24em] text-stone-100">
                    {{ $eyebrow }}
                </span>
            </div>
            <span class="inline-flex h-10 w-10 items-center justify-center border border-white/20 bg-white/15 text-white transition group-hover:border-white group-hover:bg-white/30">
                <svg viewBox="0 0 24 24" class="h-4 w-4 fill-current" aria-hidden="true">
                    <path d="M13.2 5.8 19.4 12l-6.2 6.2-1.4-1.4 3.8-3.8H5v-2h10.6l-3.8-3.8 1.4-1.4Z"/>
                </svg>
            </span>
        </div>

        <div>
            <h3 class="max-w-xs font-display text-3xl font-semibold tracking-tight text-white md:text-[2rem]">
                {{ $product['name'] }}
            </h3>
            <p class="mt-3 max-w-md text-sm leading-7 text-stone-200">
                {{ $description }}
            </p>

            @if (! empty($applications))
                <div class="mt-5 flex flex-wrap gap-2">
                    @foreach ($applications as $application)
                        <span class="border border-white/10 bg-white/10 px-3 py-2 text-[0.72rem] uppercase tracking-[0.18em] text-stone-200">
                            {{ $application }}
                        </span>
                    @endforeach
                </div>
            @endif
        </div>

        <a
            href="{{ $product['path'] }}"
            class="inline-flex w-fit items-center gap-3 border border-white/25 bg-white/15 px-5 py-3 text-sm font-semibold text-white transition group-hover:border-white group-hover:bg-white/30"
        >
            View more
            <svg viewBox="0 0 24 24" class="h-4 w-4 fill-current" aria-hidden="true">
                <path d="M13.2 5.8 19.4 12l-6.2 6.2-1.4-1.4 3.8-3.8H5v-2h10.6l-3.8-3.8 1.4-1.4Z"/>
            </svg>
        </a>
    </div>
</article>
