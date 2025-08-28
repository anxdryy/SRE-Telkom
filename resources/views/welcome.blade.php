<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SRE | Telkom University</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Red+Hat+Display:wght@400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather+Sans:wght@400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Onest:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

        <style>
        /* Font Classes */
        .font-redhat {
            font-family: 'Red Hat Display', sans-serif;
        }
        .font-onest {
            font-family: 'Onest', sans-serif;
        }
        .font-merriweather-sans {
            font-family: "Merriweather Sans", sans-serif;
        }

         body {
            font-family: 'Red Hat Display', sans-serif;
        }

        .social-icons {
            margin-left: 10px;
        }

        /* Icon Container Styles */
        .icon-container {
            position: relative;
            width: 200px;
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.3s ease-in-out;
        }

        .icon-container img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            filter: drop-shadow(0px 4px 10px rgba(0, 0, 0, 0.6));
            transition: transform 0.3s ease-in-out;
        }

        .icon-container:hover img {
            transform: scale(1.1);
        }

        .overlay {
            position: absolute;
            top: 1;
            left: 1;
            width: 120%;
            height: 114%;
            background: rgba(0, 0, 0, 0.2);
            color: white;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }

        .icon-container:hover .overlay {
            opacity: 1;
            border-radius: 24px;
        }

        /* Mobile styles */
        @media (max-width: 768px) {
            #dropdownMenu {
                position: static;
                width: 100%;
                background-color: rgba(255, 255, 255, 0.1);
                box-shadow: none;
                border: none;
                margin-top: 10px;
                backdrop-filter: blur(5px);
            }

            #dropdownMenu a {
                color: white;
                padding: 12px 16px;
                display: block;
                transition: background-color 0.3s;
            }

            #dropdownMenu a:hover {
                background-color: rgba(255, 255, 255, 0.2);
            }



            #typingText {
                font-size: 4rem;
                left: 52%;
            }

            #joinUsContainer {
                right: auto;
                left: 50%;
                transform: translateX(-50%);
                bottom: 30px;
            }

            .flex.gap-28 {
                flex-direction: column;
                gap: 20px;
            }

            .border-4.border-\[#08332A\] {
                flex-direction: column;
                padding: 20px;
                width: 100%;
            }

            .border-4.border-\[#08332A\]>span {
                display: none;
            }

            .flex.justify-between.items-start {
                flex-direction: column;
            }

            .w-1\/3,
            .w-2\/6 {
                width: 100%;
                margin-bottom: 20px;
            }

            .text-right {
                text-align: center;
            }

            .text-6xl {
                font-size: 3rem;
            }

            .text-4xl {
                font-size: 2rem;
            }

            .text-3xl {
                font-size: 1.5rem;
            }

            .text-2xl {
                font-size: 1.25rem;
            }

            .p-20 {
                padding: 2rem;
            }

            .px-36 {
                padding-left: 1rem;
                padding-right: 1rem;
            }

            .py-6 {
                padding-top: 1rem;
                padding-bottom: 1rem;
            }

            .px-8 {
                padding-left: 1rem;
                padding-right: 1rem;
            }

            .py-4 {
                padding-top: 0.5rem;
                padding-bottom: 0.5rem;
            }
        }
    </style>

