@extends('layouts')

@section('content')
    <div class="rounded-xl bg-white shadow-sm">
        <x-admin.page-header title="Create Program" icon="fa-plus" />
        <div class="px-6 py-6">
            <form action="{{ route('programs.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <x-admin.input name="title" label="Program Title" :required="true" />
                <x-admin.textarea name="desc" label="Description" :required="true" />
                <x-admin.file-input name="image" label="Program Image" :required="true" hint="Accepted formats: JPEG, PNG, JPG, GIF (max 2MB)" />
                <x-admin.select name="category_id" label="Category" :options="$categories->pluck('name', 'id')" :required="true" placeholder="Select Category" />
                <x-admin.input name="instagram" label="Instagram Link" />
                <x-admin.form-actions :back-route="route('programs.index')" submit-label="Create Program" />
            </form>
        </div>
    </div>
@endsection
