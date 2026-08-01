@props(['action', 'confirm' => 'Are you sure?'])
<form action="{{ $action }}" method="POST" onsubmit="return confirm('{{ $confirm }}');">
    @csrf
    @method('DELETE')
    <button type="submit" class="inline-flex h-8 w-8 items-center justify-center rounded-md text-red-600 hover:bg-red-50" title="Delete">
        <i class="fas fa-trash"></i>
    </button>
</form>
