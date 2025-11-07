<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Red+Hat+Display:wght@400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Red+Hat+Text:ital,wght@0,300..700;1,300..700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Onest:wght@100..900&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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

<body class="min-h-screen">

        @include('partials.othernavbar')

         <section class="text-center mt-32 md:mt-28 py-10">
        <h2 class="text-gray-600 text-2xl">About Us</h2>
        <h1 class="text-3xl md:text-4xl font-semibold">SRE Telkom University</h1>
    </section>

    <section class="relative flex flex-col lg:flex-row justify-center items-center py-10 gap-10">
    <!-- Energize -->
    <div class="flex items-center text-center rotate-0 lg:absolute lg:left-[222px] lg:top-[-40px] lg:ml-56 lg:rotate-[5.08deg]">
        <img src="images/innovate.png" class="w-[120px] h-[120px] lg:w-[180px] lg:h-[180px]">
        <p class="font-bold ml-2 text-xl lg:ml-4 lg:text-2xl lg:rotate-[-5.08deg]">Innovate</p>
    </div>

    <!-- Elevate -->
<div class="flex items-center justify-center text-center lg:scale-100 lg:rotate-[-7.26deg] lg:absolute lg:top-[290px] lg:-mt-48 xl:-ml-[850px] lg:-ml-[550px]">
    <img src="images/elevate.png" class="w-[200px] h-[200px] lg:w-[400px] lg:h-[400px] object-contain">
    <p class="font-bold ml-4 text-xl lg:ml-2 lg:mt-28 lg:text-2xl lg:rotate-[7.08deg]">Elevate</p>
</div>

    <!-- Energize -->
    <div class="flex items-center text-center rotate-0 lg:absolute md:right-[10px] xl:right-[340px] right-0 md:-top-[90px] lg:mt-36">
        <p class="font-bold mr-2 text-xl lg:mr-4 lg:text-2xl">Energize</p>
        <img src="images/Group 45.png" class="w-[140px] h-[130px] lg:w-[240px] lg:h-[220px]">
    </div>
