
@php
    use Illuminate\Support\Facades\Storage;
    $showCategory = $showCategory ?? false;
    $imageUrl = $product->image ? asset('images/products/' . basename($product->image)) : null;
    $priceLabel = $product->price_per_brick
        ? 'UGX '.number_format($product->price_per_brick, 0)
        : 'Quote on request';
@endphp

<article class="group flex h-full flex-col overflow-hidden border border-stone-200 bg-white transition duration-200 hover:border-[#b86033]/35 hover:shadow-[0_12px_26px_-18px_rgba(120,53,15,0.38)]">
    <a href="{{ route('products.show', $product) }}" class="relative block border-b border-stone-100 bg-white">
        <div class="flex aspect-square items-center justify-center overflow-hidden p-3 sm:p-4">
            @if ($imageUrl)
                <img
                    src="{{ $imageUrl }}"
                    alt="{{ $product->name }}"
                    class="max-h-full w-auto object-contain transition duration-300 group-hover:scale-[1.03]"
                >
            @else
                <div class="flex h-full w-full items-center justify-center border border-dashed border-stone-300 bg-stone-50 text-stone-300">
                    <svg class="h-9 w-9" fill="none" stroke="currentColor" stroke-width="1.2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"/></svg>
                </div>
            @endif
        </div>

        <div class="pointer-events-none absolute inset-x-0 bottom-0 hidden translate-y-2 justify-center bg-[linear-gradient(180deg,rgba(255,255,255,0),rgba(28,25,23,0.4))] px-3 pb-3 pt-10 opacity-0 transition duration-200 md:flex md:group-hover:translate-y-0 md:group-hover:opacity-100">
            <span class="inline-flex items-center gap-2 border border-stone-200 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-[0.14em] text-stone-900">
                Read more
                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
            </span>
        </div>
    </a>

    <div class="flex flex-1 flex-col px-3 py-3 sm:px-4 sm:py-4">
        <h3 class="text-center text-xs font-semibold leading-5 text-stone-950 sm:text-sm mt-2 mb-3">
            {{ $product->name }}
        </h3>
        <table class="w-full text-xs border-t border-stone-100">
            <tr class="text-stone-400">
                <th class="py-1 px-2 font-semibold text-center border-r border-stone-200">Weight (kg)</th>
                <th class="py-1 px-2 font-semibold text-center border-r border-stone-200">Units per m²</th>
                <th class="py-1 px-2 font-semibold text-center">Dimensions (inch)</th>
            </tr>
            <tr class="text-stone-900">
                <td class="py-1 px-2 text-center border-r border-stone-200">
                    @if ($product->weight_kg !== null)
                        {{ rtrim(rtrim(number_format($product->weight_kg, 1, '.', ''), '0'), '.') }} kg
                    @else
                        —
                    @endif
                </td>
                <td class="py-1 px-2 text-center border-r border-stone-200">
                    @if ($product->units_per_square_metre > 0)
                        {{ $product->units_per_square_metre }}
                    @else
                        —
                    @endif
                </td>
                <td class="py-1 px-2 text-center">
                    @if (!empty($product->dimensions_inch))
                        {!! preg_replace([
                            '/1\/2/',
                            '/1\/4/',
                            '/3\/4/',
                            '/1\/8/',
                            '/3\/8/',
                            '/5\/8/',
                            '/7\/8/'
                        ], [
                            '&frac12;',
                            '&frac14;',
                            '&frac34;',
                            '⅛',
                            '⅜',
                            '⅝',
                            '⅞'
                        ], e($product->dimensions_inch)) !!}
                    @else
                        —
                    @endif
                </td>
            </tr>
        </table>
    </div>
</article>
