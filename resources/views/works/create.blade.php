@extends('layouts')

@section('content')
    <div class="rounded-xl bg-white shadow-sm">
        <x-admin.page-header title="Create Work" icon="fa-plus" />
        <div class="px-6 py-6">
            <form action="{{ route('works.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <x-admin.input name="name" label="Name" :required="true" />
                <x-admin.input name="description" label="Description" :required="true" />
                <x-admin.select name="department_id" label="Department" :options="$departments->pluck('name', 'id')" :required="true" placeholder="Select Department" />
                <x-admin.file-input name="image" label="Image" :required="true" hint="Accepted formats: JPEG, PNG, JPG, GIF (max 2MB)" />
                <x-admin.form-actions :back-route="route('works.index')" submit-label="Create Work" />
            </form>
        </div>
    </div>
@endsection
