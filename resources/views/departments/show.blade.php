@extends('layouts')

@section('content')
    <div class="rounded-xl bg-white shadow-sm">
        <x-admin.page-header title="Department Details" icon="fa-building">
            <x-admin.icon-link :href="route('departments.edit', $department)" icon="fa-edit" variant="warning" />
            <a href="{{ route('departments.index') }}" class="inline-flex items-center gap-1 rounded-lg px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </x-admin.page-header>

        <div class="px-6 py-6">
            <div class="mb-6 text-center">
                <h2 class="font-redhat text-xl font-semibold text-gray-800">{{ $department->name }}</h2>
                <p class="mt-1 text-sm text-gray-500">{{ $department->description }}</p>
            </div>

            <div class="mb-6 flex justify-center gap-6">
                @if($department->logo)
                    <img src="{{ Storage::url($department->logo) }}" class="h-32 w-32 rounded object-contain bg-gray-50 p-2" alt="Logo of {{ $department->name }}">
                @endif
                @if($department->image)
                    <img src="{{ Storage::url($department->image) }}" class="h-48 w-64 rounded object-cover" alt="Image of {{ $department->name }}">
                @endif
            </div>

            <p class="mb-6 text-xs text-gray-400">
                Created {{ $department->created_at->timezone('Asia/Jakarta')->format('Y-m-d H:i') }} ·
                Updated {{ $department->updated_at->timezone('Asia/Jakarta')->format('Y-m-d H:i') }}
            </p>

            <h3 class="mb-3 font-redhat text-sm font-semibold text-gray-700">Members ({{ $department->members->count() }})</h3>
            @if($department->members->isEmpty())
                <p class="mb-6 text-sm text-gray-500">No members in this department yet.</p>
            @else
                <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-3">
                    @foreach($department->members as $member)
                        <div class="rounded-lg border border-gray-200 p-3">
                            <img src="{{ Storage::url($member->image) }}" class="mb-2 h-32 w-full rounded object-cover" alt="{{ $member->name }}">
                            <p class="font-medium text-gray-800">{{ $member->name }}</p>
                            <p class="text-xs text-gray-500">{{ $member->role }}</p>
                            <a href="{{ route('members.show', $member) }}" class="mt-2 inline-block text-xs font-medium text-blue-600 hover:underline">View</a>
                        </div>
                    @endforeach
                </div>
            @endif

            <h3 class="mb-3 font-redhat text-sm font-semibold text-gray-700">Works ({{ $department->works->count() }})</h3>
            @if($department->works->isEmpty())
                <p class="mb-2 text-sm text-gray-500">No works in this department yet.</p>
            @else
                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                    @foreach($department->works as $work)
                        <div class="rounded-lg border border-gray-200 p-3">
                            <img src="{{ Storage::url($work->image) }}" class="mb-2 h-32 w-full rounded object-cover" alt="{{ $work->name }}">
                            <p class="font-medium text-gray-800">{{ $work->name }}</p>
                            <p class="text-xs text-gray-500">{{ $work->description }}</p>
                            <a href="{{ route('works.show', $work) }}" class="mt-2 inline-block text-xs font-medium text-blue-600 hover:underline">View</a>
                        </div>
                    @endforeach
                </div>
            @endif

            <x-admin.delete-form :action="route('departments.destroy', $department)" confirm="Are you sure you want to delete this department?" class="mt-6" />
        </div>
    </div>
@endsection
