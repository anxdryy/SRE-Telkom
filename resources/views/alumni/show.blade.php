@extends('layouts')

@section('content')
    <div class="rounded-xl bg-white shadow-sm">
        <x-admin.page-header title="Alumni Details" icon="fa-user-graduate">
            <x-admin.icon-link :href="route('alumni.edit', $alumni)" icon="fa-edit" variant="warning" label="Edit" />
            <a href="{{ route('alumni.index') }}" class="inline-flex items-center gap-1 rounded-lg px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </x-admin.page-header>

        <div class="px-6 py-6">
            <div class="flex gap-6">
                <img src="{{ Storage::url($alumni->image) }}" alt="{{ $alumni->name }}" class="h-48 w-48 rounded object-cover">
                <div>
                    <h2 class="font-redhat text-xl font-semibold text-gray-800">{{ $alumni->name }}</h2>
                    <p class="mt-1 text-sm text-gray-700">{{ $alumni->achievement }}</p>
                    <p class="mt-3 text-xs text-gray-400">
                        Created {{ $alumni->created_at->timezone('Asia/Jakarta')->format('Y-m-d H:i') }} ·
                        Updated {{ $alumni->updated_at->timezone('Asia/Jakarta')->format('Y-m-d H:i') }}
                    </p>
                    <div class="mt-4">
                        <x-admin.delete-form :action="route('alumni.destroy', $alumni)" confirm="Are you sure you want to delete this alumni?" />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
