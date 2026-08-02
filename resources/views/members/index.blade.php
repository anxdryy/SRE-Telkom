@extends('layouts')

@section('content')
    <div class="rounded-xl bg-white shadow-sm">
        <x-admin.page-header title="Members" icon="fa-users">
            <a href="{{ route('members.create') }}" class="inline-flex items-center gap-1 rounded-lg bg-[#104334] px-4 py-2 text-sm font-medium text-white hover:bg-[#0c3327]">
                <i class="fas fa-plus"></i> Create New Member
            </a>
        </x-admin.page-header>

        <div class="px-6 py-4">
            @if($members->isEmpty())
                <p class="text-sm text-gray-500">No members found. Click "Create New Member" to add one.</p>
            @else
                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                            <tr>
                                <th class="px-4 py-3">No</th>
                                <th class="px-4 py-3">Image</th>
                                <th class="px-4 py-3">Name</th>
                                <th class="px-4 py-3">Role</th>
                                <th class="px-4 py-3">Department</th>
                                <th class="px-4 py-3">Updated</th>
                                <th class="px-4 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($members as $member)
                                <tr>
                                    <td class="px-4 py-3">{{ $members->firstItem() + $loop->index }}</td>
                                    <td class="px-4 py-3">
                                        <img src="{{ Storage::url($member->image) }}" alt="{{ $member->name }}" class="h-14 w-14 rounded object-cover">
                                    </td>
                                    <td class="px-4 py-3 font-medium text-gray-800">{{ $member->name }}</td>
                                    <td class="px-4 py-3">{{ $member->role }}</td>
                                    <td class="px-4 py-3">
                                        <a href="{{ route('departments.show', $member->department) }}" class="text-blue-600 hover:underline">
                                            {{ $member->department->name }}
                                        </a>
                                    </td>
                                    <td class="px-4 py-3 text-gray-500">{{ $member->updated_at->timezone('Asia/Jakarta')->format('Y-m-d H:i') }}</td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-1">
                                            <x-admin.icon-link :href="route('members.show', $member)" icon="fa-eye" variant="info" label="View" />
                                            <x-admin.icon-link :href="route('members.edit', $member)" icon="fa-edit" variant="warning" label="Edit" />
                                            <x-admin.delete-form :action="route('members.destroy', $member)" confirm="Are you sure you want to delete this member?" />
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 flex justify-center">
                    {{ $members->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
