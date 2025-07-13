<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>SRE Telkom University</title>

</head>
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

<body class="min-h-screen font-redhat">
    {{-- Navbar --}}
    @include('partials.othernavbar')

    {{-- Content Container --}}
    <main class="max-w-3xl mx-auto mt-40 px-4 md:px-0">

        {{-- Header with back button and info --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
            <div class="flex items-start space-x-3">
                {{-- Back button --}}
                <a href="javascript:history.back()">
                    <svg class="w-8 h-8 text-black animate-bounce cursor-pointer hover:text-green-600 transition duration-300"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>

                <div>
                    <h1 class="text-xl md:text-2xl font-bold">
                        {{ $program->title }}
                    </h1>
                    <p class="text-gray-500 font-semibold text-sm mt-1">
                        {{ $program->created_at->translatedFormat('d F Y H:i') }}
                    </p>
                </div>
            </div>

            {{-- Read More Button --}}
            @if($program->category && $program->category->name === 'Activity')
            <a href="https://instagram.com" target="_blank" class="mt-4 md:mt-0">
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
        <div class="font-semibold leading-relaxed text-gray-800 space-y-4 text-justify text-[15px]">
            <p>{!! nl2br(e($program->desc)) !!}</p>
        </div>
    </main>

    <!-- Footer Section -->
    <footer class="relative bg-[#104334] text-white pt-[60px] md:pt-[90px] pb-8 md:pb-16 px-8 md:px-16 z-0 overflow-visible mt-48">
        <!-- Trees overflowing upwards -->
        <div class="absolute top-0 left-0 w-full h-[120px] md:h-[180px] -translate-y-[60%] md:-translate-y-[60%] z-10">
            <img src="{{ asset('images/trees.png') }}"
                alt="Forest Design"
                class="w-full h-full object-cover"
            >
        </div>
        <div class="container mx-auto flex flex-col md:flex-row justify-between items-start gap-8">
            <!-- Left: Logo and Description -->
            <div class="w-full md:w-1/3 mb-8 md:mb-0">
                <img src="{{ asset('images/logo1.png') }}" alt="SRE Universitas Telkom" class="w-auto h-16 md:h-auto">
                <p class="mt-4 text-sm text-gray-300">
                    Society of Renewable Energy is a student organization dedicated to promoting new and renewable
                    energy advancements across Indonesia.
                </p>
                <p class="mt-6 text-gray-400 text-xs">COPYRIGHT © SRE Telkom University 2024</p>
            </div>

            <!-- Right: Contact & Social Media -->
            <div class="w-full md:w-2/6 flex flex-col md:flex-row space-y-8 md:space-y-0">
                <!-- Contact Us -->
                <div class="w-full md:w-1/2">
                    <h3 class="text-lg font-semibold mb-2">Contact Us</h3>
                    <p class="text-sm text-gray-300 leading-relaxed">
                        Jl. Telekomunikasi,<br>
                        Jl. Terusan Buah Batu No.01,<br>
                        Sukapura, Dayeuhkolot,<br>
                        Bandung, Jawa Barat 40257
                    </p>
                </div>

                <!-- Follow Us -->
                <div class="w-3/8 flex flex-col items-start">
                    <h3 class="text-lg font-semibold mb-2 ">Follow Us</h3>
                    <div class="flex grid grid-cols-3 gap-3 ">
                        <a href="https://instagram.com" target="_blank">
                            <img src="{{ asset('images/instagram.png') }}" alt="Instagram" class="transition-transform duration-500 ease-out transform hover:scale-110 w-6 h-6">
                        </a>
                        <a href="https://line.me" target="_blank">
                            <img src="{{ asset('images/vector.png') }}" alt="Line" class="transition-transform duration-500 ease-out transform hover:scale-110 w-6 h-6">
                        </a>
                        <a href="https://youtube.com" target="_blank">
                            <img src="{{ asset('images/youtube.png') }}" alt="YouTube" class="transition-transform duration-500 ease-out transform hover:scale-110 w-6 h-6">
                        </a>
                        <a href="https://linkedin.com" target="_blank">
                            <img src="{{ asset('images/linkedin.png') }}" alt="LinkedIn" class="transition-transform duration-500 ease-out transform hover:scale-110 w-6 h-6">
                        </a>
                        <a href="mailto:example@example.com">
                            <img src="{{ asset('images/envelope.png') }}" alt="Email" class="transition-transform duration-500 ease-out transform hover:scale-110 w-6 h-6">
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hashtag -->
        <div class="text-center md:text-right mt-8 text-2xl md:text-4xl font-semibold text-gray-300">
            #sipalingrenewableenergy
        </div>
    </footer>

</body>


</html>
