@extends('layouts')

@section('content')
    <div class="rounded-xl bg-white shadow-sm">
        <x-admin.page-header title="Programs" icon="fa-folder-open">
            <a href="{{ route('programs.create') }}" class="inline-flex items-center gap-1 rounded-lg bg-[#104334] px-4 py-2 text-sm font-medium text-white hover:bg-[#0c3327]">
                <i class="fas fa-plus"></i> Create New Program
            </a>
        </x-admin.page-header>

        <div class="px-6 py-4">
            @if($programs->isEmpty())
                <p class="text-sm text-gray-500">No programs found. Click "Create New Program" to add one.</p>
            @else
                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                            <tr>
                                <th class="px-4 py-3">No</th>
                                <th class="px-4 py-3">Image</th>
                                <th class="px-4 py-3">Title</th>
                                <th class="px-4 py-3">Category</th>
                                <th class="px-4 py-3">Instagram</th>
                                <th class="px-4 py-3">Updated</th>
                                <th class="px-4 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($programs as $program)
                                <tr>
                                    <td class="px-4 py-3">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-3">
                                        @if($program->image)
                                            <img src="{{ Storage::url($program->image) }}" alt="{{ $program->title }}" class="h-14 w-14 rounded object-cover">
                                        @else
                                            <span class="text-xs text-gray-400">No image</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 font-medium text-gray-800">{{ $program->title }}</td>
                                    <td class="px-4 py-3">{{ $program->category->name ?? '-' }}</td>
                                    <td class="px-4 py-3 max-w-xs truncate">
                                        @if($program->instagram)
                                            <a href="{{ $program->instagram }}" target="_blank" rel="noopener noreferrer" class="text-blue-600 hover:underline">{{ $program->instagram }}</a>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-gray-500">{{ $program->updated_at->timezone('Asia/Jakarta')->format('Y-m-d H:i') }}</td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-1">
                                            <x-admin.icon-link :href="route('programs.show', $program)" icon="fa-eye" variant="info" />
                                            <x-admin.icon-link :href="route('programs.edit', $program)" icon="fa-edit" variant="warning" />
                                            <x-admin.delete-form :action="route('programs.destroy', $program)" confirm="Are you sure you want to delete this program?" />
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 flex justify-center">
                    {{ $programs->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
