@extends('layouts')

@section('content')
<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-plus me-2"></i>Create Alumni</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('alumni.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror"
                    id="name" name="name" value="{{ old('name') }}" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="achievement" class="form-label">Achievement</label>
                <input type="text" class="form-control @error('achievement') is-invalid @enderror"
                    id="achievement" name="achievement" value="{{ old('achievement') }}" required>
                @error('achievement') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="file" class="form-control @error('image') is-invalid @enderror"
                    id="image" name="image" required>
                @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                <div class="form-text">Accepted formats: JPEG, PNG, JPG, GIF (max: 2MB)</div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('alumni.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Back
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i>Create Alumni
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
