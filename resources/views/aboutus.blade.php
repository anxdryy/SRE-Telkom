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
    <!-- Navbar -->
    <nav class="absolute top-8 left-0 w-full flex justify-between items-center px-12 text-white z-40">
        <div id="logo" class="flex items-center font-bold ml-8">
            <img src="images/logo2.png" alt="SRE Logo" class="h-24 mr-2">
        </div>

        <!-- Hamburger Button -->
        <button id="hamburgerButton" class="md:hidden text-black text-2xl focus:outline-none ml-4">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Desktop Nav -->
        <ul id="navbar" class="hidden md:flex text-black space-x-4 lg:space-x-12 text-lg uppercase items-center">
            <li><a href="/Home" class="hover:text-green-500">Home</a></li>
            <span class="ml-2 hidden md:inline">|</span>
            <li><a href="#" class="hover:text-green-500">About Us</a></li>
            <span class="ml-2 hidden md:inline">|</span>
            <li class="relative">
                <button id="desktopDropdownButton" class="hover:text-green-500 uppercase focus:outline-none">Programs</button>
                <ul id="desktopDropdownMenu" class="hidden absolute bg-white text-black mt-2 w-30 py-2 shadow-lg rounded-lg">
                    <li><a href="/Program" class="block px-1 py-2 hover:bg-gray-200">Activity</a></li>
                    <li><a href="/Research" class="block px-1 py-2 hover:bg-gray-200">Research</a></li>
                    <li><a href="/Competition" class="block px-1 py-2 hover:bg-gray-200">Competition</a></li>
                </ul>
            </li>

        </ul>
    </nav>

    <!-- Mobile Menu -->
    <div id="mobileMenu" class="fixed inset-0 bg-white/70  pt-20 px-4 hidden z-40">
        <ul class="space-y-6 text-2xl">
            <li><a href="/Home" class="block py-3 border-b border-gray-200 hover:text-green-500">Home</a></li>
            <li><a href="#" class="block py-3 border-b border-gray-200 hover:text-green-500">About Us</a></li>
            <li class="relative">
                <button id="mobileDropdownBtn"
                    class="block py-3 border-b border-gray-200 w-full text-left hover:text-green-500">Programs <i
                        class="fas fa-chevron-down float-right mt-1"></i></button>
                <ul id="mobileDropdown" class="hidden pl-4 space-y-3 mt-2">
                    <li><a href="/Program" class="block py-2 hover:text-green-500">Activity</a></li>
                    <li><a href="/Research" class="block py-2 hover:text-green-500">Research</a></li>
                    <li><a href="/Competition" class="block py-2 hover:text-green-500">Competition</a></li>
                </ul>
            </li>
        </ul>
    </div>

    <section class="text-center mt-32 md:mt-28 py-10">
        <h2 class="text-gray-600 text-2xl">About Us</h2>
        <h1 class="text-3xl md:text-4xl font-semibold">SRE Telkom University</h1>
    </section>

    <section class="relative flex flex-col md:flex-row justify-center items-center py-10 gap-10">
    <!-- Elevate -->
    <div class="flex items-center text-center rotate-0 md:absolute md:left-[222px] md:top-[-40px] md:ml-56 md:rotate-[5.08deg]">
        <img src="images/Group 59.png" class="w-[120px] h-[120px] md:w-[180px] md:h-[180px]">
        <p class="font-bold ml-2 text-xl md:ml-4 md:text-2xl md:rotate-[-5.08deg]">Elevate</p>
    </div>

    <!-- Innovate -->
    <div class="flex items-center text-center rotate-0 md:scale-100 md:rotate-[-7.26deg] md:absolute md:top-[290px] md:-mt-48 md:-ml-[850px]">
    <img src="images/lampu.png" class="w-[200px] h-[280px] md:w-[380px] md:h-[350px] max-w-full max-h-full">
    <p class="font-bold ml-2 mt-20 text-xl md:mt-28 md:text-2xl md:rotate-[7.08deg]">Innovate</p>
</div>

    <!-- Energize -->
    <div class="flex items-center text-center rotate-0 md:absolute md:right-[340px] md:-top-[90px] md:mt-36">
        <p class="font-bold mr-2 text-xl md:mr-4 md:text-2xl">Energize</p>
        <img src="images/Group 45.png" class="w-[140px] h-[130px] md:w-[240px] md:h-[220px]">
    </div>
