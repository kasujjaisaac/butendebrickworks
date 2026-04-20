<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\ProductsController as AdminProductsController;
use App\Models\ContactMessage;
use App\Models\BrickProduct;
use App\Models\NewsPost;
use App\Models\Review;
use App\Support\EditableSiteContent;
use App\Support\SiteContent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SiteController extends Controller
{
    public function home()
    {
        // DB products for the hero calculator — grouped by category, only active
        $calcProducts = BrickProduct::active()
            ->orderBy('category_id')
            ->orderBy('name')
            ->get(['id', 'name', 'category_id', 'coverage_sqm', 'bricks_per_square_metre', 'weight_kg', 'price_per_brick']);

        $calcCategories = AdminProductsController::CATEGORIES;

        // Use featured approved DB reviews for carousel; fall back to static if none
        $dbReviews = Review::approved()->where('is_featured', true)->latest()->get();
        if ($dbReviews->isEmpty()) {
            $dbReviews = Review::approved()->latest()->take(6)->get();
        }
        $testimonials = $dbReviews->isNotEmpty()
            ? $dbReviews
            : EditableSiteContent::testimonials();

        return view('site.home', $this->sharedData([
            'title' => 'Butende Brick Works',
            'metaDescription' => SiteContent::company()['meta_description'],
            'blogPosts' => NewsPost::published()->latest('published_at')->take(4)->get(),
            'calcProducts'    => $calcProducts,
            'calcCategories'  => $calcCategories,
            'testimonials'    => $testimonials,
        ]));
    }

    public function about()
    {
        return view('site.about', $this->sharedData([
            'title' => 'About Us | Butende Brick Works',
            'metaDescription' => 'Learn about the mission, vision, and history behind Butende Brick Works and its fired clay manufacturing legacy since 1967.',
            'talkToUsHeading' => 'Ready to build with us?',
            'talkToUsBody' => 'Whether you are a developer, architect, or builder — tell us about your project and we will help you find the right product.',
        ]));
    }

    public function capabilities()
    {
        return view('site.capabilities', $this->sharedData([
            'title' => 'Products Capabilities | Butende Brick Works',
            'metaDescription' => 'Explore Butende Brick Works capabilities in fired clay production, custom profiles, project guidance, and institutional supply.',
            'talkToUsHeading' => 'Have a project in mind?',
            'talkToUsBody' => 'Tell us about your construction requirements and we will help you find the right product and supply arrangement.',
        ]));
    }

    public function products()
    {
        $products = BrickProduct::active()
            ->with('categoryModel')
            ->orderByRaw('category_id is null')
            ->orderBy('category_id')
            ->orderBy('name')
            ->get();

        $grouped = $products->groupBy(fn (BrickProduct $product) => $product->category ?? 'Other');
        $categoryShowcase = $grouped
            ->map(fn ($items, $category) => $this->categoryMetaFor($category, $items))
            ->values();

        return view('site.products.index', $this->sharedData([
            'title' => 'Products | Butende Brick Works',
            'metaDescription' => 'Browse bricks, floor tiles, decorative bricks, ventilators, and other fired clay products from Butende Brick Works.',
            'products' => $products,
            'grouped'  => $grouped,
            'categoryShowcase' => $categoryShowcase,
            'talkToUsHeading' => 'Interested in our products?',
            'talkToUsBody' => 'Request product samples, technical specifications, or a quote for any of our fired clay products.',
        ]));
    }

    public function productDetail(BrickProduct $product)
    {
        abort_if(! $product->is_active, 404);

        $product->loadMissing('categoryModel');

        $related = $this->productsForCategory($product->category ?? 'Other')
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('site.products.show', $this->sharedData([
            'title'           => $product->name.' | Butende Brick Works',
            'metaDescription' => $product->description ?? 'View details for '.$product->name.' from Butende Brick Works.',
            'product'         => $product,
            'related'         => $related,
            'talkToUsHeading' => 'Get a quote for '.$product->name,
            'talkToUsBody'    => 'Tell us your project quantities and we will prepare a tailored quotation for this product.',
        ]));
    }

    public function product(string $slug)
    {
        $categoryMap = $this->categorySlugMap();

        abort_unless(isset($categoryMap[$slug]), 404);

        $categoryName     = $categoryMap[$slug];
        $categoryProducts = $this->productsForCategory($categoryName)
            ->orderBy('name')
            ->get();
        $categoryMeta = $this->categoryMetaFor($categoryName, $categoryProducts);

        return view('site.products.category', $this->sharedData([
            'title'            => $categoryName.' | Butende Brick Works',
            'metaDescription'  => 'Browse our '.$categoryName.' range — fired clay products from Butende Brick Works.',
            'categoryProducts' => $categoryProducts,
            'categoryName'     => $categoryName,
            'categorySlug'     => $slug,
            'categoryMeta'     => $categoryMeta,
            'talkToUsHeading'  => 'Interested in our '.$categoryName.'?',
            'talkToUsBody'     => 'Tell us your project requirements and we will help you find the right product.',
        ]));
    }

    public function opportunities()
    {
        return view('site.opportunities', $this->sharedData([
            'title' => 'Opportunities | Butende Brick Works',
            'metaDescription' => 'See current job, training, partnership, and supply opportunities connected to Butende Brick Works.',
            'talkToUsHeading' => 'See an opportunity you would like to pursue?',
            'talkToUsBody' => 'Reach out to discuss supply, partnership, or employment opportunities with the Butende team.',
        ]));
    }

    public function faq()
    {
        return view('site.faq', $this->sharedData([
            'title' => 'Frequently Asked Questions | Butende Brick Works',
            'metaDescription' => 'Answers to common questions about products, ordering, location, and opportunities at Butende Brick Works.',
            'talkToUsHeading' => 'Still have questions?',
            'talkToUsBody' => 'If you did not find what you were looking for, send us a message and we will get back to you directly.',
        ]));
    }

    public function contact()
    {
        return view('site.contact', $this->sharedData([
            'title' => 'Contact | Butende Brick Works',
            'metaDescription' => 'Contact Butende Brick Works by phone, email, or visit the factory in Matanga, Masaka, Uganda.',
            'talkToUsHeading' => 'Send us a message',
            'talkToUsBody' => 'Fill in the form and the team will respond as quickly as possible.',
        ]));
    }

    public function calculator()
    {
        $products = BrickProduct::active()->with('categoryModel')->orderBy('category_id')->orderBy('name')->get();
        
        $productsJson = $products->map(fn ($product) => [
            'id' => $product->id,
            'name' => $product->name,
            'category' => $product->category ?? 'Other',
            'coverage' => (float) $product->coverage,
            'bricks_per_square_metre' => (int) $product->units_per_square_metre,
        ])->values();

        return view('site.calculator', $this->sharedData([
            'title' => 'Products Calculator | Butende Brick Works',
            'metaDescription' => 'Use our free products calculator to estimate how many bricks or tiles you need for your project and get an instant cost estimate.',
            'products' => $products,
            'productsJson' => $productsJson,
        ]));
    }

    public function storeTalkToUs(Request $request): RedirectResponse
    {
        if ($blockedResponse = $this->blockSuspiciousTalkToUsSubmission($request)) {
            return $blockedResponse;
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:160'],
            'phone' => ['nullable', 'string', 'max:40'],
            'source_url' => ['nullable', 'string', 'max:255'],
            'enquiry_type' => ['nullable', 'string', 'max:40'],
            'website' => ['nullable', 'string', 'max:255'],
            'product_interest' => ['nullable', 'string', 'max:120'],
            'project_type' => ['nullable', 'string', 'max:120'],
            'quantity' => ['nullable', 'string', 'max:120'],
            'details' => ['nullable', 'string', 'max:5000'],
        ]);

        $isQuoteRequest = ($validated['enquiry_type'] ?? null) === 'quote';

        if ($isQuoteRequest) {
            $quoteFields = $request->validate([
                'product_interest' => ['required', 'string', 'max:120'],
                'project_type' => ['required', 'string', 'max:120'],
                'quantity' => ['required', 'string', 'max:120'],
                'details' => ['nullable', 'string', 'max:5000'],
            ]);

            $message = collect([
                'Request type: Quote request',
                'Product interest: '.$quoteFields['product_interest'],
                'Project type: '.$quoteFields['project_type'],
                'Quantity or scope: '.$quoteFields['quantity'],
                'Phone: '.($validated['phone'] ?: 'Not provided'),
                'Additional details: '.($quoteFields['details'] ?: 'None provided'),
            ])->implode("\n");

            ContactMessage::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'subject' => 'Request for Quote',
                'message' => $message,
                'source_url' => $validated['source_url'] ?? null,
            ]);
        } else {
            $genericFields = $request->validate([
                'subject' => ['required', 'string', 'max:160'],
                'message' => ['required', 'string', 'min:10', 'max:5000'],
            ]);

            ContactMessage::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'subject' => $genericFields['subject'],
                'message' => $genericFields['message'],
                'source_url' => $validated['source_url'] ?? null,
            ]);
        }

        return back()
            ->with('talk_to_us_success', 'Thanks for reaching out. We have received your message and will get back to you soon.');
    }

    private function blockSuspiciousTalkToUsSubmission(Request $request): ?RedirectResponse
    {
        $honeypotField = config('monitoring.talk_to_us.honeypot_field', 'website');

        if (blank($request->input($honeypotField))) {
            return null;
        }

        Log::channel('monitoring')->warning('Talk-to-us submission blocked by honeypot.', [
            'request_id' => $request->attributes->get('request_id'),
            'source_url' => $request->input('source_url'),
            'enquiry_type' => $request->input('enquiry_type'),
            'request_ip' => $request->ip(),
            'user_agent' => Str::limit((string) $request->userAgent(), 180),
        ]);

        return back()->with('talk_to_us_success', 'Thanks for reaching out. We have received your message and will get back to you soon.');
    }

    public function newsList()
    {
        $activeCategory = request('category');

        $query = NewsPost::published()->latest('published_at');

        if ($activeCategory) {
            $query->where('category', $activeCategory);
        }

        $posts = $query->paginate(12)->withQueryString();

        $categories = NewsPost::published()
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return view('site.news.index', $this->sharedData([
            'title'           => 'News & Publications | Butende Brick Works',
            'metaDescription' => 'Read the latest news, publications, guides and industry insights from Butende Brick Works.',
            'posts'           => $posts,
            'categories'      => $categories,
            'activeCategory'  => $activeCategory,
            'talkToUsHeading' => 'Want to stay informed?',
            'talkToUsBody'    => 'Let us know what topics interest you and we will keep you updated with relevant news and publications.',
        ]));
    }

    public function newsShow(string $slug)
    {
        $post = NewsPost::published()->where('slug', $slug)->firstOrFail();

        $related = NewsPost::published()
            ->where('id', '!=', $post->id)
            ->where('category', $post->category)
            ->latest('published_at')
            ->take(3)
            ->get();

        if ($related->count() < 3) {
            $related = NewsPost::published()
                ->where('id', '!=', $post->id)
                ->latest('published_at')
                ->take(3)
                ->get();
        }

        return view('site.news.show', $this->sharedData([
            'title'           => $post->title.' | Butende Brick Works',
            'metaDescription' => $post->excerpt ?? substr(strip_tags($post->content), 0, 160),
            'post'            => $post,
            'related'         => $related,
        ]));
    }

    private function categorySlugMap(): array
    {
        return [
            'bricks' => 'Bricks',
            'floor-tiles' => 'Floor Tiles',
            'ventilators' => 'Ventilators',
            'decorative-bricks' => 'Decorative Bricks',
            'other' => 'Other',
        ];
    }

    private function categoryContentLibrary(): array
    {
        $products = SiteContent::products();

        return [
            'bricks' => $products['bricks'],
            'floor-tiles' => $products['floor-tiles'],
            'ventilators' => $products['ventilators'],
            'decorative-bricks' => $products['decorative-bricks'],
            'other' => $products['other-products'],
        ];
    }

    private function slugForCategory(string $categoryName): string
    {
        return array_search($categoryName, $this->categorySlugMap(), true) ?: Str::slug($categoryName);
    }

    private function categoryMetaFor(string $categoryName, $products = null): array
    {
        $items = collect($products ?? []);
        $slug = $this->slugForCategory($categoryName);
        $library = $this->categoryContentLibrary()[$slug] ?? [];
        $firstProduct = $items->first();

        $imageUrl = $firstProduct?->image
            ? Storage::disk('public')->url($firstProduct->image)
            : ($library['image'] ?? null);

        return [
            'slug' => $slug,
            'name' => $categoryName,
            'path' => '/products/'.$slug,
            'tagline' => $library['tagline'] ?? Str::limit($firstProduct?->description ?? $categoryName.' products for long-life construction work.', 88),
            'summary' => $library['summary'] ?? Str::limit($firstProduct?->description ?? 'Browse our fired clay '.$categoryName.' range for residential, institutional, and commercial projects.', 190),
            'image' => $imageUrl,
            'benefits' => $library['benefits'] ?? [],
            'applications' => $library['applications'] ?? [],
            'count' => $items->count(),
            'featuredProductName' => $firstProduct?->name,
        ];
    }

    private function productCategories(): array
    {
        return BrickProduct::active()
            ->with('categoryModel')
            ->orderByRaw('category_id is null')
            ->orderBy('category_id')
            ->orderBy('name')
            ->get(['id', 'name', 'category_id', 'description', 'image'])
            ->groupBy(fn($product) => $product->category ?? 'Other')
            ->map(function ($items, $category) {
                return $this->categoryMetaFor($category, $items);
            })
            ->values()
            ->toArray();
    }

    private function productsForCategory(string $categoryName)
    {
        return BrickProduct::active()
            ->with('categoryModel')
            ->where(function ($query) use ($categoryName) {
                $query->whereHas('categoryModel', function ($categoryQuery) use ($categoryName) {
                    $categoryQuery->where('name', $categoryName);
                });

                if ($categoryName === 'Other') {
                    $query->orWhereNull('category_id');
                }
            });
    }

    private function sharedData(array $overrides = []): array
    {
        return array_merge([
            'company' => EditableSiteContent::company(),
            'stats' => EditableSiteContent::stats(),
            'navigation' => SiteContent::navigation(),
            'capabilities' => EditableSiteContent::capabilities(),
            'process' => EditableSiteContent::process(),
            'productCategories' => $this->productCategories(),
            'partners' => EditableSiteContent::partners(),
            'sectors' => SiteContent::sectors(),
            'testimonials' => EditableSiteContent::testimonials(),
            'faqs' => SiteContent::faqs(),
            'opportunities' => SiteContent::opportunities(),
            'heroSlides' => EditableSiteContent::heroSlides(),
            'projectsInUse' => EditableSiteContent::projectsInUse(),
        ], $overrides);
    }
}
