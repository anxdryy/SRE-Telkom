@props(['backRoute', 'submitLabel'])
<div class="flex items-center justify-between border-t border-gray-200 pt-4 mt-2">
    <a href="{{ $backRoute }}" class="inline-flex items-center gap-1 rounded-lg px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100">
        <i class="fas fa-arrow-left"></i> Back
    </a>
    <button type="submit" class="inline-flex items-center gap-1 rounded-lg bg-[#104334] px-4 py-2 text-sm font-medium text-white hover:bg-[#0c3327]">
        <i class="fas fa-save"></i> {{ $submitLabel }}
    </button>
</div>
