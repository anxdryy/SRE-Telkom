@extends('layouts')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3><i class="fas fa-folder-open me-2"></i>Programs</h3>
        <a href="{{ route('programs.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i>Create New Program
        </a>
    </div>
    <div class="card-body">
        @if ($programs->isEmpty())
            <div class="alert alert-info">
                No programs found. Click the "Create New Program" button to add one.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Image</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($programs as $program)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $program->title }}</td>
                                <td>{{ $program->category->name ?? '-' }}</td>
                                <td>
                                    @if ($program->image)
                                        <img src="{{ Storage::url($program->image) }}" alt="{{ $program->title }}" class="rounded" style="width: 60px; height: 60px; object-fit: cover;">
                                    @else
                                        <span class="text-muted">No Image</span>
                                    @endif
                                </td>
                                <td>{{ $program->created_at->format('Y-m-d H:i') }}</td>
                                <td>{{ $program->updated_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('programs.show', $program->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('programs.edit', $program->id) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('programs.destroy', $program->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this program ?');" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
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
        @endif
    </div>
</div>
@endsection
