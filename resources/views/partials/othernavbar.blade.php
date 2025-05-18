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
        <img src="images/logo2.png" alt="SRE Logo" class="h-20 md:h-20 mr-2">
    </div>

    <!-- Hamburger Menu Button -->
    <button id="hamburgerButton" class="md:hidden text-3xl text-[#104334] focus:outline-none z-50">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Overlay for mobile (click to close) -->
    <div id="mobileOverlay" class="fixed inset-0 bg-black bg-opacity-30 hidden z-40"></div>

    <!-- Navbar -->
    <ul id="navbar" class="hidden flex-col absolute top-20 right-4 bg-white text-[#104334] space-y-4 text-base uppercase items-start rounded-lg p-4 shadow-lg md:static md:flex md:flex-row md:space-y-0 md:space-x-12 md:bg-transparent md:p-0 md:shadow-none md:items-center opacity-0 transform -translate-y-10 transition-all duration-1000 delay-500 z-50">
        <li><a href="/" class="hover:text-green-500">Home</a></li>
        <span class="hidden md:inline">|</span>
        <li><a href="/AboutUs" class="hover:text-green-500">About Us</a></li>
        <span class="hidden md:inline">|</span>
        <li class="relative">
            <button id="dropdownButton" class="hover:text-green-500 uppercase focus:outline-none">Programs</button>
            <ul id="dropdownMenu" class="font-onest hidden md:absolute bg-white text-[#104334] mt-2 w-30 py-2 shadow-lg rounded-lg z-50">
                <li><a href="/Activity" class="block px-4 py-2 hover:bg-gray-200">Activity</a></li>
                <li><a href="/Research" class="block px-4 py-2 hover:bg-gray-200">Research</a></li>
                <li><a href="/Competition" class="block px-4 py-2 hover:bg-gray-200">Competition</a></li>
            </ul>
        </li>
    </ul>
</nav>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const logo = document.getElementById("logo");
    const navbar = document.getElementById("navbar");
    const hamburgerButton = document.getElementById("hamburgerButton");
    const dropdownButton = document.getElementById("dropdownButton");
    const dropdownMenu = document.getElementById("dropdownMenu");
    const mobileOverlay = document.getElementById("mobileOverlay");

    // Animate logo and navbar on load
    logo.classList.remove("opacity-0", "-translate-x-20");
    setTimeout(() => {
        navbar.classList.remove("opacity-0", "-translate-y-10");
    }, 1000);

    // Hamburger toggle
    hamburgerButton.addEventListener('click', function () {
        navbar.classList.toggle('hidden');
        mobileOverlay.classList.toggle('hidden');
    });

    // Dropdown toggle
    dropdownButton.addEventListener('click', function (e) {
        e.stopPropagation();
        dropdownMenu.classList.toggle('hidden');
    });

    // Close dropdown when clicking elsewhere
    document.addEventListener('click', function () {
        dropdownMenu.classList.add('hidden');
    });

    // Prevent dropdown from closing when clicking inside
    dropdownMenu.addEventListener('click', function (e) {
        e.stopPropagation();
    });

    // Close navbar if overlay clicked
    mobileOverlay.addEventListener('click', function () {
        navbar.classList.add('hidden');
        mobileOverlay.classList.add('hidden');
    });

    // Optional smooth scroll buttons
    const joinUsBtn = document.getElementById('joinUsButton');
    const scrollDownBtn = document.getElementById('scrollDownButton');

    if (joinUsBtn) {
        joinUsBtn.addEventListener('click', function () {
            window.scrollTo({ top: window.innerHeight, behavior: 'smooth' });
        });
    }

    if (scrollDownBtn) {
        const section = document.getElementById('teamSection');
        scrollDownBtn.addEventListener('click', function () {
            if (section) {
                section.scrollIntoView({ behavior: 'smooth' });
            }
        });
    }
});
</script>
