@if(session('success'))
    <div class="mb-4 flex items-center justify-between rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
        {{ session('success') }}
        <button type="button" onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-800">&times;</button>
    </div>
@endif
@if(session('error'))
    <div class="mb-4 flex items-center justify-between rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
        {{ session('error') }}
        <button type="button" onclick="this.parentElement.remove()" class="text-red-600 hover:text-red-800">&times;</button>
    </div>
@endif
