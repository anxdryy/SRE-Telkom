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
            <li><a href="/aboutUs" class="hover:text-green-500">About Us</a></li>
            <span class="ml-2 hidden md:inline">|</span>
            <li class="relative">
                <button id="desktopDropdownButton"
                    class="hover:text-green-500 uppercase focus:outline-none">Programs</button>
                <ul id="desktopDropdownMenu"
                    class="hidden absolute bg-white text-black mt-2 w-30 py-2 shadow-lg rounded-lg">
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
            <li><a href="/aboutUs" class="block py-3 border-b border-gray-200 hover:text-green-500">About Us</a></li>
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

    <!-- Content Section -->
    <main class="max-w-3xl mx-auto mt-44 px-4">

        <!-- Header -->
        <div class="flex items-start justify-between mb-4">
            <div class="flex items-start space-x-2">
                <a href="javascript:history.back()">
                    <svg class="w-8 h-8 text-black animate-bounce cursor-pointer hover:text-green-600 transition duration-300"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>

                <div>
                    <h1 class="text-lg sm:text-xl font-bold">Teaching Students : <span
                            class="text-black">Renewable?</span></h1>
                    <p class="text-gray-500 font-semibold">13 Februari 2025 04:08</p>
                </div>
            </div>

            <a href="https://instagram.com" target="_blank">
                <button
                    class="flex items-center bg-[#21735B] text-white text-sm px-4 py-1.5 rounded-full shadow hover:bg-[#1e604c] transition-transform duration-500 ease-in-out hover:scale-110">
                    <img src="images/instagram.png" alt="Instagram" class="w-7 h-7 mr-2 ">
                    <span class="-ml-1">Read More</span>
                </button>
            </a>

        </div>

        <!-- Image -->
        <div class="rounded-2xl overflow-hidden">
            <img src="images/Programs.png" alt="Sekolah Kepresidenan" class="w-full h-auto object-cover">
        </div>

        <!-- Description -->
        <div class="mt-6 font-semibold leading-relaxed text-gray-800 space-y-4 text-justify">
            <p>
                Horem ipsum dolor sit amet, consectetur adipiscing elit. Etiam eu turpis molestie, dictum est a, mattis
                tellus. Sed dignissim, metus nec fringilla accumsan, risus sem sollicitudin lacus, ut interdum tellus
                elit sed risus. Maecenas eget condimentum velit, sit amet feugiat lectus. Class aptent taciti sociosqu
                ad litora torquent per conubia nostra, per inceptos himenaeos. Praesent auctor purus luctus enim
                egestas, ac scelerisque ante pulvinar. Donec ut rhoncus ex. Suspendisse ac rhoncus nisl, eu tempor urna.
                Curabitur vel bibendum lorem. Morbi convallis convallis diam sit amet lacinia. Aliquam in elementum
                tellus.
            </p>
            <p class="indent-8">
                Curabitur tempor quis eros tempus lacinia. Nam bibendum pellentesque quam a convallis. Sed ut vulputate
                nisi. Integer in felis sed leo vestibulum venenatis. Suspendisse quis arcu sem. Aenean feugiat ex eu
                vestibulum vestibulum. Morbi a eleifend magna. Nam metus lacus, porttitor eu mauris a, blandit ultrices
                nibh. Mauris sit amet magna non ligula vestibulum eleifend. Nulla varius volutpat turpis sed lacinia.
                Nam eget mi in purus lobortis eleifend. Sed nec ante dictum sem condimentum ullamcorper quis venenatis
                nisi. Proin vitae facilisis nisi, ac posuere leo.
            </p>
        </div>
    </main>

    <!-- Tree Background -->
    <div class="relative w-full h-[200px] md:h-[300px] overflow-hidden">
        <img src="images/tree2.png" alt="Forest Design"
            class="absolute bottom-[-70px] left-0 w-full h-auto min-h-[200px] object-cover z-20 ">
    </div>

    <!-- Footer Section -->
    <footer class="relative bg-[#104334] text-white py-12 md:py-16 px-6 md:px-16 z-30 -mt-10">
        <div class="container mx-auto flex flex-col md:flex-row justify-between items-start">
            <!-- Left: Logo and Description -->
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
