@extends('layouts')

@section('content')
<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-edit me-2"></i>Edit Department</h3>
    </div>
    <div class="card-body">
        <div class="row">
            {{-- Current Image Preview --}}
            <div class="col-md-3 text-center mb-3">
                <img src="{{ Storage::url($department->image) }}" alt="{{ $department->name }}" class="img-fluid rounded mb-3" style="max-height: 200px;">
                <p class="text-muted">Current Image</p>
                @if($department->logo)
                    <img src="{{ Storage::url($department->logo) }}" alt="Logo of {{ $department->name }}" class="img-fluid rounded mt-3" style="max-height: 100px;">
                    <p class="text-muted">Current Logo</p>
                @endif
            </div>

            <div class="col-md-9">
                <form action="{{ route('departments.update', $department) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Department Name --}}
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" 
                               value="{{ old('name', $department->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <input type="text" class="form-control @error('description') is-invalid @enderror" id="description" 
                               name="description" value="{{ old('description', $department->description) }}" required>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Profile Image --}}
                    <div class="mb-3">
                        <label for="image" class="form-label">Profile Image</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Leave empty to keep current image. Accepted formats: JPEG, PNG, JPG, GIF (max: 2MB)</div>
                    </div>

                    {{-- Department Logo --}}
                    <div class="mb-3">
                        <label for="logo" class="form-label">Department Logo</label>
                        <input type="file" class="form-control @error('logo') is-invalid @enderror" id="logo" name="logo">
                        @error('logo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Leave empty to keep current logo. Accepted formats: JPEG, PNG, JPG, GIF (max: 2MB)</div>
                    </div>

                    {{-- Buttons --}}
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('departments.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Back
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Update Department
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
