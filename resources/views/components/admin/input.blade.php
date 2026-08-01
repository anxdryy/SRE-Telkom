@props(['name', 'label', 'type' => 'text', 'value' => null, 'required' => false])
<div class="mb-4">
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-1">{{ $label }}</label>
    <input
        type="{{ $type }}"
        id="{{ $name }}"
        name="{{ $name }}"
        value="{{ old($name, $value) }}"
        @if($required) required @endif
        {{ $attributes->merge(['class' => 'w-full rounded-lg border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#104334] ' . ($errors->has($name) ? 'border-red-500' : 'border-gray-300')]) }}
    >
    @error($name)
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
