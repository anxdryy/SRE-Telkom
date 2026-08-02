<!-- Fonts -->
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
</style>

<!-- NAVIGATION -->
<nav class="absolute top-8 left-0 w-full flex justify-between items-center md:px-12 text-white px-4 z-50">
    <div id="logo" class="flex items-center font-bold opacity-0 transform -translate-x-20 transition-all duration-1000">
        <img src="{{ asset('images/logo2.png') }}" alt="SRE Logo" class="h-20 md:h-20 mr-2">
    </div>

    <!-- Hamburger Menu Button -->
    <button id="hamburgerButton" type="button" aria-label="Toggle menu" aria-expanded="false" aria-controls="mobileMenu" class="md:hidden text-3xl text-[#104334] focus:outline-none z-50">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Overlay for mobile (click to close) -->
    <div id="mobileOverlay" class="fixed inset-0 bg-black bg-opacity-30 hidden z-40"></div>

    <!-- Desktop Navbar -->
    <ul id="navbar" class="hidden md:flex flex-col md:flex-row absolute md:static top-20 right-4 bg-white text-[#104334] space-y-4 md:space-y-0 md:space-x-12 text-base uppercase items-start md:items-center rounded-lg p-4 md:p-0 shadow-lg md:shadow-none md:bg-transparent opacity-0 transform -translate-y-10 transition-all duration-1000 delay-500 z-50">
        <li><a href="/" class="hover:text-green-500">Home</a></li>
        <span class="hidden md:inline">|</span>
        <li><a href="/AboutUs" class="hover:text-green-500">About Us</a></li>
        <span class="hidden md:inline">|</span>
        <li class="relative">
            <button id="dropdownButton" type="button" aria-haspopup="true" aria-expanded="false" aria-controls="dropdownMenu" class="hover:text-green-500 uppercase focus:outline-none">Programs</button>
            <ul id="dropdownMenu" class="font-onest hidden md:absolute bg-white text-[#104334] mt-2 w-30 py-2 shadow-lg rounded-lg z-50">
                <li><a href="/Activity" class="block px-4 py-2 hover:bg-gray-200">Activity</a></li>
                <li><a href="/Research" class="block px-4 py-2 hover:bg-gray-200">Research</a></li>
                <li><a href="/Competition" class="block px-4 py-2 hover:bg-gray-200">Competition</a></li>
            </ul>
        </li>
    </ul>
</nav>

<!-- Mobile Menu -->
<div id="mobileMenu" class="bg-opacity-95 fixed inset-0 bg-white pt-20 px-4 hidden z-50 shadow-lg pointer-events-auto">
    <ul class="space-y-6 text-2xl text-[#104334] uppercase">
        <li><a href="/" class="block py-3 border-b border-gray-200 hover:text-green-500">Home</a></li>
        <li><a href="/AboutUs" class="block py-3 border-b border-gray-200 hover:text-green-500">About Us</a></li>
        <li class="relative">
            <button
                id="mobileDropdownBtn"
                type="button"
                aria-haspopup="true"
                aria-expanded="false"
                aria-controls="mobileDropdown"
                class="uppercase py-3 w-full border-b border-gray-200 text-left hover:text-green-500 flex justify-between items-center"
            >
                Programs 
                <i id="mobileDropdownIcon" class="fas fa-chevron-down ml-2 transition-transform duration-300 ease-in-out"></i>
            </button>
            <ul id="mobileDropdown" class="hidden pl-4 space-y-3 mt-2 border-l-2 border-green-500">
                <li><a href="/Activity" class="block py-2 hover:text-green-500">Activity</a></li>
                <li><a href="/Research" class="block py-2 hover:text-green-500">Research</a></li>
                <li><a href="/Competition" class="block py-2 hover:text-green-500">Competition</a></li>
            </ul>
        </li>
    </ul>
</div>

<!-- JavaScript -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const logo = document.getElementById("logo");
    const navbar = document.getElementById("navbar");
    const hamburgerButton = document.getElementById("hamburgerButton");
    const dropdownButton = document.getElementById("dropdownButton");
    const dropdownMenu = document.getElementById("dropdownMenu");
    const mobileOverlay = document.getElementById("mobileOverlay");
    const mobileMenu = document.getElementById('mobileMenu');
    const mobileDropdownBtn = document.getElementById('mobileDropdownBtn');
    const mobileDropdown = document.getElementById('mobileDropdown');
    const mobileDropdownIcon = document.getElementById('mobileDropdownIcon');

    // Animate logo and navbar on load
    logo.classList.remove("opacity-0", "-translate-x-20");
    setTimeout(() => {
        navbar.classList.remove("opacity-0", "-translate-y-10");
    }, 1000);

    // Desktop dropdown toggle
    dropdownButton?.addEventListener('click', function (e) {
        e.stopPropagation();
        const isOpen = dropdownMenu.classList.toggle('hidden') === false;
        dropdownButton.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    });

    document.addEventListener('click', function () {
        dropdownMenu.classList.add('hidden');
        dropdownButton?.setAttribute('aria-expanded', 'false');
    });

    dropdownMenu?.addEventListener('click', function (e) {
        e.stopPropagation();
    });

    // Hamburger opens mobileMenu
    hamburgerButton?.addEventListener('click', function () {
        const isOpen = mobileMenu.classList.toggle('hidden') === false;
        mobileOverlay.classList.toggle('hidden');
        hamburgerButton.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    });

    // Overlay click closes mobile menu
    mobileOverlay?.addEventListener('click', function () {
        mobileMenu.classList.add('hidden');
        mobileOverlay.classList.add('hidden');
        hamburgerButton?.setAttribute('aria-expanded', 'false');
    });

    // Mobile dropdown toggle with icon rotation
    if (mobileDropdownBtn && mobileDropdown && mobileDropdownIcon) {
        mobileDropdownBtn.addEventListener('click', () => {
            const isOpen = !mobileDropdown.classList.contains('hidden');
            mobileDropdown.classList.toggle('hidden');
            mobileDropdownIcon.classList.toggle('rotate-180', !isOpen);
            mobileDropdownBtn.setAttribute('aria-expanded', (!isOpen) ? 'true' : 'false');
        });
    }

    // Close mobile menu when clicking a link
    const mobileLinks = document.querySelectorAll('#mobileMenu a');
    mobileLinks.forEach(link => {
        link.addEventListener('click', () => {
            mobileMenu.classList.add('hidden');
            mobileOverlay.classList.add('hidden');
            hamburgerButton?.setAttribute('aria-expanded', 'false');
        });
    });

    // Close mobile menu if clicking outside its inner content
    mobileMenu.addEventListener('click', function (event) {
    // If user clicked directly on the background (not a child element like a <li> or <button>)
    if (event.target === mobileMenu) {
        mobileMenu.classList.add('hidden');
        mobileOverlay.classList.add('hidden');
        hamburgerButton?.setAttribute('aria-expanded', 'false');
    }
    });

});
</script>
