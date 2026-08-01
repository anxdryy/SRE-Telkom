@props(['name', 'label', 'value' => null, 'required' => false, 'rows' => 4])
<div class="mb-4">
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-1">{{ $label }}</label>
    <textarea
        id="{{ $name }}"
        name="{{ $name }}"
        rows="{{ $rows }}"
        @if($required) required @endif
        {{ $attributes->merge(['class' => 'w-full rounded-lg border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#104334] ' . ($errors->has($name) ? 'border-red-500' : 'border-gray-300')]) }}
    >{{ old($name, $value) }}</textarea>
    @error($name)
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
