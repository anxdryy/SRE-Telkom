<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Red+Hat+Display:wght@400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>SRE Telkom University</title>
    <style>
        body {
            font-family: 'Red Hat Display', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen bg-white text-gray-800">

      {{-- Include shared navbar --}}
    @include('partials.othernavbar')

    <!-- Programs Section -->
    <main class="max-w-4xl mx-auto mt-40 px-4 md:px-0 mb-12">
        <div class="text-center mb-6">
            <h2 class="text-xl md:text-2xl font-semibold text-gray-400">Programs</h2>
            <div class="mt-2 flex flex-col md:flex-row justify-center items-center space-y-2 md:space-y-0 md:space-x-4">
                <a href="/Activity">
                    <span class="text-gray-400 text-2xl md:text-4xl">Activity</span>
                </a>
                    <span class="text-black font-black  text-2xl md:text-4xl">Competition</span>
                <a href="/Research">
                    <span class="text-gray-400 text-2xl md:text-4xl">Research</span>
                </a>
            </div>
        </div>

        <div class="space-y-6 mt-8 mb-12 md:mt-14">
            {{-- Loop over program items --}}
           @foreach ($programs as $program)
                <a href="{{ route('programs.showDetail', $program->slug) }}"
                class="block focus:outline-none focus:ring-4 focus:ring-green-300 rounded-lg transition duration-300">
                    <div class="bg-white shadow-md rounded-lg overflow-hidden border-4 border-[#21735B] w-full md:w-[900px] mx-auto flex flex-col md:flex-row">
                        <img src="{{ asset('storage/' . $program->image) }}" alt="{{ $program->title }}"
                            class="w-full md:w-80 h-48 object-cover">

                        <div class="p-6 flex-1 h-48 overflow-hidden">
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $program->title }}</h3>
                            <p class="text-gray-600 text-md overflow-hidden text-ellipsis pr-4"
                            style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical;">
                            {{ $program->desc }}
                            </p>
                        </div>
                    </div>
                </a>
            @endforeach
            <div class="mt-12 flex justify-center">
                {{ $programs->links('vendor.pagination.tailwind') }}
            </div>

    </main>
    <!-- Footer Section -->
    <div class="mt-48"> {{-- Adjust tree height by pushing footer down --}}
        @include('partials.footer')
    </div>

</body>
</html>
