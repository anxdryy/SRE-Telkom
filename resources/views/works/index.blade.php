@extends('layouts')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3><i class="fas fa-suitcase me-2"></i>Works</h3>
            <a href="{{ route('works.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>Create New Works
            </a>
        </div>
        <div class="card-body">
            @if($works->isEmpty())
                <div class="alert alert-info">
                    No works found. Click the "Create New Work" button to add one.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Department</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($works as $work)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <img src="{{ Storage::url($work->image) }}" alt="{{ $work->name }}"
                                            class="rounded member-image">
                                    </td>
                                    <td>{{ $work->name }}</td>
                                    <td>{{ $work->description }}</td>
                                    <td>
                                        <a href="{{ route('departments.show', $work->department) }}">
                                            {{ $work->department->name }}
                                        </a>
                                    </td>
                                    <td>{{ $work->created_at->timezone('Asia/Jakarta')->format('Y-m-d H:i') }}</td>
                                    <td>{{ $work->updated_at->timezone('Asia/Jakarta')->format('Y-m-d H:i') }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('works.show', $work) }}" class="btn btn-sm btn-info btn-action">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('works.edit', $work) }}" class="btn btn-sm btn-warning btn-action">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('works.destroy', $work) }}" method="POST" class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to delete this work?');">
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
                    {{ $works->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
