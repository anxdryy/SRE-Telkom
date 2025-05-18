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
        <button id="hamburgerButton" class="lg:hidden text-black text-2xl focus:outline-none ml-4">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Desktop Nav -->
        <ul id="navbar" class="hidden lg:flex text-black space-x-4 lg:space-x-12 text-lg uppercase items-center">
            <li><a href="/Home" class="hover:text-green-500">Home</a></li>
            <span class="ml-2 hidden md:inline">|</span>
            <li><a href="/aboutUs" class="hover:text-green-500">About Us</a></li>
            <span class="ml-2 hidden md:inline">|</span>
            <li class="relative">
                <button id="desktopDropdownButton" class="hover:text-green-500 uppercase focus:outline-none">Programs</button>
                <ul id="desktopDropdownMenu" class="hidden absolute bg-white text-black mt-2 w-30 py-2 shadow-lg rounded-lg">
                    <li><a href="#" class="block px-1 py-2 hover:bg-gray-200">Activity</a></li>
                    <li><a href="/Research" class="block px-1 py-2 hover:bg-gray-200">Research</a></li>
                    <li><a href="/Competition" class="block px-1 py-2 hover:bg-gray-200">Competition</a></li>
                </ul>
            </li>

        </ul>
    </nav>

    <!-- Mobile Menu -->
    <div id="mobileMenu" class="fixed inset-0 bg-white/70  pt-20 px-4 hidden z-40">
        <ul class="space-y-6 text-2xl">
            <li><a href="/" class="block py-3 border-b border-gray-200 hover:text-green-500">Home</a></li>
            <li><a href="/AboutUs" class="block py-3 border-b border-gray-200 hover:text-green-500">About Us</a></li>
            <li class="relative">
                <button id="mobileDropdownBtn"
                    class="block py-3 border-b border-gray-200 w-full text-left hover:text-green-500">Programs <i
                        class="fas fa-chevron-down float-right mt-1"></i></button>
                <ul id="mobileDropdown" class="hidden pl-4 space-y-3 mt-2">
                    <li><a href="#" ss="block py-2 hover:text-green-500">Activity</a></li>
                    <li><a href="/Research" class="block py-2 hover:text-green-500">Research</a></li>
                    <li><a href="/Competition" class="block py-2 hover:text-green-500">Competition</a></li>
                </ul>
            </li>
        </ul>
    </div>
    <!-- Programs Section -->
    <main class="max-w-4xl mx-auto mt-40 px-4 md:px-0">
        <div class="text-center mb-6">
            <h2 class="text-xl md:text-2xl font-semibold text-gray-400">Programs</h2>
            <div class="mt-2 flex flex-col md:flex-row justify-center items-center space-y-2 md:space-y-0 md:space-x-4">
                <span class="text-gray-400 text-2xl md:text-4xl">Activity</span>
                <span class="text-black font-bold text-2xl md:text-4xl">Competition</span>
                <span class="text-gray-400 text-2xl md:text-4xl">Research</span>
            </div>
        </div>

        <div class="space-y-6 mt-8 md:mt-14">
            <!-- Card Items -->
            <a href="/News"
   class="block focus:outline-none focus:ring-4 focus:ring-green-300 rounded-lg transition duration-300">
   <div
      class="bg-white shadow-md rounded-lg overflow-hidden flex flex-col md:flex-row border-4 md:border-8 border-[#21735B] hover:border-green-700 transition duration-300 w-full md:w-[700px] lg:w-[900px] mx-auto">
      <img src="images/Programs.png" alt="Sekolah Kepresidenan"
           class="w-full md:w-80 h-48 md:h-44 object-cover">
      <div class="p-4 md:p-6 flex-1">
         <h3 class="text-lg font-semibold text-gray-800">
            Sekolah <span class="text-green-500">Kepresidenan</span>
         </h3>
         <p class="text-gray-600 mt-2 text-sm">
            Vorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc vulputate libero et velit
            interdum, ac aliquet odio mattis.
         </p>
      </div>
   </div>
</a>

            <!-- Repeat similar card structure for other items -->
            <a href="/News"
   class="block focus:outline-none focus:ring-4 focus:ring-green-300 rounded-lg transition duration-300">
   <div
      class="bg-white shadow-md rounded-lg overflow-hidden flex flex-col md:flex-row border-4 md:border-8 border-[#21735B] hover:border-green-700 transition duration-300 w-full md:w-[700px] lg:w-[900px] mx-auto">
      <img src="images/Programs.png" alt="Sekolah Kepresidenan"
           class="w-full md:w-80 h-48 md:h-44 object-cover">
      <div class="p-4 md:p-6 flex-1">
         <h3 class="text-lg font-semibold text-gray-800">
            Sekolah <span class="text-green-500">Kepresidenan</span>
         </h3>
         <p class="text-gray-600 mt-2 text-sm">
            Vorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc vulputate libero et velit
            interdum, ac aliquet odio mattis.
         </p>
      </div>
   </div>
</a>


            <!-- Card Items -->
            <a href="/News"
   class="block focus:outline-none focus:ring-4 focus:ring-green-300 rounded-lg transition duration-300">
   <div
      class="bg-white shadow-md rounded-lg overflow-hidden flex flex-col md:flex-row border-4 md:border-8 border-[#21735B] hover:border-green-700 transition duration-300 w-full md:w-[700px] lg:w-[900px] mx-auto">
      <img src="images/Programs.png" alt="Sekolah Kepresidenan"
           class="w-full md:w-80 h-48 md:h-44 object-cover">
      <div class="p-4 md:p-6 flex-1">
         <h3 class="text-lg font-semibold text-gray-800">
            Sekolah <span class="text-green-500">Kepresidenan</span>
         </h3>
         <p class="text-gray-600 mt-2 text-sm">
            Vorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc vulputate libero et velit
            interdum, ac aliquet odio mattis.
         </p>
      </div>
   </div>
</a>

            <div class="text-center mt-8">
                <p class="text-gray-500">
                    Page <span class="font-bold text-black">1</span> 2 ... 7
                </p>
            </div>
        </div>
    </main>

    <!-- Footer Section -->
    <footer class="relative bg-[#104334] text-white pt-[60px] md:pt-[90px] pb-8 md:pb-16 px-8 md:px-16 z-0 overflow-visible mt-48">
        <!-- Trees overflowing upwards -->
        <div class="absolute top-0 left-0 w-full h-[120px] md:h-[180px] -translate-y-[60%] md:-translate-y-[60%] z-10">
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
                    <div class="flex grid grid-cols-3 gap-3 ">
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

  // Close mobile menu when clicking outside (on overlay)
    mobileMenu.addEventListener('click', (e) => {
    // Close only if the user clicks directly on the background (not inside the menu)
    if (e.target === mobileMenu) {
        mobileMenu.classList.add('hidden');
    }
    });
    </script>

</body>

</html>