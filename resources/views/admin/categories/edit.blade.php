@extends('admin.layout')
@section('content')
<h1>Edit Product Category</h1>
<form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ $category->name }}" required>
    </div>
    <div class="mb-3">
        <label for="image" class="form-label">Image</label>
        @if ($category->image)
            <div class="mb-2">
                <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" width="120">
            </div>
        @endif
        <input type="file" name="image" id="image" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
</form>
@endsection