<body class="min-h-screen">
    <!-- Hero Section -->
    <div class="relative h-[100vh] bg-cover bg-center" style="background-image: url('images/bg.jpg')">
        <!-- Navbar -->
        @include('partials.navbar')

        <!-- Hero Content -->
        <div class="absolute bottom-16 right-4 md:right-16 text-white text-right md:text-right">
            <h1 id="typingText" class="font-onest text-[3rem] md:text-[6rem] font-bold leading-tight opacity-0"></h1>
        </div>

        <div id="joinUsContainer" class="absolute bottom-16 left-4 md:left-16 opacity-0 transform -translate-x-20 transition-all duration-1000 ml-0 md:ml-8">
            <button id="joinUsButton" class="font-onest px-4 py-2 md:px-8 md:py-4 bg-white text-lg md:text-xl text-[#104334] font-semibold rounded-3xl shadow-[0_0_20px_rgba(255,255,255,0.8)] transition duration-300 transform hover:scale-110">
                JOIN US!
            </button>
        </div>
    </div>

    <!-- Main Content Section -->
    <div class="relative py-18 double-bg">
        <div class="flex items-center justify-center relative max-w-9xl mx-auto px-4 md:px-6">

            <!-- Content Container -->
            <div class="bg-white bg-opacity-90 backdrop-blur-md rounded-xl shadow-lg p-6 md:p-14 w-full flex flex-col md:flex-row justify-center items-center md:space-x-10 space-y-6 md:space-y-0 filter drop-shadow-lg">

                <!-- Image Section -->
                <div class="relative w-full md:w-1/3">
                    <div class="absolute -top-2 -left-2 right-2 bottom-2 bg-[#144A3A] rounded-3xl"></div>
                    <div class="relative p-2 transform translate-x-4 translate-y-4">
                    <img src="images/sre.jpeg" alt="SRE Tel-U" class="rounded-3xl shadow-md w-full">
                    <div class="absolute inset-0 m-2 bg-black bg-opacity-10 flex items-center justify-center rounded-md"></div>
                    </div>
                </div>

                <!-- Text Section -->
                <div class="w-full md:w-1/2 text-gray-800 space-y-4 pl-8 mt-12">
                   <p class="text-lg md:text-2xl font-redhattext text-justify">
                    Founded in 2021, SRE Telkom University is one of the student chapters of the Society of Renewable Energy, based in Bandung. Our focus extends beyond renewable energy, emphasizing community empowerment and environmental sustainability through education, innovation, and collaboration.
                    </p>

                    <!-- Buttons -->
                    <div class="flex flex-col items-center mt-4 space-y-4">
                    <!-- Read More Button -->
                    <button
                        onclick="window.location.href='/AboutUs';"
                        class="bg-[#0F936D] text-white px-3 py-3 mb-12 md:px-4 md:py-3 rounded-2xl hover:bg-green-600 transition w-full max-w-[50%] md:max-w-[45%] text-center font-redhat">
                        Read More
                    </button>

                    <!-- Scroll Down Icon -->
                    <button id="scrollDownButton" class="mt-24">
                        <svg class="w-8 h-8 text-black animate-bounce" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Quote Section -->
    <div class="relative bg-center bg-cover py-12 px-2 text-center" style="background-image: url('images/bg3.jpeg'); min-height: 340px;">
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        <div class="relative p-5 inline-block max-w-4xl">
            <p class="text-white font-semibold text-lg md:text-3xl font-redhattext">
                "Our dependence on fossil fuels amounts to global pyromania, and the only fire extinguisher we have at
                our disposal is renewable energy." - Hermann Scheer.  
            </p>
        </div>
    </div>

    <!-- Team Section -->
    <div id="teamSection" class="relative w-full bg-white rounded-t-[50px] p-4 md:p-8 z-10 -mt-20">
        <!-- Title -->
        <div class="w-full flex justify-center">
            <div class="w-full md:w-[900px] text-center">
                <h2 class="text-4xl font-extrabold mb-2 mt-10 md:mt-20 underline font-redhat">Meet Our Team!</h2>
            </div>
        </div>

        <!-- Team Icons -->
        <div class="flex flex-col items-center mt-32 space-y-16">
            <div class="flex gap-28">
                <div class="icon-container">
                    <img src="images/RND.png" alt="Research & Development">
                    <div class="overlay">Research & Development</div>
                </div>
                <div class="icon-container">
                    <img src="images/MULMED.png" alt="Multimedia">
                    <div class="overlay">Multimedia</div>
                </div>
                <div class="icon-container">
                    <img src="images/ACAD.png" alt="Academics">
                    <div class="overlay">Academics</div>
                </div>
                <div class="icon-container">
                    <img src="images/IT.png" alt="IT">
                    <div class="overlay">IT</div>
                </div>
            </div>
            <div class="flex gap-28">
                <div class="icon-container">
                    <img src="images/EVENT.png" alt="Event & Competition">
                    <div class="overlay">Event & Competition</div>
                </div>
                <div class="icon-container">
                    <img src="images/CoreNEW.png" alt="Core">
                    <div class="overlay">Core</div>
                </div>
                <div class="icon-container">
                    <img src="images/PR.png" alt="Public Relations">
                    <div class="overlay">Public Relations</div>
                </div>
            </div>
        </div>

        <!-- Stats & Button -->
        <div class="flex justify-center mt-8 md:mt-16">
            <div class="border-4 border-[#08332A] rounded-2xl px-4 py-4 md:px-36 md:py-6 flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-8 lg:space-x-16 shadow-md">
                <div class="text-center">
                    <p class="text-2xl md:text-4xl font-extrabold font-redhat">100+</p>
                    <p class="text-md md:text-2xl font-medium font-redhat">Members</p>
                </div>
                <span class="hidden md:inline ml-2 text-4xl flex items-center">|</span>
                <div class="text-center">
                    <p class="text-2xl md:text-4xl font-extrabold font-redhat">10+</p>
                    <p class="text-md md:text-2xl font-medium font-redhat">Divisions</p>
                </div>
                <span class="hidden md:inline ml-2 text-4xl flex items-center">|</span>
                <div class="text-center">
                    <p class="text-2xl md:text-4xl font-extrabold font-redhat">8+</p>
                    <p class="text-md md:text-2xl font-medium font-redhat">Projects</p>
                </div>
                <button onclick="window.location.href='/AboutUs';" class="bg-[#1D614D] text-white px-8 py-2 md:px-36 md:py-4 rounded-xl text-lg md:text-2xl font-semibold hover:bg-green-900 transition-transform duration-500 ease-out transform hover:scale-105 font-redhat mt-4 md:mt-0">
                    Read More
                </button>
            </div>
        </div>
    </div>

    <!-- Activities Section -->
    <div class="relative w-full bg-[#144A3A] text-white min-h-screen bottom-[-100px] rounded-t-[50px] md:rounded-t-[40px] p-8 md:p-20 flex flex-col py-10">
        <h2 class="text-3xl md:text-4xl font-bold font-redhattext text-white mb-8 underline tracking-tight">
            Here's <span class="text-white">What We Do,</span>
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach ($latestPrograms as $program)
                <a href="{{ route('programs.show', $program->id) }}"
                class="relative rounded-xl overflow-hidden border-solid border-8 shadow-3xl transition-transform transform hover:scale-105 duration-300">

                    {{-- Image --}}
                    <img src="{{ asset('storage/' . $program->image) }}"
                        alt="{{ $program->title }}"
                        class="w-full h-80 object-cover">

                    {{-- Bottom Overlay --}}
                    <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-70 text-white p-4">
                        <p class="text-sm mb-1">{{ \Carbon\Carbon::parse($program->date)->format('d F Y') }}</p>
                        <h3 class="text-base sm:text-lg font-bold leading-tight">{{ $program->title }}</h3>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="text-right mt-6">
            <a href="/Activity" class="text-white underline text-3xl font-semibold font-redhattext hover:text-green-300 transition-colors duration-200">
                Read More
            </a>
        </div>
    </div>

    <!-- Tree Background -->
    <div class="relative w-full h-[120px] md:h-[180px] overflow-hidden -mb-[60px] md:-mb-[90px] z-10">
        <img
            src="images/trees.png"
            alt="Forest Design"
            class="absolute top-0 left-0 w-full h-full object-cover"
        >
    </div>

    <!-- Footer Section -->
    <footer class="relative bg-[#104334] text-white pt-[40px] md:pt-[90px] pb-8 md:pb-16 px-8 md:px-16 z-0">
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
        document.addEventListener("DOMContentLoaded", function () {
            // Logo animation
            const logo = document.getElementById("logo");
            logo.classList.remove("opacity-0", "-translate-x-20");

            // Navbar animation after logo
            setTimeout(() => {
                const navbar = document.getElementById("navbar");
                navbar.classList.remove("opacity-0", "-translate-y-10");
            }, 1000);

            // Typing effect after navbar
            setTimeout(() => {
                const textElement = document.getElementById("typingText");
                const text = "INNOVATE\nENERGIZE\nELEVATE.";
                let index = 0;

                function typeEffect() {
                    if (index < text.length) {
                        textElement.innerHTML += text[index] === "\n" ? "<br>" : text[index];
                        index++;
                        setTimeout(typeEffect, 100);
                    } else {
                        textElement.classList.remove("opacity-0");
                    }
                }

                textElement.classList.remove("opacity-0");
                typeEffect();
            }, 2000);

            // Join Us button animation after text
            setTimeout(() => {
                const joinUs = document.getElementById("joinUsContainer");
                joinUs.classList.remove("opacity-0", "-translate-x-20");
            }, 4000);

        });

        document.getElementById('joinUsButton').addEventListener('click', function () {
            window.scrollTo({
                top: window.innerHeight,
                behavior: 'smooth'
            });
        });

        document.getElementById('scrollDownButton').addEventListener('click', function () {
            document.getElementById('teamSection').scrollIntoView({
                behavior: 'smooth'
            });
        });
    </script>
</body>
</html>
