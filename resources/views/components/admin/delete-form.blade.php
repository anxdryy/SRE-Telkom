@props(['action', 'confirm' => 'Are you sure?', 'disabled' => false])
<form action="{{ $action }}" method="POST" {{ $attributes }} @unless($disabled) onsubmit="return confirm({{ Js::from($confirm) }});" @endunless>
    @csrf
    @method('DELETE')
    <button
        type="submit"
        @disabled($disabled)
        class="inline-flex h-8 w-8 items-center justify-center rounded-md text-red-600 hover:bg-red-50 disabled:cursor-not-allowed disabled:text-gray-300 disabled:hover:bg-transparent"
        title="{{ $disabled ? 'Cannot delete: still has related records' : 'Delete' }}"
    >
        <i class="fas fa-trash"></i>
    </button>
</form>
