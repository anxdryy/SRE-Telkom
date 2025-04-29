<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>SRE Telkom University</title>
</head>

<body class="min-h-screen bg-gray-100">
    <!-- Navbar -->
    <nav class="absolute top-8 left-0 w-full flex justify-between items-center px-12 text-white">
        <div id="logo" class="flex items-center font-bold ml-8">
            <img src="/images/logo2.png" alt="SRE Logo" class="h-24 mr-2">
        </div>
    </nav>

    <!-- Form Login Admin -->
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-gray-200 border-4 border-green-900 rounded-lg p-8 w-[450px] shadow-md mt-32">
            <h2 class="text-center text-gray-800 text-lg font-medium mb-6">Admin Dashboard</h2>

            <form>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-1 font-semibold" for="username">Username</label>
                    <input type="text" id="username"
                        class="w-full px-4 py-2 rounded-md bg-gray-300 focus:outline-none" />
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 mb-1 font-semibold" for="password">Password</label>
                    <input type="password" id="password"
                        class="w-full px-4 py-2 rounded-md bg-gray-300 focus:outline-none" />
                </div>

                <div class="text-right">
                    <button type="submit"
                        class="bg-green-800 hover:bg-green-900 text-white font-semibold px-5 py-2 rounded-md">
                        Login
                    </button>
                </div>
            </form>
        </div>
    </div>

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
</body>

</html>
