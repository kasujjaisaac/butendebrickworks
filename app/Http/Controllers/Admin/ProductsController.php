<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BrickProduct;
use App\Models\ProductCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProductsController extends Controller
{
    public function bulkDelete(Request $request): RedirectResponse
    {
        $ids = $request->input('selected_products', []);
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
        $query = BrickProduct::query()
            ->with('categoryModel')
            ->orderByRaw('category_id is null')
            ->orderBy('category_id')
            ->orderBy('name');

        if ($request->filled('category')) {
            $this->applyCategoryFilter($query, $request->input('category'));
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->input('status') === 'active');
        }

        $products = $query->paginate(20)->withQueryString();

        return view('admin.products.index', [
            'products'   => $products,
            'categories' => $this->availableCategories(),
            'pageTitle'  => 'Products',
        ]);
    }

    public function create(): View
    {
        return view('admin.products.create', [
            'categories' => $this->availableCategories(),
            'pageTitle'  => 'Add Product',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateProduct($request);
        $validated = $this->normalizeProductData($validated);

        $validated['image'] = $this->handleImageUpload($request);

        BrickProduct::create($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product added successfully.');
    }

    public function edit(BrickProduct $product): View
    {
        return view('admin.products.edit', [
            'product'    => $product,
            'categories' => $this->availableCategories(),
            'pageTitle'  => 'Edit Product',
        ]);
    }

    public function update(Request $request, BrickProduct $product): RedirectResponse
    {
        $validated = $this->validateProduct($request, $product);
        $validated = $this->normalizeProductData($validated);

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
            'category'               => ['required', 'string', Rule::in($this->availableCategories())],
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

    private function normalizeProductData(array $validated): array
    {
        $validated['category_id'] = ProductCategory::query()
            ->firstOrCreate(['name' => $validated['category']])
            ->id;

        unset($validated['category']);

        return $validated;
    }

    private function availableCategories(): array
    {
        $categories = ProductCategory::query()->pluck('name');

        if ($categories->isEmpty()) {
            return self::CATEGORIES;
        }

        return $categories
            ->sortBy(function (string $name) {
                $index = array_search($name, self::CATEGORIES, true);

                return $index === false ? PHP_INT_MAX : $index;
            })
            ->values()
            ->all();
    }

    private function applyCategoryFilter($query, string $category): void
    {
        $query->where(function ($productQuery) use ($category) {
            $productQuery->whereHas('categoryModel', function ($categoryQuery) use ($category) {
                $categoryQuery->where('name', $category);
            });

            if ($category === 'Other') {
                $productQuery->orWhereNull('category_id');
            }
        });
    }
}
