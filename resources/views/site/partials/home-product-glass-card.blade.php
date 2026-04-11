<a href="{{ $product['path'] }}" class="product-glass-card">

    <span class="product-glass-card__label">Clay product</span>

    <div class="product-glass-card__body">
        <h3 class="product-glass-card__title">{{ $product['name'] }}</h3>
        <p class="product-glass-card__tagline">{{ $product['tagline'] }}</p>
    </div>

    <div class="product-glass-card__footer">
        <span class="product-glass-card__cta-text">View Products</span>
        <span class="product-glass-card__arrow">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor" aria-hidden="true">
                <path d="M13.2 5.8 19.4 12l-6.2 6.2-1.4-1.4 3.8-3.8H5v-2h10.6l-3.8-3.8 1.4-1.4Z"/>
            </svg>
        </span>
    </div>

</a>

