@extends('layouts')

@section('content')
    <div class="rounded-xl bg-white shadow-sm">
        <x-admin.page-header title="Edit Department" icon="fa-edit" />
        <div class="px-6 py-6">
            <div class="mb-6 flex gap-6">
                <div class="text-center">
                    <img src="{{ Storage::url($department->image) }}" alt="{{ $department->name }}" class="h-32 w-32 rounded object-cover">
                    <p class="mt-1 text-xs text-gray-500">Current image</p>
                </div>
                @if($department->logo)
                    <div class="text-center">
                        <img src="{{ Storage::url($department->logo) }}" alt="Logo of {{ $department->name }}" class="h-32 w-32 rounded object-contain bg-gray-50">
                        <p class="mt-1 text-xs text-gray-500">Current logo</p>
                    </div>
                @endif
            </div>
            <form action="{{ route('departments.update', $department) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <x-admin.input name="name" label="Name" :value="$department->name" :required="true" />
                <x-admin.input name="description" label="Description" :value="$department->description" :required="true" />
                <x-admin.file-input name="image" label="Background Image" hint="Leave empty to keep current image." />
                <x-admin.file-input name="logo" label="Logo" hint="Leave empty to keep current logo." />
                <x-admin.form-actions :back-route="route('departments.index')" submit-label="Update Department" />
            </form>
        </div>
    </div>
@endsection
