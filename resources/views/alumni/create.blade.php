@extends('layouts')

@section('content')
    <div class="rounded-xl bg-white shadow-sm">
        <x-admin.page-header title="Create Alumni" icon="fa-plus" />
        <div class="px-6 py-6">
            <form action="{{ route('alumni.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <x-admin.input name="name" label="Name" :required="true" />
                <x-admin.input name="achievement" label="Achievement" :required="true" />
                <x-admin.file-input name="image" label="Image" :required="true" hint="Accepted formats: JPEG, PNG, JPG, GIF (max 2MB)" />
                <x-admin.form-actions :back-route="route('alumni.index')" submit-label="Create Alumni" />
            </form>
        </div>
    </div>
@endsection
