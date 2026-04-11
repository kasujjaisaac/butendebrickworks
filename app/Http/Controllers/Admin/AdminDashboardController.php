<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BrickProduct;
use App\Models\ContactMessage;
use App\Models\NewsPost;
use App\Models\Order;
use App\Models\Quotation;
use App\Models\Review;
use App\Models\User;
use App\Support\EditableSiteContent;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function __invoke(): View
    {
        // ── Messages ─────────────────────────────────────────────────────
        $totalMessages  = ContactMessage::query()->count();
        $unreadMessages = ContactMessage::query()->unread()->count();
        $readMessages   = $totalMessages - $unreadMessages;
        $lastMessageAt  = ContactMessage::query()->latest()->value('created_at');
        $todayMessages  = ContactMessage::query()->whereDate('created_at', today())->count();
        $weekMessages   = ContactMessage::query()->whereBetween('created_at', [now()->startOfWeek(), now()])->count();
        $monthMessages  = ContactMessage::query()->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count();

        // ── Quotations ────────────────────────────────────────────────────
        $totalQuotations   = Quotation::query()->count();
        $pendingQuotations = Quotation::query()->where('status', 'pending')->count();
        $approvedQuotations = Quotation::query()->where('status', 'approved')->count();
        $rejectedQuotations = Quotation::query()->where('status', 'rejected')->count();
        $quotationThisMonth = Quotation::query()
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // ── Orders ────────────────────────────────────────────────────────
        $totalOrders    = Order::query()->count();
        $pendingOrders  = Order::query()->where('order_status', 'pending')->count();
        $activeOrders   = Order::query()->whereIn('order_status', ['confirmed', 'in_production', 'ready'])->count();
        $deliveredOrders = Order::query()->where('order_status', 'delivered')->count();
        $revenueAllTime = Order::query()->sum('total_amount');
        $revenueThisMonth = Order::query()
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_amount');

        // ── Users ─────────────────────────────────────────────────────────
        $totalClients  = User::query()->where('is_admin', false)->count();
        $newClientsWeek = User::query()
            ->where('is_admin', false)
            ->whereBetween('created_at', [now()->startOfWeek(), now()])
            ->count();

        // ── Products ─────────────────────────────────────────────────────
        $totalProducts    = BrickProduct::query()->count();
        $activeProducts   = BrickProduct::query()->where('is_active', true)->count();
        $productFamilies  = BrickProduct::query()->distinct()->count('category');
        $productByCategory = BrickProduct::query()
            ->select('category', DB::raw('count(*) as total'))
            ->groupBy('category')
            ->orderByDesc('total')
            ->get();

        // ── Reviews ───────────────────────────────────────────────────────
        $totalReviews    = Review::query()->count();
        $pendingReviews  = Review::query()->where('is_approved', false)->count();

        // ── News Posts ────────────────────────────────────────────────────
        $totalNews     = NewsPost::query()->count();
        $publishedNews = NewsPost::query()->where('is_published', true)->count();
        $draftNews     = $totalNews - $publishedNews;

        // ── Partners (from site content) ──────────────────────────────────
        $partners      = EditableSiteContent::partners();
        $partnerCount  = count($partners);
        $supplierCount = collect($partners)->filter(fn($p) => str_contains(strtolower($p['type'] ?? ''), 'supply'))->count();
        $clientCount   = $totalClients;
        $reviewCount   = $totalReviews;

        // ── Company info ──────────────────────────────────────────────────
        $company = EditableSiteContent::company();

        // ── Product breakdown (formatted for view) ────────────────────────
        $productBreakdown = $productByCategory->map(fn($item) => [
            'slug'  => $item->category,
            'name'  => ucwords(str_replace('-', ' ', $item->category)),
            'count' => $item->total,
        ]);

        // ── Chart: orders per day last 30 days ────────────────────────────
        $ordersLast30 = Order::query()
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->where('created_at', '>=', now()->subDays(29)->startOfDay())
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date');

        $chartDates  = [];
        $chartOrders = [];
        for ($i = 29; $i >= 0; $i--) {
            $d = now()->subDays($i)->format('Y-m-d');
            $chartDates[]  = now()->subDays($i)->format('M d');
            $chartOrders[] = $ordersLast30[$d] ?? 0;
        }

        // ── Chart: quotations per day last 30 days ────────────────────────
        $quotesLast30 = Quotation::query()
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->where('created_at', '>=', now()->subDays(29)->startOfDay())
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date');

        $chartQuotes = [];
        for ($i = 29; $i >= 0; $i--) {
            $d = now()->subDays($i)->format('Y-m-d');
            $chartQuotes[] = $quotesLast30[$d] ?? 0;
        }

        // ── Recent activity (latest across quotations, orders, messages) ──
        $recentQuotations = Quotation::with(['user', 'product'])
            ->latest()->take(4)->get();
        $recentOrders = Order::with(['user'])
            ->latest()->take(4)->get();

        // ── Top products by quotation count ──────────────────────────────
        $topProducts = BrickProduct::query()
            ->withCount('quotations')
            ->orderByDesc('quotations_count')
            ->take(5)
            ->get();

        return view('admin.dashboard', [
            'pageTitle' => 'Dashboard',
            // messages
            'totalMessages'    => $totalMessages,
            'unreadMessages'   => $unreadMessages,
            'readMessages'     => $readMessages,
            'lastMessageAt'    => $lastMessageAt ? Carbon::parse($lastMessageAt) : null,
            'todayMessages'    => $todayMessages,
            'weekMessages'     => $weekMessages,
            'monthMessages'    => $monthMessages,
            // quotations
            'totalQuotations'    => $totalQuotations,
            'pendingQuotations'  => $pendingQuotations,
            'approvedQuotations' => $approvedQuotations,
            'rejectedQuotations' => $rejectedQuotations,
            'quotationThisMonth' => $quotationThisMonth,
            // orders
            'totalOrders'      => $totalOrders,
            'pendingOrders'    => $pendingOrders,
            'activeOrders'     => $activeOrders,
            'deliveredOrders'  => $deliveredOrders,
            'revenueAllTime'   => $revenueAllTime,
            'revenueThisMonth' => $revenueThisMonth,
            // users
            'totalClients'    => $totalClients,
            'newClientsWeek'  => $newClientsWeek,
            // products
            'totalProducts'     => $totalProducts,
            'activeProducts'    => $activeProducts,
            'productFamilies'   => $productFamilies,
            'productByCategory' => $productByCategory,
            'productBreakdown'  => $productBreakdown,
            'topProducts'       => $topProducts,
            // reviews
            'totalReviews'   => $totalReviews,
            'pendingReviews' => $pendingReviews,
            'reviewCount'    => $reviewCount,
            // news
            'totalNews'     => $totalNews,
            'publishedNews' => $publishedNews,
            'draftNews'     => $draftNews,
            // partners
            'partnerCount'  => $partnerCount,
            'supplierCount' => $supplierCount,
            'clientCount'   => $clientCount,
            // company
            'company'       => $company,
            // content
            // charts
            'chartDates'     => $chartDates,
            'chartOrders'    => $chartOrders,
            'chartQuotes'    => $chartQuotes,
            // activity
            'recentQuotations' => $recentQuotations,
            'recentOrders'     => $recentOrders,
        ]);
    }
}
