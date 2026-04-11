<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ReviewsController extends Controller
{
    public function index(): View
    {
        return view('admin.reviews.index', [
            'pageTitle' => 'Customer Reviews',
            'reviews'   => Review::query()->latest()->paginate(20),
            'pending'   => Review::where('is_approved', false)->count(),
            'featured'  => Review::where('is_featured', true)->count(),
        ]);
    }

    public function create(): View
    {
        return view('admin.reviews.create', ['pageTitle' => 'Add Review']);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'reviewer_name' => ['required', 'string', 'max:150'],
            'position'      => ['nullable', 'string', 'max:150'],
            'company'       => ['nullable', 'string', 'max:150'],
            'rating'        => ['required', 'integer', 'min:1', 'max:5'],
            'content'       => ['required', 'string', 'max:2000'],
            'photo'         => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:1024'],
            'is_approved'   => ['nullable', 'boolean'],
            'is_featured'   => ['nullable', 'boolean'],
        ]);

        $validated['is_approved'] = $request->boolean('is_approved');
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['photo']       = $this->handlePhoto($request);

        Review::create($validated);

        return redirect()->route('admin.reviews.index')
            ->with('status', 'Review added successfully.');
    }

    public function edit(Review $review): View
    {
        return view('admin.reviews.edit', [
            'pageTitle' => 'Edit Review',
            'review'    => $review,
        ]);
    }

    public function update(Request $request, Review $review): RedirectResponse
    {
        $validated = $request->validate([
            'reviewer_name' => ['required', 'string', 'max:150'],
            'position'      => ['nullable', 'string', 'max:150'],
            'company'       => ['nullable', 'string', 'max:150'],
            'rating'        => ['required', 'integer', 'min:1', 'max:5'],
            'content'       => ['required', 'string', 'max:2000'],
            'photo'         => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:1024'],
            'is_approved'   => ['nullable', 'boolean'],
            'is_featured'   => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('photo')) {
            if ($review->photo) {
                Storage::disk('public')->delete($review->photo);
            }
            $validated['photo'] = $this->handlePhoto($request);
        }

        $validated['is_approved'] = $request->boolean('is_approved');
        $validated['is_featured'] = $request->boolean('is_featured');

        $review->update($validated);

        return redirect()->route('admin.reviews.index')
            ->with('status', 'Review updated successfully.');
    }

    public function destroy(Review $review): RedirectResponse
    {
        if ($review->photo) {
            Storage::disk('public')->delete($review->photo);
        }

        $review->delete();

        return redirect()->route('admin.reviews.index')
            ->with('status', 'Review deleted.');
    }

    public function approve(Review $review): RedirectResponse
    {
        $review->update(['is_approved' => ! $review->is_approved]);

        $msg = $review->is_approved ? 'Review approved.' : 'Review unapproved.';

        return back()->with('status', $msg);
    }

    public function toggleFeatured(Review $review): RedirectResponse
    {
        $review->update(['is_featured' => ! $review->is_featured]);

        $msg = $review->is_featured ? 'Review marked as featured.' : 'Review removed from featured.';

        return back()->with('status', $msg);
    }

    private function handlePhoto(Request $request): ?string
    {
        if ($request->hasFile('photo')) {
            return $request->file('photo')->store('reviews', 'public');
        }
        return null;
    }
}
