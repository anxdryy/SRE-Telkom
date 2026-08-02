<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>{{ $program->title }} | SRE Telkom University</title>

    <style>
        .font-redhat {
            font-family: 'Red Hat Display', sans-serif;
        }

        .font-redhattext {
            font-family: 'Red Hat Text', sans-serif;
        }

        .font-onest {
            font-family: 'Onest', sans-serif;
        }

        body {
            font-family: 'Red Hat Display', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen font-redhat">
    {{-- Navbar --}}
    @include('partials.othernavbar')

    {{-- Content Container --}}
    <main class="max-w-3xl mx-auto mt-40 px-4 md:px-0">

        {{-- Header with back button and info --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
            <div class="flex items-start space-x-3">
                {{-- Back button --}}
                {{-- LOGIKA BARU: Cek Kategori untuk menentukan arah tombol Back --}}
                @php
                    $backUrl = '/'; // Default ke Home jika tidak ada kategori
                    if ($program->category) {
                        if ($program->category->name == 'Research') {
                            $backUrl = '/Research';
                        } elseif ($program->category->name == 'Activity') {
                            $backUrl = '/Activity';
                        } elseif ($program->category->name == 'Competition') {
                            $backUrl = '/Competition';
                        }
                    }
                @endphp

                {{-- Back button dengan Link yang sudah ditentukan di atas --}}
                <a href="{{ url($backUrl) }}" aria-label="Back to {{ $program->category->name ?? 'Home' }}"
                    class="flex items-center justify-center w-11 h-11 -m-1 rounded-full text-black hover:text-green-600 hover:bg-gray-100 transition duration-300">
                    <svg class="w-8 h-8" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>

                <div>
                    <h1 class="text-xl md:text-2xl font-bold">
                        {{ $program->title }}
                    </h1>
                    <p class="text-gray-500 font-semibold text-sm mt-1">
                        {{ $program->created_at->timezone('Asia/Jakarta')->translatedFormat('d F Y H:i') }}
                    </p>
                </div>
            </div>

            {{-- Read More Button --}}
            @if(($program->category && in_array($program->category->name, ['Activity', 'Research', 'Competition'])) && $program->instagram)
                <a href="{{ $program->instagram }}" target="_blank" class="mt-4 md:mt-0">
                    <button
                        class="flex items-center bg-[#21735B] text-white text-sm px-4 py-2 rounded-full shadow hover:bg-[#1e604c] transition-transform duration-500 ease-in-out hover:scale-110">
                        <img src="{{ asset('images/instagram.png') }}" alt="Instagram" class="w-6 h-6 mr-2">
                        <span>Read More</span>
                    </button>
                </a>
            @endif
        </div>

        {{-- Image --}}
        @if ($program->image)
            <div class="rounded-2xl overflow-hidden mb-6">
                <img src="{{ asset('storage/' . $program->image) }}" alt="{{ $program->title }}"
                    class="w-full h-auto object-cover">
            </div>
        @endif

        {{-- Description --}}
        <div class="font-normal leading-relaxed text-gray-800 space-y-4 text-justify text-[15px]">
            <p>{!! nl2br(e($program->desc)) !!}</p>
        </div>
    </main>

    <!-- Footer Section -->
    <div class="mt-32">
        @include('partials.footer')
    </div>

</body>


</html>
