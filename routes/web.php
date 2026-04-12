<?php

use App\Http\Controllers\SiteController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminOrdersController;
use App\Http\Controllers\Admin\AdminUsersController;
use App\Http\Controllers\Admin\HomeContentController;
use App\Http\Controllers\Admin\MessagesController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\PartnersController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\QuotationsController;
use App\Http\Controllers\Admin\ReviewsController;
use App\Http\Controllers\ClientDashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\Admin\ProductsController as AdminProductsController;
use App\Support\SiteContent;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

$productSlugPattern = implode('|', array_map(
    fn (string $cat) => preg_quote(Str::slug($cat), '/'),
    AdminProductsController::CATEGORIES
));

Route::redirect('/home', '/', 301);

Route::controller(SiteController::class)->group(function () use ($productSlugPattern) {
    Route::get('/', 'home')->name('home');
    Route::get('/about', 'about')->name('about');
    Route::get('/about-us', 'about');
    Route::get('/services', 'capabilities')->name('capabilities');
    Route::get('/products-capabilities', 'capabilities');
    Route::get('/products', 'products')->name('products.index');
    Route::get('/opportunities', 'opportunities')->name('opportunities');
    Route::get('/help-center', 'faq')->name('faq');
    Route::get('/faq', 'faq');
    Route::get('/contact', 'contact')->name('contact');
    Route::post('/talk-to-us', 'storeTalkToUs')->name('talk-to-us.store');
    Route::get('/brick-calculator', 'calculator')->name('calculator');
    Route::get('/news', 'newsList')->name('news.list');
    Route::get('/news/{slug}', 'newsShow')->name('news.show');
    Route::get('/products/{slug}', 'product')->where('slug', $productSlugPattern)->name('products.category');
    Route::get('/{slug}', 'product')->where('slug', $productSlugPattern);
    Route::get('/products/{product}', 'productDetail')->where('product', '[0-9]+')->name('products.show');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', AdminDashboardController::class)->name('dashboard');
    Route::get('/home', [HomeContentController::class, 'edit'])->name('home.edit');
    Route::put('/home/company', [HomeContentController::class, 'updateCompany'])->name('home.company.update');
    Route::put('/home/stats', [HomeContentController::class, 'updateStats'])->name('home.stats.update');
    Route::put('/home/capabilities', [HomeContentController::class, 'updateCapabilities'])->name('home.capabilities.update');
    Route::put('/home/process', [HomeContentController::class, 'updateProcess'])->name('home.process.update');
    Route::put('/home/hero-slides', [HomeContentController::class, 'updateHeroSlides'])->name('home.hero-slides.update');
    Route::put('/home/testimonials', [HomeContentController::class, 'updateTestimonials'])->name('home.testimonials.update');
    Route::put('/home/partners', [HomeContentController::class, 'updatePartners'])->name('home.partners.update');

    Route::get('/messages', [MessagesController::class, 'index'])->name('messages.index');
    Route::get('/messages/{message}', [MessagesController::class, 'show'])->name('messages.show');
    Route::delete('/messages/{message}', [MessagesController::class, 'destroy'])->name('messages.destroy');
    Route::post('/messages/mark-all-read', [MessagesController::class, 'markAllRead'])->name('messages.mark-all-read');

    // Products
    Route::get('/products', [ProductsController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductsController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductsController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductsController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductsController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductsController::class, 'destroy'])->name('products.destroy');
    Route::patch('/products/{product}/toggle-active', [ProductsController::class, 'toggleActive'])->name('products.toggle-active');
    Route::post('/products/bulk-delete', [ProductsController::class, 'bulkDelete'])->name('products.bulk-delete');
    Route::post('/products/bulk-delete', [ProductsController::class, 'bulkDelete'])->name('products.bulk-delete');

    // News & Blog
    Route::get('/news', [NewsController::class, 'index'])->name('news.index');
    Route::get('/news/create', [NewsController::class, 'create'])->name('news.create');
    Route::post('/news', [NewsController::class, 'store'])->name('news.store');
    Route::get('/news/{post}/edit', [NewsController::class, 'edit'])->name('news.edit');
    Route::put('/news/{post}', [NewsController::class, 'update'])->name('news.update');
    Route::delete('/news/{post}', [NewsController::class, 'destroy'])->name('news.destroy');

    // Partners
    Route::get('/partners', [PartnersController::class, 'index'])->name('partners.index');
    Route::get('/partners/create', [PartnersController::class, 'create'])->name('partners.create');
    Route::post('/partners', [PartnersController::class, 'store'])->name('partners.store');
    Route::get('/partners/{partner}/edit', [PartnersController::class, 'edit'])->name('partners.edit');
    Route::put('/partners/{partner}', [PartnersController::class, 'update'])->name('partners.update');
    Route::delete('/partners/{partner}', [PartnersController::class, 'destroy'])->name('partners.destroy');

    // Quotations
    Route::get('/quotations', [QuotationsController::class, 'index'])->name('quotations.index');
    Route::get('/quotations/{quotation}', [QuotationsController::class, 'show'])->name('quotations.show');
    Route::post('/quotations/{quotation}/approve', [QuotationsController::class, 'approve'])->name('quotations.approve');
    Route::post('/quotations/{quotation}/reject', [QuotationsController::class, 'reject'])->name('quotations.reject');
    Route::post('/quotations/{quotation}/convert-to-order', [QuotationsController::class, 'convertToOrder'])->name('quotations.convert-to-order');
    Route::delete('/quotations/{quotation}', [QuotationsController::class, 'destroy'])->name('quotations.destroy');
    Route::post('/quotations/mark-all-read', [QuotationsController::class, 'markAllRead'])->name('quotations.mark-all-read');

    // Orders
    Route::get('/orders', [AdminOrdersController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrdersController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/status', [AdminOrdersController::class, 'updateStatus'])->name('orders.update-status');

    // Users / Clients
    Route::get('/users', [AdminUsersController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [AdminUsersController::class, 'show'])->name('users.show');

    // Reviews
    Route::get('/reviews', [ReviewsController::class, 'index'])->name('reviews.index');
    Route::get('/reviews/create', [ReviewsController::class, 'create'])->name('reviews.create');
    Route::post('/reviews', [ReviewsController::class, 'store'])->name('reviews.store');
    Route::get('/reviews/{review}/edit', [ReviewsController::class, 'edit'])->name('reviews.edit');
    Route::put('/reviews/{review}', [ReviewsController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [ReviewsController::class, 'destroy'])->name('reviews.destroy');
    Route::patch('/reviews/{review}/approve', [ReviewsController::class, 'approve'])->name('reviews.approve');
    Route::patch('/reviews/{review}/featured', [ReviewsController::class, 'toggleFeatured'])->name('reviews.featured');
});

Route::get('/dashboard', function () {
    return auth()->user()?->isAdmin()
        ? redirect()->route('admin.dashboard')
        : redirect()->route('portal.dashboard');
})->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/portal', ClientDashboardController::class)->name('portal.dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Quotation routes
    Route::get('/my-quotations', [QuotationController::class, 'index'])->name('quotation.index');
    Route::get('/get-quotation', [QuotationController::class, 'create'])->name('quotation.create');
    Route::post('/quotation', [QuotationController::class, 'store'])->name('quotation.store');
    Route::get('/quotation/{quotation}', [QuotationController::class, 'show'])->name('quotation.show');

    // Order routes
    Route::post('/order', [OrderController::class, 'store'])->name('orders.store');
    Route::post('/order/direct', [OrderController::class, 'storeDirect'])->name('orders.storeDirect');
    Route::get('/my-orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

    // Tracking route
    Route::get('/tracking/{order}', [TrackingController::class, 'show'])->name('orders.tracking');
});

require __DIR__.'/auth.php';
