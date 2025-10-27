@extends('layouts')

@section('content')
<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-plus me-2"></i>Create Department</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('departments.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Department Name --}}
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input 
                    type="text" 
                    class="form-control @error('name') is-invalid @enderror" 
                    id="name" 
                    name="name" 
                    value="{{ old('name') }}" 
                    required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Department Description --}}
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <input 
                    type="text" 
                    class="form-control @error('description') is-invalid @enderror" 
                    id="description" 
                    name="description" 
                    value="{{ old('description') }}" 
                    required>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Background Image --}}
            <div class="mb-3">
                <label for="image" class="form-label">Background Image</label>
                <input 
                    type="file" 
                    class="form-control @error('image') is-invalid @enderror" 
                    id="image" 
                    name="image" 
                    required>
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">Accepted formats: JPEG, PNG, JPG, GIF (max: 2MB)</div>
            </div>

            {{-- Logo --}}
            <div class="mb-3">
                <label for="logo" class="form-label">Logo</label>
                <input 
                    type="file" 
                    class="form-control @error('logo') is-invalid @enderror" 
                    id="logo" 
                    name="logo"
                    required>
                @error('logo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">Accepted formats: JPEG, PNG, JPG, GIF (max: 2MB)</div>
            </div>

            {{-- Action Buttons --}}
            <div class="d-flex justify-content-between">
                <a href="{{ route('departments.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Back
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Create Department
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
