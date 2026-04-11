<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuotationRequest;
use App\Models\BrickProduct;
use App\Models\Quotation;
use App\Services\BrickCalculationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class QuotationController extends Controller
{
    public function __construct(private BrickCalculationService $calculator) {}

    public function index(): View
    {
        $quotations = Quotation::with('product')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('quotations.index', compact('quotations'));
    }

    public function create(Request $request): View
    {
        $products = BrickProduct::active()->orderBy('name')->get();

        // Support pre-fill from the public calculator via ?product_id=X&sqm=Y
        $preProductId = $request->integer('product_id') ?: null;
        $preSqm       = $request->input('sqm');

        return view('quotations.create', compact('products', 'preProductId', 'preSqm'));
    }

    public function store(QuotationRequest $request): RedirectResponse
    {
        $product = BrickProduct::findOrFail($request->integer('brick_product_id'));

        $result = $this->calculator->calculateForProduct(
            (float) $request->input('square_metres'),
            $product,
        );

        $quotation = Quotation::create([
            'user_id'          => Auth::id(),
            'brick_product_id' => $product->id,
            'square_metres'    => $request->input('square_metres'),
            'bricks_required'  => $result['bricks_required'],
            'price_per_brick'  => $product->price_per_brick,
            'total_price'      => $result['total_price'],
            'status'           => 'pending',
        ]);

        return redirect()->route('quotation.show', $quotation)
            ->with('success', 'Your quotation has been generated successfully.');
    }

    public function show(Quotation $quotation): View
    {
        $this->authorizeOwner($quotation->user_id);

        $quotation->load('product');

        return view('quotations.show', compact('quotation'));
    }

    private function authorizeOwner(int $ownerId): void
    {
        abort_unless(Auth::id() === $ownerId, 403);
    }
}
