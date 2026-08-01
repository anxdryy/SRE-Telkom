@extends('layouts')

@section('content')
    <div class="rounded-xl bg-white shadow-sm">
        <x-admin.page-header title="Program Details" icon="fa-info-circle">
            <x-admin.icon-link :href="route('programs.edit', $program)" icon="fa-edit" variant="warning" />
            <a href="{{ route('programs.index') }}" class="inline-flex items-center gap-1 rounded-lg px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </x-admin.page-header>

        <div class="px-6 py-6">
            <div class="flex gap-6">
                @if($program->image)
                    <img src="{{ Storage::url($program->image) }}" alt="{{ $program->title }}" class="h-48 w-48 rounded object-cover">
                @endif
                <div>
                    <h2 class="font-redhat text-xl font-semibold text-gray-800">{{ $program->title }}</h2>
                    <p class="mt-1 text-sm text-gray-600">Category: {{ $program->category->name ?? '-' }}</p>
                    <p class="mt-2 text-sm text-gray-700">{{ $program->desc }}</p>
                    <p class="mt-2 text-sm">
                        Instagram:
                        @if($program->instagram)
                            <a href="{{ $program->instagram }}" target="_blank" rel="noopener noreferrer" class="text-blue-600 hover:underline">{{ $program->instagram }}</a>
                        @else
                            <span class="italic text-gray-400">No Instagram link</span>
                        @endif
                    </p>
                    <p class="mt-3 text-xs text-gray-400">
                        Created {{ $program->created_at->timezone('Asia/Jakarta')->format('Y-m-d H:i') }} ·
                        Updated {{ $program->updated_at->timezone('Asia/Jakarta')->format('Y-m-d H:i') }}
                    </p>
                    <div class="mt-4">
                        <x-admin.delete-form :action="route('programs.destroy', $program)" confirm="Are you sure you want to delete this program?" />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
