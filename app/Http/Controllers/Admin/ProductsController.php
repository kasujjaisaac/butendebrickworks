<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BrickProduct;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductsController extends Controller
{
    public function bulkDelete(Request $request): RedirectResponse
    {
        $ids = $request->input('selected', []);
        if (!is_array($ids) || empty($ids)) {
            return redirect()->route('admin.products.index')
                ->with('error', 'No products selected for deletion.');
        }

        $products = BrickProduct::whereIn('id', $ids)->get();
        $deletedCount = 0;
        foreach ($products as $product) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $product->delete();
            $deletedCount++;
        }

        return redirect()->route('admin.products.index')
            ->with('success', $deletedCount . ' product(s) deleted.');
    }
    public const CATEGORIES = [
        'Bricks',
        'Floor Tiles',
        'Decorative Bricks',
        'Ventilators',
        'Other',
    ];

    public function index(Request $request): View
    {
        $query = BrickProduct::query()->orderBy('category')->orderBy('name');

        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->input('status') === 'active');
        }

        $products = $query->paginate(20)->withQueryString();

        return view('admin.products.index', [
            'products'   => $products,
            'categories' => self::CATEGORIES,
            'pageTitle'  => 'Products',
        ]);
    }

    public function create(): View
    {
        return view('admin.products.create', [
            'categories' => self::CATEGORIES,
            'pageTitle'  => 'Add Product',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateProduct($request);

        $validated['image'] = $this->handleImageUpload($request);

        BrickProduct::create($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product added successfully.');
    }

    public function edit(BrickProduct $product): View
    {
        return view('admin.products.edit', [
            'product'    => $product,
            'categories' => self::CATEGORIES,
            'pageTitle'  => 'Edit Product',
        ]);
    }

    public function update(Request $request, BrickProduct $product): RedirectResponse
    {
        $validated = $this->validateProduct($request, $product);

        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $this->handleImageUpload($request);
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(BrickProduct $product): RedirectResponse
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted.');
    }

    public function toggleActive(BrickProduct $product): RedirectResponse
    {
        $product->update(['is_active' => ! $product->is_active]);

        return back()->with('success', $product->is_active ? 'Product activated.' : 'Product deactivated.');
    }

    private function validateProduct(Request $request, ?BrickProduct $product = null): array
    {
        $imageRule = $product ? 'nullable' : 'nullable';

        return $request->validate([
            'name'                   => ['required', 'string', 'max:120'],
            'category'               => ['required', 'string', 'in:' . implode(',', self::CATEGORIES)],
            'description'            => ['nullable', 'string', 'max:2000'],
            'image'                  => [$imageRule, 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'weight_kg'              => ['nullable', 'numeric', 'min:0', 'max:9999'],
            'dimensions_inch'        => ['nullable', 'string', 'max:80'],
            'coverage_sqm'           => ['nullable', 'numeric', 'min:0.000001', 'max:100'],
            'is_active'              => ['boolean'],
        ]);
    }

    private function handleImageUpload(Request $request): ?string
    {
        if (! $request->hasFile('image')) {
            return null;
        }

        return $request->file('image')->store('products', 'public');
    }
}
