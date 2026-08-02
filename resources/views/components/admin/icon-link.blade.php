@props(['href', 'icon', 'variant' => 'info', 'label' => null])
@php
$variants = [
    'info' => 'text-blue-600 hover:bg-blue-50',
    'warning' => 'text-amber-600 hover:bg-amber-50',
];
$resolvedLabel = $label ?? ucfirst($variant);
@endphp
<a href="{{ $href }}" class="inline-flex h-8 w-8 items-center justify-center rounded-md {{ $variants[$variant] ?? $variants['info'] }}" title="{{ $resolvedLabel }}" aria-label="{{ $resolvedLabel }}">
    <i class="fas {{ $icon }}"></i>
</a>
