@extends('layouts')

@section('content')
    <div class="rounded-xl bg-white shadow-sm">
        <x-admin.page-header title="Departments" icon="fa-building">
            <a href="{{ route('departments.create') }}" class="inline-flex items-center gap-1 rounded-lg bg-[#104334] px-4 py-2 text-sm font-medium text-white hover:bg-[#0c3327]">
                <i class="fas fa-plus"></i> Create New Department
            </a>
        </x-admin.page-header>

        <div class="px-6 py-4">
            @if($departments->isEmpty())
                <p class="text-sm text-gray-500">No departments found. Click "Create New Department" to add one.</p>
            @else
                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                            <tr>
                                <th class="px-4 py-3">No</th>
                                <th class="px-4 py-3">Image</th>
                                <th class="px-4 py-3">Name</th>
                                <th class="px-4 py-3">Members</th>
                                <th class="px-4 py-3">Works</th>
                                <th class="px-4 py-3">Updated</th>
                                <th class="px-4 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($departments as $department)
                                <tr>
                                    <td class="px-4 py-3">{{ $departments->firstItem() + $loop->index }}</td>
                                    <td class="px-4 py-3">
                                        <img src="{{ Storage::url($department->image) }}" alt="{{ $department->name }}" class="h-14 w-14 rounded object-cover">
                                    </td>
                                    <td class="px-4 py-3 font-medium text-gray-800">{{ $department->name }}</td>
                                    <td class="px-4 py-3">
                                        <span class="rounded-full bg-blue-50 px-2 py-0.5 text-xs font-medium text-blue-700">{{ $department->members_count }}</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="rounded-full bg-blue-50 px-2 py-0.5 text-xs font-medium text-blue-700">{{ $department->works_count }}</span>
                                    </td>
                                    <td class="px-4 py-3 text-gray-500">{{ $department->updated_at->timezone('Asia/Jakarta')->format('Y-m-d H:i') }}</td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-1">
                                            <x-admin.icon-link :href="route('departments.show', $department)" icon="fa-eye" variant="info" />
                                            <x-admin.icon-link :href="route('departments.edit', $department)" icon="fa-edit" variant="warning" />
                                            <x-admin.delete-form
                                                :action="route('departments.destroy', $department)"
                                                confirm="Are you sure you want to delete this department?"
                                                :disabled="$department->members_count > 0 || $department->works_count > 0"
                                            />
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 flex justify-center">
                    {{ $departments->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
