@extends('layouts')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3><i class="fas fa-info-circle me-2"></i>Detail Program</h3>
        <a href="{{ route('programs.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i>Back
        </a>
    </div>
    <div class="card-body">

        <div class="mb-3">
            <label class="form-label fw-bold">Judul Program:</label>
            <div>{{ $program->title }}</div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Kategori:</label>
            <div>{{ $program->category->name ?? '-' }}</div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Deskripsi:</label>
            <div>{{ $program->desc }}</div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Gambar:</label><br>
            @if ($program->image)
                <img src="{{ $program->image }}" alt="Program Image" width="200">
            @else
                <span class="text-muted">Tidak ada gambar</span>
            @endif
        </div>

    </div>
</div>
@endsection
