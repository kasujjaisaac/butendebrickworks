@extends('layouts.admin')

@section('admin-content')
    <div class="mb-6 flex flex-wrap items-start justify-between gap-3">
        <div>
            <a href="{{ route('admin.news.index') }}" class="inline-flex items-center gap-1 text-xs text-stone-400 transition hover:text-[#b86033]">
                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5"/></svg>
                Back to News
            </a>
            <h2 class="mt-1 text-xl font-bold tracking-tight text-stone-900">Write New Post</h2>
            <p class="mt-0.5 text-sm text-stone-500">Fill in the details below to publish a new article.</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.news.store') }}" enctype="multipart/form-data">
        @csrf

        @include('admin.news._form')

        <div class="mt-6 flex flex-wrap items-center justify-end gap-3 rounded-sm border border-[#e8d5c5] bg-white px-6 py-4 shadow-sm">
            <a href="{{ route('admin.news.index') }}" class="rounded-sm border border-[#d8c0ad] bg-white px-5 py-2.5 text-sm font-medium text-stone-700 transition hover:bg-stone-50">
                Cancel
            </a>
            <button type="submit" class="inline-flex items-center gap-2 rounded-sm bg-[#6e2f0e] px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#8c3d12] focus:outline-none focus:ring-2 focus:ring-[#6e2f0e] focus:ring-offset-2">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                Save Post
            </button>
        </div>
    </form>
@endsection
