@php
    $logoMark = collect(preg_split('/[\s&]+/', $partner['name']))
        ->filter()
        ->map(fn (string $word) => strtoupper(substr($word, 0, 1)))
        ->take(2)
        ->implode('');
    $logoPath = $partner['logo'] ?? null;
    $logoExists = $logoPath && file_exists(public_path($logoPath));
@endphp

<article class="partner-card" title="{{ $partner['name'] }}">
    <div class="partner-card__img-box">
        @if ($logoExists)
            <img
                src="{{ $logoPath }}"
                alt="{{ $partner['name'] }}"
                loading="lazy"
            >
        @else
            <div class="partner-logo-mark">
                {{ $logoMark }}
            </div>
        @endif
    </div>
</article>
