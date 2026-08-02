@extends('layouts')

@section('content')
    <div class="rounded-xl bg-white shadow-sm">
        <x-admin.page-header title="Category Details" icon="fa-tag">
            <x-admin.icon-link :href="route('categories.edit', $category)" icon="fa-edit" variant="warning" label="Edit" />
            <a href="{{ route('categories.index') }}" class="inline-flex items-center gap-1 rounded-lg px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </x-admin.page-header>
        <div class="px-6 py-6">
            <h2 class="font-redhat text-xl font-semibold text-gray-800">{{ $category->name }}</h2>
            <p class="mt-3 text-xs text-gray-400">
                Created {{ $category->created_at->timezone('Asia/Jakarta')->format('Y-m-d H:i') }} ·
                Updated {{ $category->updated_at->timezone('Asia/Jakarta')->format('Y-m-d H:i') }}
            </p>
        </div>
    </div>
@endsection
