@extends('layouts')

@section('content')
    <div class="rounded-xl bg-white shadow-sm">
        <x-admin.page-header title="Create Department" icon="fa-plus" />
        <div class="px-6 py-6">
            <form action="{{ route('departments.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <x-admin.input name="name" label="Name" :required="true" />
                <x-admin.input name="description" label="Description" :required="true" />
                <x-admin.file-input name="image" label="Background Image" :required="true" hint="Accepted formats: JPEG, PNG, JPG, GIF (max 2MB)" />
                <x-admin.file-input name="logo" label="Logo" :required="true" hint="Accepted formats: JPEG, PNG, JPG, GIF (max 2MB)" />
                <x-admin.form-actions :back-route="route('departments.index')" submit-label="Create Department" />
            </form>
        </div>
    </div>
@endsection
