<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>SRE Telkom University - {{ $department->name }}</title>
</head>

<body class="min-h-screen">

    {{-- Include shared navbar --}}
    @include('partials.othernavbar')

    <!-- Hero Section -->
    <section class="relative bg-cover bg-center text-white h-[400px] flex items-center justify-center"
        style="background-image: url('{{ asset('images/core-team-bg.jpg') }}');">
        <div class="absolute inset-0 bg-black opacity-30"></div>
        <div class="relative z-10 text-center px-4">
            <h1 class="text-4xl font-bold mb-2">{{ $department->name }}</h1>
            <p class="max-w-2xl mx-auto">{{ $department->description }}</p>
            <div class="mt-6">
                @if ($department->image)
                    <img src="{{ asset('storage/' . $department->image) }}" alt="{{ $department->name }} Badge"
                        class="mx-auto w-24">
                @endif
            </div>
        </div>
    </section>

    <!-- Members Section -->
    <section class="bg-green-900 text-white py-12 text-center">
        <h2 class="text-3xl font-semibold mb-8">Our Members</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 px-6 md:px-20">
            @forelse ($department->members as $member)
                <div class="flex flex-col items-center">
                    <div class="w-24 h-24 bg-gray-400 rounded-full mb-2 overflow-hidden">
                        @if ($member->image)
                            <img src="{{ asset('storage/' . $member->image) }}" alt="{{ $member->name }}"
                                class="w-full h-full object-cover">
                        @endif
                    </div>
                    <p>{{ $member->name }}</p>
                    <p class="text-sm text-gray-300">{{ $member->division }}</p>
                </div>
            @empty
                <p class="col-span-full text-gray-400">No members yet.</p>
            @endforelse
        </div>
    </section>

    <!-- Programs Section -->
    <section class="py-12 px-6 text-center">
        <h2 class="text-3xl font-semibold mb-8">What We Do</h2>
        <div class="grid md:grid-cols-3 gap-6">
            @forelse ($department->works as $work)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <img src="{{ asset('storage/' . $work->image) }}" alt="{{ $work->title }}"
                        class="w-full h-32 object-cover">
                    <div class="p-4">
                        <h3 class="font-semibold">{{ $work->title }}</h3>
                        <p class="text-sm">{{ $work->description }}</p>
                    </div>
                </div>
            @empty
                <p class="col-span-full text-gray-500">No works found.</p>
            @endforelse
        </div>
    </section>

    <!-- Footer Section -->
    @include('partials.footer')

</body>

</html>
