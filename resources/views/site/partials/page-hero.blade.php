<section class="pt-6 lg:pt-8">
    <div class="hero-shell py-10 md:py-12">
        <div class="page-grid">
            <div class="relative grid gap-8 lg:grid-cols-[1.1fr_0.9fr] lg:items-center">
                <div>
                    <span class="eyebrow-light">{{ $eyebrow }}</span>
                    <h1 class="mt-6 max-w-3xl font-display text-4xl font-semibold tracking-tight text-stone-950 md:text-5xl lg:text-6xl">
                        {{ $title }}
                    </h1>
                    <p class="mt-5 max-w-2xl text-base leading-8 text-stone-700 md:text-lg">
                        {{ $lede }}
                    </p>

                    @if (! empty($actions ?? []))
                        <div class="mt-8 flex flex-wrap gap-3">
                            @foreach ($actions as $action)
                                <a href="{{ $action['path'] }}" class="{{ ($action['style'] ?? 'primary') === 'secondary' ? 'cta-secondary-dark' : 'cta-primary-dark' }}">
                                    {{ $action['label'] }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="grid gap-4">
                    <div class="hero-floating-card">
                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-[#b86033]">Quick overview</p>
                        <div class="mt-4 grid gap-3">
                            @foreach (($highlights ?? []) as $highlight)
                                <div class="rounded-sm border border-[#ead3c1] bg-white/80 px-4 py-3 text-sm text-stone-800">
                                    {{ $highlight }}
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="rounded-sm border border-[#b86033]/20 bg-[#b86033] p-6 text-white shadow-md">
                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-white/80">Need help choosing?</p>
                        <p class="mt-4 text-lg font-semibold text-white">Speak with the Butende team about products, quantity, and project fit.</p>
                        <div class="mt-5 space-y-2 text-sm text-white/80">
                            <p>{{ $company['phones'][0] }}</p>
                            <p>{{ $company['emails'][0] }}</p>
                            <p>{{ $company['hours'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
