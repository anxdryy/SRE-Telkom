@extends('layouts')

@section('content')
    <div class="rounded-xl bg-white shadow-sm">
        <x-admin.page-header title="Categories" icon="fa-tags">
            <a href="{{ route('categories.create') }}" class="inline-flex items-center gap-1 rounded-lg bg-[#104334] px-4 py-2 text-sm font-medium text-white hover:bg-[#0c3327]">
                <i class="fas fa-plus"></i> Create New Category
            </a>
        </x-admin.page-header>

        <div class="px-6 py-4">
            @if($categories->isEmpty())
                <p class="text-sm text-gray-500">No categories found. Click "Create New Category" to add one.</p>
            @else
                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                            <tr>
                                <th class="px-4 py-3">No</th>
                                <th class="px-4 py-3">Category</th>
                                <th class="px-4 py-3">Updated</th>
                                <th class="px-4 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($categories as $category)
                                <tr>
                                    <td class="px-4 py-3">{{ $categories->firstItem() + $loop->index }}</td>
                                    <td class="px-4 py-3 font-medium text-gray-800">{{ $category->name }}</td>
                                    <td class="px-4 py-3 text-gray-500">{{ $category->updated_at->timezone('Asia/Jakarta')->format('Y-m-d H:i') }}</td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-1">
                                            <x-admin.icon-link :href="route('categories.show', $category)" icon="fa-eye" variant="info" label="View" />
                                            <x-admin.icon-link :href="route('categories.edit', $category)" icon="fa-edit" variant="warning" label="Edit" />
                                            <x-admin.delete-form
                                                :action="route('categories.destroy', $category)"
                                                confirm="Are you sure you want to delete this category?"
                                                :disabled="$category->programs_count > 0"
                                            />
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 flex justify-center">
                    {{ $categories->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
