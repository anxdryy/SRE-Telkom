@props(['name', 'label', 'required' => false, 'hint' => null])
<div class="mb-4">
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-1">{{ $label }}</label>
    <input
        type="file"
        id="{{ $name }}"
        name="{{ $name }}"
        @if($required) required @endif
        {{ $attributes->merge(['class' => 'w-full rounded-lg border px-3 py-2 text-sm file:mr-3 file:rounded-md file:border-0 file:bg-[#104334] file:px-3 file:py-1.5 file:text-white file:text-sm ' . ($errors->has($name) ? 'border-red-500' : 'border-gray-300')]) }}
    >
    @if($hint)
        <p class="mt-1 text-xs text-gray-500">{{ $hint }}</p>
    @endif
    @error($name)
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
