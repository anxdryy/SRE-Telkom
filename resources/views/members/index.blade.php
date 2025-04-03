@extends('layouts')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3><i class="fas fa-users me-2"></i>Members</h3>
        <a href="{{ route('members.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i>Create New Member
        </a>
    </div>
    <div class="card-body">
        @if($members->isEmpty())
            <div class="alert alert-info">
                No members found. Click the "Create New Member" button to add one.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Role</th>
                            <th>Department</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($members as $member)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <img src="{{ Storage::url($member->image) }}" alt="{{ $member->name }}" class="rounded member-image">
                            </td>
                            <td>{{ $member->name }}</td>
                            <td>{{ $member->role }}</td>
                            <td>
                                <a href="{{ route('departments.show', $member->department) }}">
                                    {{ $member->department->name }}
                                </a>
                            </td>
                            <td>{{ $member->created_at->format('Y-m-d H:i') }}</td>
                            <td>{{ $member->updated_at->format('Y-m-d H:i') }}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('members.show', $member) }}" class="btn btn-sm btn-info btn-action">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('members.edit', $member) }}" class="btn btn-sm btn-warning btn-action">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('members.destroy', $member) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this member?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger btn-action">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-3">
                {{ $members->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
