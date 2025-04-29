@extends('layouts')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3><i class="fas fa-info-circle me-2"></i>Detail Kategori</h3>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i>Back
        </a>
    </div>
    <div class="card-body">

        <div class="mb-3">
            <label class="form-label fw-bold">Nama Kategori:</label>
            <div>{{ $category->name }}</div>
        </div>

    </div>
</div>
@endsection
