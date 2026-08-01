@extends('layouts')

@section('content')
    <div class="rounded-xl bg-white shadow-sm">
        <x-admin.page-header title="Edit Member" icon="fa-edit" />
        <div class="px-6 py-6">
            <div class="mb-6 text-center">
                <img src="{{ Storage::url($member->image) }}" alt="{{ $member->name }}" class="mx-auto h-32 w-32 rounded object-cover">
                <p class="mt-1 text-xs text-gray-500">Current image</p>
            </div>
            <form action="{{ route('members.update', $member) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <x-admin.input name="name" label="Name" :value="$member->name" :required="true" />
                <x-admin.input name="role" label="Role" :value="$member->role" :required="true" />
                <x-admin.select name="department_id" label="Department" :options="$departments->pluck('name', 'id')" :selected="$member->department_id" :required="true" placeholder="Select Department" />
                <x-admin.file-input name="image" label="Profile Image" hint="Leave empty to keep current image." />
                <x-admin.form-actions :back-route="route('members.index')" submit-label="Update Member" />
            </form>
        </div>
    </div>
@endsection