</section>

    <!-- About SRE-TelU tetap di bawah -->
    <section class="relative bg-[#104334] text-white text-center p-3 md:p-10 mt-10 md:mt-72 z-10">
        <div class="my-16">
        <h2 class="font-bold font-redhat text-2xl md:text-3xl">About SRE-TelU</h2>
       <div class="flex justify-center">
       <p class="font-redhattext mt-6 text-justify justify-center text-2xl md:text-2xl  text-gray-200 max-w-[85%]">
            Founded in 2021, SRE Tel-U SRE Telkom University is one of the student chapters of the Society of Renewable
            Energy, based in Bandung. Our focus extends beyond renewable energy, emphasizing community empowerment and
            environmental sustainability through education, innovation, and collaboration.
        </p>
       </div>
        <button id="scrollDownButton" class="mt-12">
            <svg class="w-8 h-8 text-white animate-bounce" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>
        </div>
    </section>

    <section id="vision" class="text-center py-10 px-4 md:px-0">
        <!-- Vision -->
        <div class="text-center">
            <div class="flex justify-center gap-4">
            <h2 class="text-[#104334] tracking-wider font-redhat text-2xl md:text-3xl font-black flex justify-center items-center">
                VISION
            </h2>
                    <img src="images/leaf.png" alt="Leaf Icon" class="mt-2 w-6 h-6">

            </div>
            <p class="mt-4 max-w-[60%] mx-auto font-redhattext text-black font-[40%] text-2xl">
                SRE Telkom University as a developmental organization that empowers the youth in the field of New
                Renewable Energy (NRE) through collaborative projects, empowered members, and impactful initiatives to
                deliver sustainable contributions to society
            </p>
        </div>

        <!-- Mission -->
        <div class="text-center m-12 mb-8">
            <div class="flex justify-center gap-4">
            <h2 class="text-[#104334] tracking-wider font-redhat text-2xl md:text-3xl font-black flex justify-center items-center">
                MISSION
            </h2>
                    <img src="images/vector_tree.png" alt="Tree Icon" class="mt-2 w-6 h-6">

            </div>
            <div class="font-redhattext grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto mt-6 font-[40%]">
            <!-- Box 1 -->
            <div class="border-4 border-[#21735B] rounded-2xl p-4 md:p-6 text-center">
                <p class="text-gray-700 text-base md:text-lg">
                    <strong class="text-[#104334] text-xl md:text-xl">Empowering</strong> Youth collaborations, discussions, and
                    improvement to be involved in Renewable Energy Sustainability program.
                </p>
            </div>

            <!-- Box 2 -->
            <div class="border-4 border-[#21735B] rounded-2xl p-4 md:p-6 text-center">
                <p class="text-gray-700 text-base md:text-lg">
                    <strong class="text-[#104334] text-lg md:text-xl">Networking</strong> Through cohesion stakeholders
                    opportunities to provide insights into trends, challenges, and innovations in the industry.
                </p>
            </div>

            <!-- Box 3 -->
            <div class="border-4 border-[#21735B] rounded-2xl p-4 md:p-6 text-center">
                <p class="text-gray-700 text-base md:text-lg">
                    <strong class="text-[#104334] text-lg md:text-xl">Establishing</strong> Professional work environment while
                    fostering a sense of unity within the organization, in order to achieve shared goals and success.
                </p>
            </div>

            <!-- Box 4 -->
            <div class="border-4 border-[#21735B] rounded-2xl p-4 md:p-6 text-center">
                <p class="text-gray-700 text-base md:text-lg">
                    <strong class="text-[#104334] text-lg md:text-xl">Elevating</strong> Impact among youth awareness to support
                    the advancement of the renewable energy sector in Indonesia through educational campaigns and
                    movement.
                </p>
            </div>
        </div>
    </section>

    <section class="text-center py-10 px-4 md:px-0">
        <!-- Garis di atas judul -->
        <div class="w-[250px] md:w-[500px] border-t-4 border-[#104334] mx-auto mb-12"></div>

        <!-- Judul -->
        <h2 class="text-2xl md:text-3xl font-bold">
            Meet Our <span class="text-[#104334] font-bold">Core Team</span>
        </h2>

        <!-- Grid Segitiga (2-3-4-5) -->
        <div class="flex flex-col items-center mt-8 space-y-6 font-redhat">
            <!-- Row 1 (2 orang) -->
            <div class="flex flex-col gap-10 md:flex-row justify-center space-y-6 md:space-y-0 md:space-x-6">
                <div class="flex flex-col items-center">
                    <img src="images/coreperson.png"
                        class="w-48 md:w-60 h-60 md:h-72 rounded-3xl shadow-lg object-cover border-4 border-[#21735B]">
                    <p class="text-lg font-semibold mt-2">Fajar Dwitama</p>
                    <p class="text-lg font-bold text-green-900">President SRE</p>
                </div>
                <div class="flex flex-col items-center">
                    <img src="images/coreperson.png"
                        class="w-48 md:w-60 h-60 md:h-72 rounded-3xl shadow-lg object-cover border-4 border-[#21735B]">
                    <p class="text-lg font-semibold mt-2">Fajar Dwitama</p>
                    <p class="text-lg font-bold text-green-900">President SRE</p>
                </div>
            </div>

            <!-- Row 2 (3 orang) -->
            <div class="flex flex-col font-redhat gap-10 md:flex-row justify-center space-y-6 md:space-y-0 md:space-x-6">
                <div class="flex flex-col items-center">
                    <img src="images/coreperson.png"
                        class="w-48 md:w-60 h-60 md:h-72 rounded-3xl shadow-lg object-cover border-4 border-[#21735B]">
                    <p class="text-lg font-semibold mt-2">Fajar Dwitama</p>
                    <p class="text-lgfont-bold text-green-900">President SRE</p>
                </div>
                <div class="flex flex-col items-center">
                    <img src="images/coreperson.png"
                        class="w-48 md:w-60 h-60 md:h-72 rounded-3xl shadow-lg object-cover border-4 border-[#21735B]">
                    <p class="text-lg font-semibold mt-2">Fajar Dwitama</p>
                    <p class="text-lg font-bold text-green-900">President SRE</p>
                </div>
                <div class="flex flex-col items-center">
                    <img src="images/coreperson.png"
                        class="w-48 md:w-60 h-60 md:h-72 rounded-3xl shadow-lg object-cover border-4 border-[#21735B]">
                    <p class="text-lg font-semibold mt-2">Fajar Dwitama</p>
                    <p class="text-lg font-bold text-green-900">President SRE</p>
                </div>
            </div>
        </div>
    </section>

    <section class="flex justify-center items-center mt-8 bg-[#104334] p-6 py-10 md:p-10 relative">
        <div class="ml-[18%] py-10">
                <!-- Teks Vertikal di Samping (Lebih ke Kiri, di Luar Border) -->
            <div class="hidden md:block absolute -left-36 top-1/2 -translate-y-1/2 -rotate-90">
                <p class="mt-24 text-white text-4xl font-bold font-redhat tracking-wide">Organizational Structure</p>
            </div>

            <!-- Mobile Title -->
            <h2 class="md:hidden text-white text-2xl font-bold mb-4 text-center -ml-5">Organizational Structure</h2>

            <!-- Container dengan Border -->
            <div class="bg-white p-4 md:p-8 rounded-lg w-full md:w-[90%] max-w-6xl relative">
                <!-- Gambar Struktur Organisasi -->
                <img src="images/organigram 2.png" alt="Organizational Structure"
                    class="w-auto max-w-full h-auto mx-auto object-contain">
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
            @foreach ($departments as $dept)
                <a href="{{ url('departement/' . $dept->slug) }}">
                    <img src="{{ asset('storage/' . $dept->logo) }}" alt="{{ $dept['alt'] }}"
                        class="w-24 h-24 md:w-36 md:h-36 object-contain drop-shadow-[0px_4px_10px_rgba(0,0,0,0.6)] transition-transform duration-300 ease-in-out hover:scale-110">
                </a>
            @endforeach
        </div>
    </section>

    <div class="relative w-full bg-[#144A3A] text-white min-h-screen bottom-[-120px] p-6 md:p-20 flex flex-col">
        <h2 class="text-2xl font-redhat md:text-3xl font-bold mb-6 md:mb-12 text-center">Meet Our Alumnis</h2>
        <!-- Alumni Carousel -->
            @include('partials.carousel', ['alumnis' => $alumnis])

    </div>

        <!-- Footer Section -->
    <div class="mt-[-75px]"> 
        @include('partials.footer')
    </div>

</body>
</html>
