@extends('layouts')

@section('content')
    <div class="rounded-xl bg-white shadow-sm">
        <x-admin.page-header title="Edit Category" icon="fa-edit" />
        <div class="px-6 py-6">
            <form action="{{ route('categories.update', $category) }}" method="POST">
                @csrf
                @method('PUT')
                <x-admin.input name="name" label="Category Name" :value="$category->name" :required="true" />
                <x-admin.form-actions :back-route="route('categories.index')" submit-label="Update Category" />
            </form>
        </div>
    </div>
@endsection
