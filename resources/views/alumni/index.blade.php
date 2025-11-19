@extends('layouts')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3><i class="fas fa-users me-2"></i>Alumni</h3>
            <a href="{{ route('alumni.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>Create New Alumni
            </a>
        </div>
        <div class="card-body">
            @if($alumnis->isEmpty())
                <div class="alert alert-info">No Alumni found. Click the "Create New Alumni" button to add one.</div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Achievement</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($alumnis as $alumni)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <img src="{{ Storage::url($alumni->image) }}" alt="{{ $alumni->name }}" class="rounded"
                                            style="max-height: 60px;">
                                    </td>
                                    <td>{{ $alumni->name }}</td>
                                    <td>{{ $alumni->achievement }}</td>
                                    <td>{{ $alumni->created_at->timezone('Asia/Jakarta')->format('Y-m-d H:i') }}</td>
                                    <td>{{ $alumni->updated_at->timezone('Asia/Jakarta')->format('Y-m-d H:i') }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('alumni.show', $alumni) }}" class="btn btn-sm btn-info btn-action">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('alumni.edit', $alumni) }}" class="btn btn-sm btn-warning btn-action">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('alumni.destroy', $alumni) }}" method="POST" class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to delete this member?');">
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
                <div class="mt-3 d-flex justify-content-center">
                </div>
            @endif
        </div>
    </div>
@endsection
