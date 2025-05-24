@extends('layouts')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3><i class="fas fa-tag me-2"></i>Category Details</h3>
        <div>
            <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning me-2">
                <i class="fas fa-edit me-1"></i>Edit
            </a>
            <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i>Back
            </a>
        </div>
    </div>
    <div class="card-body">
        <h4 class="card-title">{{ $category->name }}</h4>
        <p class="text-muted">Created at: {{ $category->created_at->format('Y-m-d H:i') }}</p>
        <p class="text-muted">Updated at: {{ $category->updated_at->format('Y-m-d H:i') }}</p>
    </div>
</div>
@endsection
