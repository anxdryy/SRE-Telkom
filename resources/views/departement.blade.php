<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>SRE Telkom University - {{ $department->name }}</title>
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
    

    /* Custom responsive styles */
    @media (max-width: 640px) {
        .hero-title {
            font-size: 2rem;
            line-height: 2.5rem;
        }
        .hero-description {
            font-size: 0.9rem;
            line-height: 1.4;
        }
        .section-title {
            font-size: 1.875rem;
            line-height: 2.25rem;
        }
        .card-title {
            font-size: 1rem;
            line-height: 1.5rem;
        }
        .card-description {
            font-size: 0.875rem;
            line-height: 1.25rem;
        }
    }

    @media (max-width: 375px) {
        .hero-title {
            font-size: 1.75rem;
            line-height: 2rem;
        }
        .section-title {
            font-size: 1.5rem;
            line-height: 2rem;
        }
    }
</style>

<body class="min-h-screen">

    {{-- Include shared navbar --}}
    @include('partials.navbar')

    <!-- Hero Section -->
    <section class="font-redhat relative bg-cover bg-center text-white h-[400px] sm:h-[450px] md:h-[500px] lg:h-[550px] flex items-center justify-center"
    style="background-image: url('{{ asset('images/corebg.jpg') }}');">
        <div class="absolute inset-0 bg-black opacity-30"></div>

        <div class="relative z-10 text-center px-4 sm:px-6 md:px-8 mt-16 sm:mt-20 w-full max-w-4xl">
            <h1 class="hero-title text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold mb-3 sm:mb-4">{{ $department->name }}</h1>
            <p class="hero-description text-sm sm:text-base md:text-lg max-w-xl sm:max-w-2xl mx-auto px-2 sm:px-0 leading-relaxed">{{ $department->description }}</p>
            <div class="mt-6 sm:mt-8 md:mt-10">
                @if ($department->image)
                    <img src="{{ asset('storage/' . $department->image) }}" alt="{{ $department->name }} Badge"
                        class="mx-auto w-16 sm:w-20 md:w-24 lg:w-28 h-auto">
                @endif
            </div>
        </div>
    </section>

    <!-- Members Section -->
    <section class="font-redhat py-12 sm:py-16 md:py-20 text-white text-center" style="background-color: #104334;">
        <h2 class="section-title text-2xl sm:text-3xl md:text-4xl font-semibold mb-8 sm:mb-10 px-4">Our Members</h2>

        <div class="grid grid-cols-1 xs:grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4 gap-6 sm:gap-8 px-4 sm:px-6 md:px-8 lg:px-12 xl:px-20 justify-center max-w-7xl mx-auto">
            @forelse ($department->members as $member)
                <div class="flex flex-col items-center max-w-xs mx-auto">
                    <div class="w-32 h-32 sm:w-36 sm:h-36 md:w-40 md:h-40 lg:w-44 lg:h-44 xl:w-48 xl:h-48 bg-gray-300 rounded-full mb-3 sm:mb-4 overflow-hidden shadow-lg">
                        @if ($member->image)
                            <img src="{{ asset('storage/' . $member->image) }}" alt="{{ $member->name }}"
                                class="w-full h-full object-cover">
                        @endif
                    </div>
                    <p class="font-medium text-sm sm:text-base md:text-lg text-center px-2">{{ $member->name }}</p>
                    <p class="text-xs sm:text-sm text-gray-200 text-center px-2 mt-1">{{ $member->division }}</p>
                </div>
            @empty
                <p class="col-span-full text-gray-400 text-sm sm:text-base px-4">No members yet.</p>
            @endforelse
        </div>
    </section>

    <!-- Programs Section -->
    <section class="font-redhat py-12 sm:py-16 md:py-20 pb-16 sm:pb-24 md:pb-32 px-4 sm:px-6 md:px-8 text-center max-w-7xl mx-auto">
        <h2 class="section-title text-2xl sm:text-3xl md:text-4xl font-semibold mb-8 sm:mb-10">What We Do</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 md:gap-8">
            @forelse ($department->works as $work)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300 max-w-sm mx-auto w-full">
                    <img src="{{ asset('storage/' . $work->image) }}" alt="{{ $work->title }}"
                        class="w-full h-48 sm:h-52 md:h-56 object-cover">
                    <div class="p-4 sm:p-5 md:p-6">
                        <h3 class="card-title font-semibold text-base sm:text-lg md:text-xl mb-2 sm:mb-3">{{ $work->title }}</h3>
                        <p class="card-description text-xs sm:text-sm md:text-base text-gray-600 leading-relaxed">{{ $work->description }}</p>
                    </div>
                </div>
            @empty
                <p class="col-span-full text-gray-500 text-sm sm:text-base">No works found.</p>
            @endforelse
        </div>
    </section>

    <!-- Departments Section -->
    <section class="flex flex-col lg:flex-row items-center justify-between px-4 sm:px-6 md:px-8 lg:px-10 my-8 sm:my-10 pb-10 sm:pb-14 max-w-7xl mx-auto gap-8 lg:gap-10">
        <!-- Left Side (Text) -->
        <div class="w-full lg:w-1/3 text-left">
    <h2 class="font-redhat text-2xl sm:text-3xl md:text-4xl font-extrabold text-black flex flex-col sm:flex-row items-start justify-start tracking-widest">
        Our <span class="text-[#104334] sm:ml-2 mt-1 sm:mt-0">Departments</span>
    </h2>
    <div class="w-16 h-1 bg-gray-500 mt-2"></div>
    <p class="font-redhattext text-black mt-4 text-left text-sm sm:text-base md:text-lg font-semibold leading-relaxed">
        Each of our departments strive to fulfill the needs. Achieving the vission and mission towards our SRE
        Goals.
    </p>
