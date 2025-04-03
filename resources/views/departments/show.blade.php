@extends('layouts')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3><i class="fas fa-building me-2"></i>Department Details</h3>
        <div>
            <a href="{{ route('departments.edit', $department) }}" class="btn btn-warning me-2">
                <i class="fas fa-edit me-1"></i>Edit
            </a>
            <a href="{{ route('departments.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i>Back
            </a>
        </div>
    </div>
    <div class="card-body">
        <h4 class="card-title">{{ $department->name }}</h4>
        <p class="text-muted">Created at: {{ $department->created_at->format('Y-m-d H:i') }}</p>
        <p class="text-muted">Updated at: {{ $department->updated_at->format('Y-m-d H:i') }}</p>

        <h5 class="mt-4 mb-3">Members ({{ $department->members->count() }})</h5>

        @if($department->members->isEmpty())
            <div class="alert alert-info">
                No members in this department yet.
            </div>
        @else
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach($department->members as $member)
                <div class="col">
                    <div class="card h-100">
                        <img src="{{ Storage::url($member->image) }}" class="card-img-top" alt="{{ $member->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $member->name }}</h5>
                            <p class="card-text"><strong>Role:</strong> {{ $member->role }}</p>
                            <a href="{{ route('members.show', $member) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye me-1"></i>View
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
