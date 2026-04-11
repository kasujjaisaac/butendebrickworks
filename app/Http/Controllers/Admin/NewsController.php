<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsPost;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(): View
    {
        return view('admin.news.index', [
            'pageTitle' => 'News & Blog',
            'posts'     => NewsPost::query()->latest()->paginate(20),
        ]);
    }

    public function create(): View
    {
        return view('admin.news.create', ['pageTitle' => 'New Post']);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatePost($request);
        $validated['image'] = $this->handleImage($request);
        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_published'] = $request->boolean('is_published');
        $validated['published_at'] = $validated['is_published'] ? now() : null;

        NewsPost::create($validated);

        return redirect()->route('admin.news.index')
            ->with('status', 'Post created successfully.');
    }

    public function edit(NewsPost $post): View
    {
        return view('admin.news.edit', [
            'pageTitle' => 'Edit Post',
            'post'      => $post,
        ]);
    }

    public function update(Request $request, NewsPost $post): RedirectResponse
    {
        $validated = $this->validatePost($request);

        if ($request->hasFile('image')) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $validated['image'] = $this->handleImage($request);
        }

        $validated['is_published'] = $request->boolean('is_published');
        if ($validated['is_published'] && ! $post->is_published) {
            $validated['published_at'] = now();
        }

        $post->update($validated);

        return redirect()->route('admin.news.index')
            ->with('status', 'Post updated successfully.');
    }

    public function destroy(NewsPost $post): RedirectResponse
    {
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return redirect()->route('admin.news.index')
            ->with('status', 'Post deleted.');
    }

    private function validatePost(Request $request): array
    {
        return $request->validate([
            'title'    => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'in:News,Publication,Guide,Announcement,Design,Industry'],
            'excerpt'  => ['nullable', 'string', 'max:500'],
            'content'  => ['required', 'string'],
            'image'    => ['nullable', 'image', 'max:2048'],
        ]);
    }

    private function handleImage(Request $request): ?string
    {
        if ($request->hasFile('image')) {
            return $request->file('image')->store('news', 'public');
        }
        return null;
    }
}
