<section id="talk-to-us">
    <div class="footer-shell py-10">
        <div class="page-grid grid gap-8 xl:grid-cols-[0.9fr_1.1fr] xl:items-start">
            <div class="space-y-5">
                <div>
                    <span class="eyebrow border-white/10 bg-white/5 text-white">Talk to Us</span>
                    <h2 class="mt-5 font-display text-2xl font-semibold tracking-tight text-white">
                        {{ $talkToUsHeading ?? 'Share your project needs and get practical guidance from the Butende team.' }}
                    </h2>
                    <p class="mt-4 footer-note max-w-xl">
                        {{ $talkToUsBody ?? 'Send your project details, quantities, or general questions and the team will get back to you.' }}
                    </p>
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    <div class="footer-panel">
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-[#f0d5be]">Call us</p>
                        <div class="mt-3 space-y-2">
                            @foreach ($company['phones'] as $phone)
                                <p class="text-sm text-stone-300">{{ $phone }}</p>
                            @endforeach
                        </div>
                    </div>
                    <div class="footer-panel">
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-[#f0d5be]">Email us</p>
                        <div class="mt-3 space-y-2">
                            @foreach ($company['emails'] as $email)
                                <a href="mailto:{{ $email }}" class="block text-sm text-stone-300 transition hover:text-white">{{ $email }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div>
                @include('site.partials.talk-to-us-form')
            </div>
        </div>
    </div>
</section>
