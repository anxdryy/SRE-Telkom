@extends('layouts')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3><i class="fas fa-user me-2"></i>Member Details</h3>
        <div>
            <a href="{{ route('members.edit', $member) }}" class="btn btn-warning me-2">
                <i class="fas fa-edit me-1"></i>Edit
            </a>
            <a href="{{ route('members.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i>Back
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4 text-center">
                <img src="{{ Storage::url($member->image) }}" alt="{{ $member->name }}" class="img-fluid rounded mb-3" style="max-height: 300px;">
            </div>
            <div class="col-md-8">
                <h4 class="card-title">{{ $member->name }}</h4>
                <p><strong>Role:</strong> {{ $member->role }}</p>
                <p>
                    <strong>Department:</strong>
                    <a href="{{ route('departments.show', $member->department) }}">
                        {{ $member->department->name }}
                    </a>
                </p>
                <p><strong>Created at:</strong> {{ $member->created_at->format('Y-m-d H:i') }}</p>
                <p><strong>Updated at:</strong> {{ $member->updated_at->format('Y-m-d H:i') }}</p>

                <form action="{{ route('members.destroy', $member) }}" method="POST" class="mt-4" onsubmit="return confirm('Are you sure you want to delete this member?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-1"></i>Delete Member
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
