@extends('layouts.admin')

@section('admin-content')
    <div class="space-y-8">
        <section class="rounded-lg border border-stone-200 bg-white p-8 shadow-sm">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.28em] text-[#a25f38]">Product capabilities</p>
                    <h1 class="mt-3 text-3xl font-semibold tracking-tight text-stone-950">Products in use gallery</h1>
                    <p class="mt-4 text-sm leading-7 text-stone-600">Manage the image gallery used on the public Products Capabilities page.</p>
                </div>
                <a href="{{ route('admin.home.projects-in-use.create') }}" class="rounded-sm bg-[#b86033] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#cd6e3a]">
                    Add Project
                </a>
            </div>
        </section>

        <section class="rounded-lg border border-stone-200 bg-white p-8 shadow-sm">
            @if($projectsInUse)
                <div class="space-y-4">
                    @foreach($projectsInUse as $index => $project)
                        <div class="flex items-center gap-4 rounded-lg border border-stone-200 p-4">
                            <div class="flex-shrink-0">
                                <img src="{{ $project['image'] }}" alt="{{ $project['caption'] }}" class="h-16 w-16 rounded object-cover">
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-sm font-medium text-stone-900 truncate">{{ $project['caption'] }}</h3>
                                <p class="text-sm text-stone-500">{{ $project['product'] }} • {{ $project['category'] }} • {{ $project['tag'] }}</p>
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ route('admin.home.projects-in-use.edit', $index) }}" class="rounded-sm border border-stone-300 px-3 py-1.5 text-sm font-medium text-stone-700 hover:bg-stone-50">
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('admin.home.projects-in-use.destroy', $index) }}" onsubmit="return confirm('Are you sure you want to delete this project?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-sm border border-rose-300 px-3 py-1.5 text-sm font-medium text-rose-700 hover:bg-rose-50">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <p class="text-stone-500">No projects added yet.</p>
                    <a href="{{ route('admin.home.projects-in-use.create') }}" class="mt-4 inline-block rounded-sm bg-[#b86033] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#cd6e3a]">
                        Add First Project
                    </a>
                </div>
            @endif
        </section>
    </div>
@endsection
