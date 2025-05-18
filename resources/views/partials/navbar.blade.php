<nav class="absolute top-8 left-0 w-full flex justify-between items-center px-4 md:px-12 text-white">
            <div id="logo" class="flex items-center font-bold opacity-0 transform -translate-x-20 transition-all duration-1000 ml-8">
                <img src="images/logo1.png" alt="SRE Logo" class="h-16 md:h-24 mr-2">
            </div>

            <!-- Hamburger Menu Button -->
            <button id="hamburgerButton" class="hamburger md:hidden">
                <i class="fas fa-bars"></i>
            </button>

            <ul id="navbar" class="text-white flex space-x-12 text-lg uppercase items-center opacity-0 transform -translate-y-10 transition-all duration-1000 delay-500">
                <li><a href="/" class="hover:text-green-500">Home</a></li>
                <span class="ml-2">|</span>
                <li><a href="/AboutUs" class="hover:text-green-500">About Us</a></li>
                <span class="ml-2">|</span>
                <li class="relative">
                    <button id="dropdownButton" class="hover:text-green-500 uppercase focus:outline-none">Programs</button>
                    <ul id="dropdownMenu" class="font-onest hidden absolute bg-white text-black mt-2 w-30 py-2 shadow-lg rounded-lg">
                        <li><a href="/Program" class="block px-1 py-2 hover:bg-gray-200">Activity</a></li>
                        <li><a href="/Research" class="block px-1 py-2 hover:bg-gray-200">Research</a></li>
                        <li><a href="/Competition" class="block px-1 py-2 hover:bg-gray-200">Competition</a></li>
                    </ul>
                </li>
            </ul>
        </nav>