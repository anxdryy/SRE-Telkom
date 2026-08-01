@extends('layouts')

@section('content')
    <div class="rounded-xl bg-white shadow-sm">
        <x-admin.page-header title="Works" icon="fa-suitcase">
            <a href="{{ route('works.create') }}" class="inline-flex items-center gap-1 rounded-lg bg-[#104334] px-4 py-2 text-sm font-medium text-white hover:bg-[#0c3327]">
                <i class="fas fa-plus"></i> Create New Work
            </a>
        </x-admin.page-header>

        <div class="px-6 py-4">
            @if($works->isEmpty())
                <p class="text-sm text-gray-500">No works found. Click "Create New Work" to add one.</p>
            @else
                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                            <tr>
                                <th class="px-4 py-3">No</th>
                                <th class="px-4 py-3">Image</th>
                                <th class="px-4 py-3">Name</th>
                                <th class="px-4 py-3">Description</th>
                                <th class="px-4 py-3">Department</th>
                                <th class="px-4 py-3">Updated</th>
                                <th class="px-4 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($works as $work)
                                <tr>
                                    <td class="px-4 py-3">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-3">
                                        <img src="{{ Storage::url($work->image) }}" alt="{{ $work->name }}" class="h-14 w-14 rounded object-cover">
                                    </td>
                                    <td class="px-4 py-3 font-medium text-gray-800">{{ $work->name }}</td>
                                    <td class="px-4 py-3 max-w-xs truncate">{{ $work->description }}</td>
                                    <td class="px-4 py-3">
                                        <a href="{{ route('departments.show', $work->department) }}" class="text-blue-600 hover:underline">{{ $work->department->name }}</a>
                                    </td>
                                    <td class="px-4 py-3 text-gray-500">{{ $work->updated_at->timezone('Asia/Jakarta')->format('Y-m-d H:i') }}</td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-1">
                                            <x-admin.icon-link :href="route('works.show', $work)" icon="fa-eye" variant="info" />
                                            <x-admin.icon-link :href="route('works.edit', $work)" icon="fa-edit" variant="warning" />
                                            <x-admin.delete-form :action="route('works.destroy', $work)" confirm="Are you sure you want to delete this work?" />
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 flex justify-center">
                    {{ $works->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
