@extends('layouts')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3><i class="fas fa-info-circle me-2"></i>Program Details</h3>
        <div>
            <a href="{{ route('programs.edit', $program) }}" class="btn btn-warning me-2">
                <i class="fas fa-edit me-1"></i>Edit
            </a>
            <a href="{{ route('programs.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i>Back
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4 text-center">
                @if ($program->image)
                    <img src="{{ Storage::url($program->image) }}" alt="{{ $program->title }}" class="img-fluid rounded mb-3" style="max-height: 300px;">
                @else
                    <div class="text-muted fst-italic">No image uploaded</div>
                @endif
            </div>
            <div class="col-md-8">
                <h4 class="card-title">{{ $program->title }}</h4>
                <p><strong>Category:</strong> {{ $program->category->name ?? '-' }}</p>
                <p><strong>Description:</strong> {{ $program->desc }}</p>
                <p>
                    <strong>Instagram:</strong>
                    @if ($program->instagram)
                        <a href="{{ $program->instagram }}" target="_blank" rel="noopener noreferrer">
                            {{ $program->instagram }}
                        </a>
                    @else
                        <span class="text-muted fst-italic">No Instagram link</span>
                    @endif
                </p>
                <p><strong>Created at:</strong> {{ $program->created_at->timezone('Asia/Jakarta')->format('Y-m-d H:i') }}</p>
                <p><strong>Updated at:</strong> {{ $program->updated_at->timezone('Asia/Jakarta')->format('Y-m-d H:i') }}</p>

                <form action="{{ route('programs.destroy', $program) }}" method="POST" class="mt-4" onsubmit="return confirm('Are you sure you want to delete this program?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-1"></i>Delete Program
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
