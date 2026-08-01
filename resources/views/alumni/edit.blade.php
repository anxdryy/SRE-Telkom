@extends('layouts')

@section('content')
    <div class="rounded-xl bg-white shadow-sm">
        <x-admin.page-header title="Edit Alumni" icon="fa-edit" />
        <div class="px-6 py-6">
            <div class="mb-6 text-center">
                <img src="{{ Storage::url($alumni->image) }}" alt="{{ $alumni->name }}" class="mx-auto h-32 w-32 rounded object-cover">
                <p class="mt-1 text-xs text-gray-500">Current image</p>
            </div>
            <form action="{{ route('alumni.update', $alumni) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <x-admin.input name="name" label="Name" :value="$alumni->name" :required="true" />
                <x-admin.input name="achievement" label="Achievement" :value="$alumni->achievement" :required="true" />
                <x-admin.file-input name="image" label="Image" hint="Leave empty to keep current image." />
                <x-admin.form-actions :back-route="route('alumni.index')" submit-label="Update Alumni" />
            </form>
        </div>
    </div>
@endsection