</section>


    <!-- About SRE-TelU tetap di bawah -->
    <section class="relative bg-green-900 text-white text-center p-6 md:p-10 mt-10 md:mt-72 z-10">
        <h2 class="font-bold text-2xl md:text-3xl">About SRE-TelU</h2>
        <p class="mt-6 text-lg md:text-3xl text-justify  text-gray-200 max-w-14xl">
            Founded in 2021, SRE Tel-U SRE Telkom University is one of the student chapters of the Society of Renewable
            Energy, based in Bandung. Our focus extends beyond renewable energy, emphasizing community empowerment and
            environmental sustainability through education, innovation, and collaboration.
        </p>
        <button id="scrollDownButton" class="mt-12">
            <svg class="w-8 h-8 text-white animate-bounce" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>
    </section>

    <section id="vision" class="text-center py-10 px-4 md:px-0">
        <!-- Vision -->
        <div class="text-center">
            <h2 class="text-[#104334] text-2xl md:text-3xl font-bold flex justify-center items-center">
                VISION
                <span class="inline-block ml-2">
                    <img src="images/leaf.png" alt="Leaf Icon" class="w-6 h-6">
                </span>
            </h2>
            <p class="mt-4 max-w-3xl mx-auto text-gray-700 text-base md:text-lg">
                SRE Telkom University as a developmental organization that empowers the youth in the field of New
                Renewable Energy (NRE) through collaborative projects, empowered members, and impactful initiatives to
                deliver sustainable contributions to society
            </p>
        </div>

        <!-- Mission -->
        <h2 class="text-[#104334] text-2xl md:text-3xl font-bold mt-10">MISSION <span class="inline-block ml-2">
                <img src="images/tree.png" alt="Leaf Icon" class="w-6 h-6">
            </span>
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto mt-6">
            <!-- Box 1 -->
            <div class="border-4 border-[#21735B] rounded-2xl p-4 md:p-6 text-center">
                <p class="text-gray-700 text-base md:text-lg">
                    <strong class="text-[#104334] text-lg md:text-xl">Empowering</strong> Youth collaborations, discussions, and
                    improvement to be involved in Renewable Energy Sustainability program.
                </p>
            </div>

            <!-- Box 2 -->
            <div class="border-4 border-[#21735B] rounded-2xl p-4 md:p-6 text-center">
                <p class="text-gray-700 text-base md:text-lg">
                    <strong class="text-[#104334] text-lg md:text-xl">Networking</strong> through cohesion stakeholders
                    opportunities to provide insights into trends, challenges, and innovations in the industry.
                </p>
            </div>

            <!-- Box 3 -->
            <div class="border-4 border-[#21735B] rounded-2xl p-4 md:p-6 text-center">
                <p class="text-gray-700 text-base md:text-lg">
                    <strong class="text-[#104334] text-lg md:text-xl">Establishing</strong> professional work environment while
                    fostering a sense of unity within the organization, in order to achieve shared goals and success.
                </p>
            </div>

            <!-- Box 4 -->
            <div class="border-4 border-[#21735B] rounded-2xl p-4 md:p-6 text-center">
                <p class="text-gray-700 text-base md:text-lg">
                    <strong class="text-[#104334] text-lg md:text-xl">Elevating</strong> impact among youth awareness to support
                    the advancement of the renewable energy sector in Indonesia through educational campaigns and
                    movement.
                </p>
            </div>
        </div>
    </section>

    <section class="text-center py-10 px-4 md:px-0">
        <!-- Garis di atas judul -->
        <div class="w-[250px] md:w-[500px] border-t-2 border-[#104334] mx-auto mb-2"></div>

        <!-- Judul -->
        <h2 class="text-xl md:text-2xl font-semibold">
            Meet Our <span class="text-green-600 font-bold">Core Team</span>
        </h2>

        <!-- Grid Segitiga (2-3-4-5) -->
        <div class="flex flex-col items-center mt-8 space-y-6">
            <!-- Row 1 (2 orang) -->
            <div class="flex flex-col md:flex-row justify-center space-y-6 md:space-y-0 md:space-x-6">
                <div class="flex flex-col items-center">
                    <img src="images/sre.jpeg"
                        class="w-48 md:w-60 h-60 md:h-72 rounded-lg shadow-lg object-cover border-4 border-[#21735B]">
                    <p class="font-semibold mt-2">Fajar Dwitama</p>
                    <p class="text-sm font-bold text-green-900">President SRE</p>
                </div>
                <div class="flex flex-col items-center">
                    <img src="images/sre.jpeg"
                        class="w-48 md:w-60 h-60 md:h-72 rounded-lg shadow-lg object-cover border-4 border-[#21735B]">
                    <p class="font-semibold mt-2">Fajar Dwitama</p>
                    <p class="text-sm font-bold text-green-900">President SRE</p>
                </div>
            </div>

            <!-- Row 2 (3 orang) -->
            <div class="flex flex-col md:flex-row justify-center space-y-6 md:space-y-0 md:space-x-6">
                <div class="flex flex-col items-center">
                    <img src="images/sre.jpeg"
                        class="w-48 md:w-60 h-60 md:h-72 rounded-lg shadow-lg object-cover border-4 border-[#21735B]">
                    <p class="font-semibold mt-2">Fajar Dwitama</p>
                    <p class="text-sm font-bold text-green-900">President SRE</p>
                </div>
                <div class="flex flex-col items-center">
                    <img src="images/sre.jpeg"
                        class="w-48 md:w-60 h-60 md:h-72 rounded-lg shadow-lg object-cover border-4 border-[#21735B]">
                    <p class="font-semibold mt-2">Fajar Dwitama</p>
                    <p class="text-sm font-bold text-green-900">President SRE</p>
                </div>
                <div class="flex flex-col items-center">
                    <img src="images/sre.jpeg"
                        class="w-48 md:w-60 h-60 md:h-72 rounded-lg shadow-lg object-cover border-4 border-[#21735B]">
                    <p class="font-semibold mt-2">Fajar Dwitama</p>
                    <p class="text-sm font-bold text-green-900">President SRE</p>
                </div>
            </div>
        </div>
    </section>

    <section class="flex justify-center items-center bg-green-900 p-6 md:p-10 relative">
        <!-- Teks Vertikal di Samping (Lebih ke Kiri, di Luar Border) -->
        <div class="hidden md:block absolute -left-36 top-1/2 -translate-y-1/2 -rotate-90">
            <p class="text-white text-4xl font-bold tracking-wide">Organizational Structure</p>
        </div>

        <!-- Mobile Title -->
        <h2 class="md:hidden text-white text-2xl font-bold mb-4 text-center -ml-5">Organizational Structure</h2>

        <!-- Container dengan Border -->
        <div class="bg-white p-4 md:p-8 rounded-lg w-full md:w-[90%] max-w-6xl relative">
            <!-- Gambar Struktur Organisasi -->
            <img src="images/organigram 2.png" alt="Organizational Structure"
                class="w-auto max-w-full h-auto mx-auto object-contain">
        </div>
    </section>

    <section class="flex flex-col md:flex-row items-center justify-between px-6 md:px-10 py-10">
        <!-- Bagian Kiri (Teks) -->
        <div class="w-full md:w-1/3 mb-6 md:mb-0">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 flex items-center">
                Our <span class="text-green-700 ml-2">Departments</span>
            </h2>
            <div class="w-16 h-1 bg-gray-500 mt-2"></div>
            <p class="text-gray-700 mt-4 text-base md:text-lg font-bold">
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

    <div class="relative w-full bg-[#144A3A] text-white min-h-screen bottom-[-20px] p-6 md:p-20 flex flex-col">
        <h2 class="text-2xl md:text-3xl font-bold mb-6 md:mb-12 underline text-center">Meet Our Alumnis</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pb-20 md:pb-40 relative">
            <!-- Tombol Navigasi Kiri -->
            <button id="prev"
                class="absolute left-0 md:left-5 top-1/2 md:mt-52 bg-white text-black p-2 rounded-full shadow-lg hover:bg-gray-200 transform -translate-y-1/2 md:translate-y-0">
                <img src="https://img.icons8.com/ios-filled/50/000000/chevron-left.png" alt="Left Arrow"
                    class="w-6 h-6">
            </button>

            <!-- Card 1 -->
            <div class="bg-white text-black border border-gray-300 rounded-2xl overflow-hidden shadow-lg">
                <div class="relative">
                    <img src="images/sre1.jpeg" alt="Event 1" class="w-full h-full object-cover aspect-square">
                    <div class="absolute bottom-0 w-full bg-black bg-opacity-60 text-white p-4 md:p-6 text-center">
                        <p class="text-xs">Presiden of China Entertainment</p>
                        <h3 class="text-sm md:text-base font-bold">Fajar Dwitama</h3>
                    </div>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="bg-white text-black border border-gray-300 rounded-2xl overflow-hidden shadow-lg">
                <div class="relative">
                    <img src="images/sre2.jpeg" alt="Event 2" class="w-full h-full object-cover aspect-square">
                    <div class="absolute bottom-0 w-full bg-black bg-opacity-60 text-white p-4 md:p-6 text-center">
                        <p class="text-xs">08 October 2024</p>
                        <h3 class="text-sm md:text-base font-bold">Teaching Students : Renewable?</h3>
                    </div>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="bg-white text-black border border-gray-300 rounded-2xl overflow-hidden shadow-lg">
                <div class="relative">
                    <img src="images/sre3.jpeg" alt="Event 3" class="w-full h-full object-cover aspect-square">
                    <div class="absolute bottom-0 w-full bg-black bg-opacity-60 text-white p-4 md:p-6 text-center">
                        <p class="text-xs">28 December 2024</p>
                        <h3 class="text-sm md:text-base font-bold">Sun-Powered Generators with Local Highschool</h3>
                    </div>
                </div>
            </div>

            <!-- Tombol Navigasi Kanan -->
            <button id="next"
                class="absolute right-0 md:right-5 top-1/2 md:mt-52 bg-white text-black p-2 rounded-full shadow-lg hover:bg-gray-200 transform -translate-y-1/2 md:translate-y-0">
                <img src="https://img.icons8.com/ios-filled/50/000000/chevron-right.png" alt="Right Arrow"
                    class="w-6 h-6">
            </button>
        </div>
    </div>

    <!-- Tree Background (Letakkan sebelum Footer) -->
    <div class="relative w-full">
        <img src="images/tree2.png" alt="Forest Design" class="absolute bottom-[-130px] left-0 w-full z-10">
    </div>

    <!-- Footer Section -->
    <footer class="relative bg-[#104334] text-white py-10 md:py-16 px-6 md:px-16 z-10 bottom-[-10px]">
        <div class="container mx-auto flex flex-col md:flex-row justify-between items-start relative">
            <!-- Kiri: Logo dan Deskripsi -->
            <div class="w-full md:w-1/3 mb-8 md:mb-0">
                <img src="images/logo1.png" alt="SRE Universitas Telkom" class="w-auto h-12 md:h-auto">
                <p class="mt-2 text-sm text-gray-300">
                    Society of Renewable Energy is a student organization dedicated to promoting new and renewable
                    energy advancements across Indonesia.
                </p>
                <p class="mt-4 md:mt-6 text-gray-400 text-xs">COPYRIGHT © SRE Telkom University 2024</p>
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
                            <img src="images/instagram.png" alt="Instagram"
                                class=" transition-transform duration-500 ease-out transform hover:scale-110 w-6 h-6">
                        </a>
                        <a href="https://line.me" target="_blank">
                            <img src="images/vector.png" alt="Line"
                                class=" transition-transform duration-500 ease-out transform hover:scale-110 w-6 h-6">
                        </a>
                        <a href="https://youtube.com" target="_blank">
                            <img src="images/youtube.png" alt="YouTube"
                                class=" transition-transform duration-500 ease-out transform hover:scale-110 w-6 h-6">
                        </a>
                        <a href="https://linkedin.com" target="_blank">
                            <img src="images/linkedin.png" alt="LinkedIn"
                                class=" transition-transform duration-500 ease-out transform hover:scale-110 w-6 h-6">
                        </a>
                        <a href="mailto:example@example.com">
                            <img src="images/envelope.png" alt="Email"
                                class=" transition-transform duration-500 ease-out transform hover:scale-110 w-6 h-6">
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

    <script>
         document.getElementById('scrollDownButton').addEventListener('click', function () {
            document.getElementById('vision').scrollIntoView({
                behavior: 'smooth'
            });
        });

       // Mobile menu toggle
 const hamburgerBtn = document.getElementById('hamburgerButton');
  const mobileMenu = document.getElementById('mobileMenu');

  if (hamburgerBtn && mobileMenu) {
    hamburgerBtn.addEventListener('click', () => {
      mobileMenu.classList.toggle('hidden');
    });
  }

  // Mobile dropdown toggle
  const mobileDropdownBtn = document.getElementById('mobileDropdownBtn');
  const mobileDropdown = document.getElementById('mobileDropdown');

  if (mobileDropdownBtn && mobileDropdown) {
    mobileDropdownBtn.addEventListener('click', () => {
      mobileDropdown.classList.toggle('hidden');
    });
  }

  // Desktop dropdown toggle
  const desktopDropdownBtn = document.getElementById('desktopDropdownButton');
  const desktopDropdownMenu = document.getElementById('desktopDropdownMenu');

  if (desktopDropdownBtn && desktopDropdownMenu) {
    desktopDropdownBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      desktopDropdownMenu.classList.toggle('hidden');
    });

    document.addEventListener('click', () => {
      desktopDropdownMenu.classList.add('hidden');
    });
  }

  // Close mobile menu when clicking a link
  const mobileLinks = document.querySelectorAll('#mobileMenu a');
  mobileLinks.forEach(link => {
    link.addEventListener('click', () => {
      mobileMenu.classList.add('hidden');
    });
  });
    </script>
</body>
</html>
