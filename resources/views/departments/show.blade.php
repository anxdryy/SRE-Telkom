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
        {{-- Department Info --}}
        <div class="mb-3 text-center">
            <h4 class="card-title fw-bold mb-1">{{ $department->name }}</h4>
            <p class="card-subtitle text-muted">{{ $department->description }}</p>
        </div>

        {{-- Department Logo --}}
        @if ($department->logo)
            <div class="card mb-3 shadow-sm border-0 mx-auto" style="width: auto; display: inline-block;">
                <img src="{{ Storage::url($department->logo) }}"
                    class="img-fluid p-2"
                    style="max-height: 150px; max-width: 150px; object-fit: contain;"
                    alt="Logo of {{ $department->name }}">
            </div>
        @endif

        {{-- Department Image --}}
        @if ($department->image)
            <div class="card mb-3 shadow-sm border-0 mx-auto" style="width: auto; display: inline-block;">
                <img src="{{ Storage::url($department->image) }}"
                    class="img-fluid"
                    style="max-height: 400px; max-width: 300px; object-fit: cover;"
                    alt="Image of {{ $department->name }}">
            </div>
        @endif

        {{-- Timestamps --}}
        <div class="text-muted small mt-3">
            <p class="mb-1">Created at: {{ $department->created_at->format('Y-m-d H:i') }}</p>
            <p>Updated at: {{ $department->updated_at->format('Y-m-d H:i') }}</p>
        </div>

        {{-- Members Section --}}
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

        {{-- Works Section --}}
        <h5 class="mt-4 mb-3">Works ({{ $department->works->count() }})</h5>

        @if($department->works->isEmpty())
            <div class="alert alert-info">
                No works in this department yet.
            </div>
        @else
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach($department->works as $work)
                    <div class="col">
                        <div class="card h-100">
                            <img src="{{ Storage::url($work->image) }}" class="card-img-top" alt="{{ $work->name }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $work->name }}</h5>
                                <p class="card-text"><strong>Description:</strong> {{ $work->description }}</p>
                                <a href="{{ route('works.show', $work) }}" class="btn btn-sm btn-info">
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