</div>

        <!-- Right Side (Department Icons) -->
        <div class="w-full lg:w-2/3 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 sm:gap-6 md:gap-8 justify-items-center">
            <a href="/Departement" class="group">
                <img src="images/CoreNew.png" alt="Core"
                class="w-20 h-20 sm:w-24 sm:h-24 md:w-28 md:h-28 lg:w-32 lg:h-32 xl:w-36 xl:h-36 object-contain drop-shadow-[0px_4px_10px_rgba(0,0,0,0.6)] transition-transform duration-300 ease-in-out group-hover:scale-110">
            </a>
            <a href="/Departement" class="group">
                <img src="images/EVENT.png" alt="Event"
                class="w-20 h-20 sm:w-24 sm:h-24 md:w-28 md:h-28 lg:w-32 lg:h-32 xl:w-36 xl:h-36 object-contain drop-shadow-[0px_4px_10px_rgba(0,0,0,0.6)] transition-transform duration-300 ease-in-out group-hover:scale-110">
            </a>
            <a href="/Departement?id=1" class="group">
                <img src="images/IT.png" alt="IT"
                class="w-20 h-20 sm:w-24 sm:h-24 md:w-28 md:h-28 lg:w-32 lg:h-32 xl:w-36 xl:h-36 object-contain drop-shadow-[0px_4px_10px_rgba(0,0,0,0.6)] transition-transform duration-300 ease-in-out group-hover:scale-110">
            </a>
            <a href="/Departement" class="group">
                <img src="images/MULMED.png" alt="Multimedia"
                class="w-20 h-20 sm:w-24 sm:h-24 md:w-28 md:h-28 lg:w-32 lg:h-32 xl:w-36 xl:h-36 object-contain drop-shadow-[0px_4px_10px_rgba(0,0,0,0.6)] transition-transform duration-300 ease-in-out group-hover:scale-110">
            </a>
            <a href="/Departement" class="group">
                <img src="images/PR.png" alt="Public Relation"
                class="w-20 h-20 sm:w-24 sm:h-24 md:w-28 md:h-28 lg:w-32 lg:h-32 xl:w-36 xl:h-36 object-contain drop-shadow-[0px_4px_10px_rgba(0,0,0,0.6)] transition-transform duration-300 ease-in-out group-hover:scale-110">
            </a>
            <a href="/Departement" class="group">
                <img src="images/ACAD.png" alt="Academics"
                class="w-20 h-20 sm:w-24 sm:h-24 md:w-28 md:h-28 lg:w-32 lg:h-32 xl:w-36 xl:h-36 object-contain drop-shadow-[0px_4px_10px_rgba(0,0,0,0.6)] transition-transform duration-300 ease-in-out group-hover:scale-110">
            </a>
            <a href="/Departement" class="group">
                <img src="images/RND.png" alt="Research & Development"
                class="w-20 h-20 sm:w-24 sm:h-24 md:w-28 md:h-28 lg:w-32 lg:h-32 xl:w-36 xl:h-36 object-contain drop-shadow-[0px_4px_10px_rgba(0,0,0,0.6)] transition-transform duration-300 ease-in-out group-hover:scale-110">
            </a>
        </div>
    </section>

    <!-- Footer Section -->
    <footer class="relative bg-[#104334] text-white pt-[60px] md:pt-[90px] pb-8 md:pb-16 px-8 md:px-16 z-0 overflow-visible mt-48">
        <!-- Trees overflowing upwards -->
        <div class="absolute top-0 left-0 w-full h-[120px] md:h-[180px] -translate-y-[60%] md:-translate-y-[60%] z-10">
            <img src="{{ asset('images/trees.png') }}"
                alt="Forest Design"
                class="w-full h-full object-cover"
            >
        </div>
        <div class="container mx-auto flex flex-col md:flex-row justify-between items-start gap-8">
            <!-- Left: Logo and Description -->
            <div class="w-full md:w-1/3 mb-8 md:mb-0">
                <img src="{{ asset('images/logo1.png') }}" alt="SRE Universitas Telkom" class="w-auto h-16 md:h-auto">
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
                            <img src="{{ asset('images/instagram.png') }}" alt="Instagram" class="transition-transform duration-500 ease-out transform hover:scale-110 w-6 h-6">
                        </a>
                        <a href="https://line.me" target="_blank">
                            <img src="{{ asset('images/vector.png') }}" alt="Line" class="transition-transform duration-500 ease-out transform hover:scale-110 w-6 h-6">
                        </a>
                        <a href="https://youtube.com" target="_blank">
                            <img src="{{ asset('images/youtube.png') }}" alt="YouTube" class="transition-transform duration-500 ease-out transform hover:scale-110 w-6 h-6">
                        </a>
                        <a href="https://linkedin.com" target="_blank">
                            <img src="{{ asset('images/linkedin.png') }}" alt="LinkedIn" class="transition-transform duration-500 ease-out transform hover:scale-110 w-6 h-6">
                        </a>
                        <a href="mailto:example@example.com">
                            <img src="{{ asset('images/envelope.png') }}" alt="Email" class="transition-transform duration-500 ease-out transform hover:scale-110 w-6 h-6">
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
