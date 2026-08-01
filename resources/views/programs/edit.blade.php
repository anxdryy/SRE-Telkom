@extends('layouts')

@section('content')
    <div class="rounded-xl bg-white shadow-sm">
        <x-admin.page-header title="Edit Program" icon="fa-edit" />
        <div class="px-6 py-6">
            @if($program->image)
                <div class="mb-6 text-center">
                    <img src="{{ Storage::url($program->image) }}" alt="{{ $program->title }}" class="mx-auto h-32 w-32 rounded object-cover">
                    <p class="mt-1 text-xs text-gray-500">Current image</p>
                </div>
            @endif
            <form action="{{ route('programs.update', $program) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <x-admin.input name="title" label="Program Title" :value="$program->title" :required="true" />
                <x-admin.textarea name="desc" label="Description" :value="$program->desc" :required="true" />
                <x-admin.file-input name="image" label="Program Image" hint="Leave empty to keep current image." />
                <x-admin.select name="category_id" label="Category" :options="$categories->pluck('name', 'id')" :selected="$program->category_id" :required="true" placeholder="Select Category" />
                <x-admin.input name="instagram" label="Instagram Link" :value="$program->instagram" />
                <x-admin.form-actions :back-route="route('programs.index')" submit-label="Update Program" />
            </form>
        </div>
    </div>
@endsection
