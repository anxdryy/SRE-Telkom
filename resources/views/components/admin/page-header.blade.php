@props(['title', 'icon' => null])
<div class="flex items-center justify-between bg-white rounded-t-xl border border-b-0 border-gray-200 px-6 py-4">
    <h1 class="flex items-center gap-2 text-lg font-semibold text-[#104334] font-redhat">
        @if($icon)
            <i class="fas {{ $icon }}"></i>
        @endif
        {{ $title }}
    </h1>
    <div class="flex items-center gap-2">
        {{ $slot }}
    </div>
</div>
