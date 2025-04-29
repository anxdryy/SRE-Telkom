<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.lordicon.com/lordicon.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>SRE Telkom University</title>
    <style>
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease-in-out;
                position: fixed;
                z-index: 40;
                height: 100vh;
            }
            .sidebar.open {
                transform: translateX(0);
            }
            .overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(0,0,0,0.5);
                z-index: 30;
            }
            .overlay.open {
                display: block;
            }
        }
    </style>
</head>

<body class="min-h-screen bg-gray-200 flex flex-col">
    <!-- Mobile Header -->
    <div class="md:hidden bg-white shadow-md p-4 flex justify-between items-center z-30">
        <div class="flex items-center">
            <button id="hamburgerBtn" class="mr-4 text-gray-700">
                <i class="fas fa-bars text-xl"></i>
            </button>
            <img src="/images/logo2.png" alt="SRE Logo" class="h-12">
        </div>
        <button>
            <img src="https://img.icons8.com/?size=100&id=84898&format=png&color=000000" alt="Profile Icon"
                class="w-8 h-8 opacity-80 hover:opacity-100" />
        </button>
    </div>

    <!-- Overlay for mobile menu -->
    <div id="overlay" class="overlay"></div>

    <div class="flex flex-1">
        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar w-72 bg-white min-h-screen px-6 py-8">
            <div class="flex items-center mb-10">
                <img src="/images/logo2.png" alt="SRE Logo" class="h-20 mr-2">
            </div>

            <nav class="space-y-4 mr-10 text-gray-700 font-medium ml-2 text-lg">
                <a href="#" class="block hover:text-green-900">Members</a>
                <a href="#" class="block hover:text-green-900">Programs</a>
                <a href="#" class="block hover:text-green-900">Departments</a>
                <a href="#" class="block border-b-2 border-green-900 pb-1 hover:text-green-900">Categories</a>
                <a href="#" class="block hover:text-green-900 pt-4">Admin Profile</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-4 md:p-8">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <!-- Search bar -->
                <div class="relative w-full max-w-xl">
                    <input type="text" placeholder="Search..."
                        class="w-full px-4 py-2 pl-12 rounded-2xl bg-white shadow focus:outline-none" />
                    <!-- Icon Search -->
                    <button class="absolute left-3 top-1/2 transform -translate-y-1/2">
                        <img src="https://img.icons8.com/?size=100&id=82875&format=png&color=000000" alt="Search Icon"
                            class="w-5 h-5 opacity-60 hover:opacity-100" />
                    </button>
                </div>

                <!-- Profile icon - hidden on mobile -->
                <div class="ml-6 hidden md:block">
                    <button>
                        <img src="https://img.icons8.com/?size=100&id=84898&format=png&color=000000" alt="Profile Icon"
                            class="w-8 h-8 opacity-80 hover:opacity-100" />
                    </button>
                </div>
            </div>

            <!-- Table -->
            <div class="bg-green-900 text-white px-4 py-2 rounded-t-md font-semibold">
                Manage Members
            </div>
            <div class="bg-white rounded-b-md shadow overflow-x-auto">
                <table class="w-full text-left table-auto min-w-full">
                    <thead class="border-b">
                        <tr class="text-black">
                            <th class="px-4 py-2">Name</th>
                            <th class="px-4 py-2">Role</th>
                            <th class="px-4 py-2">Department Id</th>
                            <th class="px-4 py-2">Access</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="text-gray-800">
                            <td class="px-4 py-2">–</td>
                            <td class="px-4 py-2">–</td>
                            <td class="px-4 py-2">–</td>
                            <td class="px-4 py-2 flex gap-2">
                                <!-- Edit Button -->
                                <button>
                                    <lord-icon src="https://cdn.lordicon.com/wuvorxbv.json" trigger="hover"
                                        class="w-6 h-6">
                                    </lord-icon>
                                </button>

                                <!-- Delete Button -->
                                <button>
                                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="hover"
                                        class="w-6 h-6">
                                    </lord-icon>
                                </button>
                            </td>
                        </tr>
                        <!-- Repeat other rows as needed -->
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <!-- Footer -->
    <footer class="bg-[#104334] text-white py-8 md:py-16 px-4 md:px-16 mt-1">
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
        const hamburgerBtn = document.getElementById('hamburgerBtn');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        hamburgerBtn.addEventListener('click', () => {
            sidebar.classList.toggle('open');
            overlay.classList.toggle('open');
        });

        overlay.addEventListener('click', () => {
            sidebar.classList.remove('open');
            overlay.classList.remove('open');
        });

        // Sample functions for edit/delete buttons
        function handleEdit(id) {
            console.log('Editing item with ID:', id);
            // Add your edit logic here
        }

        function handleDelete(id) {
            console.log('Deleting item with ID:', id);
            // Add your delete logic here
        }
    </script>
</body>
</html>
