<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>SRE Telkom University</title>
</head>

<body class="min-h-screen">
 
    {{-- Include shared navbar --}}
     @include('partials.othernavbar');

    <!-- Hero Section -->
    <section class="relative bg-cover bg-center text-white h-[400px] flex items-center justify-center" style="background-image: url('{{ asset('images/core-team-bg.jpg') }}');">
        <div class="absolute inset-0 bg-black opacity-30"></div>
        <div class="relative z-10 text-center px-4">
            <h1 class="text-4xl font-bold mb-2">Core Team</h1>
            <p class="max-w-2xl mx-auto">
                A core team is a small, dedicated group responsible for organizational thinking and decision-making, support for coordination, interdepartmental alignment, and project coordination. They prioritize delivery to ensure smooth operations and alignment with overall goals.
            </p>
            <div class="mt-6">
                <img src="{{ asset('images/core-badge.png') }}" alt="Core Badge" class="mx-auto w-24">
            </div>
        </div>
    </section>

    <!-- Members Section -->
    <section class="bg-green-900 text-white py-12 text-center">
        <h2 class="text-3xl font-semibold mb-8">Our Members</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 px-6 md:px-20">
            @for ($i = 0; $i < 8; $i++)
                <div class="flex flex-col items-center">
                    <div class="w-24 h-24 bg-gray-400 rounded-full mb-2"></div>
                    <p>Sabrina</p>
                    <p class="text-sm text-gray-300">Division</p>
                </div>
            @endfor
        </div>
    </section>

    <!-- What We Do Section -->
    <section class="py-12 px-6 text-center">
        <h2 class="text-3xl font-semibold mb-8">What We Do</h2>
        <div class="grid md:grid-cols-3 gap-6">
            <!-- Card 1 -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <img src="{{ asset('images/bicycle.jpg') }}" alt="Bicycle Program" class="w-full h-32 object-cover">
                <div class="p-4">
                    <h3 class="font-semibold">Bicycle Program</h3>
                    <p class="text-sm">Weekly rides across town, promoting sustainable transportation.</p>
                </div>
            </div>
            <!-- Card 2 -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <img src="{{ asset('images/camping.jpg') }}" alt="Camping Trip" class="w-full h-32 object-cover">
                <div class="p-4">
                    <h3 class="font-semibold">Camping Trip</h3>
                    <p class="text-sm">Going to learn valuable things in the wild!</p>
                </div>
            </div>
            <!-- Card 3 -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <img src="{{ asset('images/hiking.jpg') }}" alt="The Hikers" class="w-full h-32 object-cover">
                <div class="p-4">
                    <h3 class="font-semibold">The 'Hikers'</h3>
                    <p class="text-sm">Hiking & happiness go hand-in-hand.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="flex flex-col gap-10 md:flex-row items-center justify-between px-6 my-10 md:px-10 py-10">
        <!-- Bagian Kiri (Teks) -->
        <div class="w-full ml-10 md:w-1/3 mb-6 md:mb-0">
            <h2 class="font-redhat text-3xl md:text-3xl font-extrabold text-black flex items-center tracking-widest">
                Our <span class="text-[#104334] ml-2">Departments</span>
            </h2>
            <div class="w-16 h-1 bg-gray-500 mt-2 mr-8"></div>
            <p class="font-redhattext text-black mt-4 max-w-[85%] text-justify text-base md:text-lg font-semibold">
                Each of our departments strive to fulfill the needs. Achieving the vission and mission towards our SRE
                Goals.
            </p>
        </div>

        <!-- Bagian Kanan (Ikon Departemen) -->
        <div class="w-full md:w-2/3 grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
            <img src="images/CoreNew.png" alt="Core"
                class="w-24 h-24 md:w-36 md:h-36 object-contain drop-shadow-[0px_4px_10px_rgba(0,0,0,0.6)] transition-transform duration-300 ease-in-out hover:scale-110">
            <img src="images/EVENT.png" alt="Event"
                class="w-24 h-24 md:w-36 md:h-36 object-contain drop-shadow-[0px_4px_10px_rgba(0,0,0,0.6)] transition-transform duration-300 ease-in-out hover:scale-110">
            <img src="images/IT.png"
                class="w-24 h-24 md:w-36 md:h-36 object-contain drop-shadow-[0px_4px_10px_rgba(0,0,0,0.6)] transition-transform duration-300 ease-in-out hover:scale-110">
            <img src="images/MULMED.png" alt="Multimedia"
                class="w-24 h-24 md:w-36 md:h-36 object-contain drop-shadow-[0px_4px_10px_rgba(0,0,0,0.6)] transition-transform duration-300 ease-in-out hover:scale-110">
            <img src="images/PR.png" alt="Public Relation"
                class="w-24 h-24 md:w-36 md:h-36 object-contain drop-shadow-[0px_4px_10px_rgba(0,0,0,0.6)] transition-transform duration-300 ease-in-out hover:scale-110">
            <img src="images/ACAD.png" alt="Academics"
                class="w-24 h-24 md:w-36 md:h-36 object-contain drop-shadow-[0px_4px_10px_rgba(0,0,0,0.6)] transition-transform duration-300 ease-in-out hover:scale-110">
            <img src="images/RND.png" alt="Research & Development"
                class="w-24 h-24 md:w-36 md:h-36 object-contain drop-shadow-[0px_4px_10px_rgba(0,0,0,0.6)] transition-transform duration-300 ease-in-out hover:scale-110">
        </div>
    </section>

    <!-- Footer Section -->
    <footer class="relative bg-[#104334] text-white pt-[60px] mt-32 md:pt-[90px] pb-8 md:pb-16 px-8 md:px-16 z-0 overflow-visible">
        <!-- Trees overflowing upwards -->
        <div class="absolute top-0 left-0 w-full h-[120px] md:h-[180px] -translate-y-[30%] md:-translate-y-[60%] z-10">
            <img 
                src="images/trees.png" 
                alt="Forest Design" 
                class="w-full h-full object-cover"
            >
        </div>
        <div class="container mx-auto flex flex-col md:flex-row justify-between items-start gap-8">
            <!-- Left: Logo and Description -->
            <div class="w-full md:w-1/3 mb-8 md:mb-0">
                <img src="images/logo1.png" alt="SRE Universitas Telkom" class="w-auto h-16 md:h-auto">
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
                    <div class="grid grid-cols-3 gap-3 ">
                        <a href="https://instagram.com" target="_blank">
                            <img src="images/instagram.png" alt="Instagram" class="transition-transform duration-500 ease-out transform hover:scale-110 w-6 h-6">
                        </a>
                        <a href="https://line.me" target="_blank">
                            <img src="images/vector.png" alt="Line" class="transition-transform duration-500 ease-out transform hover:scale-110 w-6 h-6">
                        </a>
                        <a href="https://youtube.com" target="_blank">
                            <img src="images/youtube.png" alt="YouTube" class="transition-transform duration-500 ease-out transform hover:scale-110 w-6 h-6">
                        </a>
                        <a href="https://linkedin.com" target="_blank">
                            <img src="images/linkedin.png" alt="LinkedIn" class="transition-transform duration-500 ease-out transform hover:scale-110 w-6 h-6">
                        </a>
                        <a href="mailto:example@example.com">
                            <img src="images/envelope.png" alt="Email" class="transition-transform duration-500 ease-out transform hover:scale-110 w-6 h-6">
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
