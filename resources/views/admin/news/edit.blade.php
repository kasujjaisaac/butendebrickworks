@extends('layouts.admin')

@section('admin-content')
    <div class="mb-6 flex flex-wrap items-start justify-between gap-3">
        <div>
            <a href="{{ route('admin.news.index') }}" class="inline-flex items-center gap-1 text-xs text-stone-400 transition hover:text-[#b86033]">
                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5"/></svg>
                Back to News
            </a>
            <h2 class="mt-1 text-xl font-bold tracking-tight text-stone-900">Edit Post</h2>
            <p class="mt-0.5 text-sm text-stone-500">{{ $post->title }}</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.news.update', $post) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        @include('admin.news._form')

        <div class="mt-6 flex flex-wrap items-center justify-end gap-3 rounded-sm border border-[#e8d5c5] bg-white px-6 py-4 shadow-sm">
            <a href="{{ route('admin.news.index') }}" class="rounded-sm border border-[#d8c0ad] bg-white px-5 py-2.5 text-sm font-medium text-stone-700 transition hover:bg-stone-50">
                Cancel
            </a>
            <button type="submit" class="inline-flex items-center gap-2 rounded-sm bg-[#6e2f0e] px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#8c3d12] focus:outline-none focus:ring-2 focus:ring-[#6e2f0e] focus:ring-offset-2">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125"/></svg>
                Update Post
            </button>
        </div>
    </form>
@endsection
