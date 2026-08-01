@props(['href', 'icon', 'variant' => 'info'])
@php
$variants = [
    'info' => 'text-blue-600 hover:bg-blue-50',
    'warning' => 'text-amber-600 hover:bg-amber-50',
];
@endphp
<a href="{{ $href }}" class="inline-flex h-8 w-8 items-center justify-center rounded-md {{ $variants[$variant] }}" title="{{ ucfirst($variant) }}">
    <i class="fas {{ $icon }}"></i>
</a>
