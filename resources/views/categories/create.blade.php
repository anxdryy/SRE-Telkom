@extends('layouts')

@section('content')
    <div class="rounded-xl bg-white shadow-sm">
        <x-admin.page-header title="Create Category" icon="fa-plus" />
        <div class="px-6 py-6">
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf
                <x-admin.input name="name" label="Category Name" :required="true" />
                <x-admin.form-actions :back-route="route('categories.index')" submit-label="Create Category" />
            </form>
        </div>
    </div>
@endsection
