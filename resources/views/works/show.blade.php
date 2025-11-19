@extends('layouts')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3><i class="fas fa-suitcase me-2"></i>Work Details</h3>
        <div>
            <a href="{{ route('works.edit', $work) }}" class="btn btn-warning me-2">
                <i class="fas fa-edit me-1"></i>Edit
            </a>
            <a href="{{ route('works.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i>Back
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4 text-center">
                <img src="{{ Storage::url($work->image) }}" alt="{{ $work->name }}" class="img-fluid rounded mb-3" style="max-height: 300px;">
            </div>
            <div class="col-md-8">
                <h4 class="card-title">{{ $work->name }}</h4>
                <p><strong>Description:</strong> {{ $work->description }}</p>
                <p>
                    <strong>Department:</strong>
                    <a href="{{ route('departments.show', $work->department) }}">
                        {{ $work->department->name }}
                    </a>
                </p>
                <p><strong>Created at:</strong> {{ $work->created_at->timezone('Asia/Jakarta')->format('Y-m-d H:i') }}</p>
                <p><strong>Updated at:</strong> {{ $work->updated_at->timezone('Asia/Jakarta')->format('Y-m-d H:i') }}</p>

                <form action="{{ route('works.destroy', $work) }}" method="POST" class="mt-4" onsubmit="return confirm('Are you sure you want to delete this work?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-1"></i>Delete Work
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
