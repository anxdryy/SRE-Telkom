@extends('layouts')

@section('content')
<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-edit me-2"></i>Edit Alumni</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3 text-center mb-3">
                <img src="{{ Storage::url($alumni->image) }}" alt="{{ $alumni->name }}"
                    class="img-fluid rounded mb-3" style="max-height: 200px;">
                <p class="text-muted">Current Image</p>
            </div>
            <div class="col-md-9">
                <form action="{{ route('alumni.update', $alumni) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                            id="name" name="name" value="{{ old('name', $alumni->name) }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="achievement" class="form-label">Achievement</label>
                        <input type="text" class="form-control @error('achievement') is-invalid @enderror"
                            id="achievement" name="achievement" value="{{ old('achievement', $alumni->achievement) }}" required>
                        @error('achievement') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror"
                            id="image" name="image">
                        @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <div class="form-text">Leave empty to keep current image.</div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('alumni.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Back
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Update Alumni
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
