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
</style>

<body class="min-h-screen">

    {{-- Include shared navbar --}}
    @include('partials.navbar')

    <!-- Hero Section -->
    <section class=" font-redhat relative bg-cover bg-center text-white h-[500px] flex items-center justify-center"
    style="background-image: url('{{ asset('images/corebg.jpg') }}');">
    <div class="absolute inset-0 bg-black opacity-30"></div>

    <div class="relative z-10 text-center px-4 mt-20">
        <h1 class="text-4xl font-bold mb-2">{{ $department->name }}</h1>
        <p class="max-w-2xl mx-auto">{{ $department->description }}</p>
        <div class="mt-10"> <!-- increased spacing below logo -->
            @if ($department->image)
                <img src="{{ asset('storage/' . $department->image) }}" alt="{{ $department->name }} Badge"
                    class="mx-auto w-24">
            @endif
        </div>
    </div>
    </section>

    <!-- Members Section -->
    <section class="font-redhat py-16 text-white text-center" style="background-color: #104334;">
        <h2 class="text-3xl font-semibold mb-10">Our Members</h2>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 px-6 md:px-20 justify-center">
            @forelse ($department->members as $member)
                <div class="flex flex-col items-center">
                    <div class="w-48 h-48 bg-gray-300 rounded-full mb-4 overflow-hidden">
                        @if ($member->image)
                            <img src="{{ asset('storage/' . $member->image) }}" alt="{{ $member->name }}"
                                class="w-full h-full object-cover">
                        @endif
                    </div>
                    <p class="font-medium text-sm">{{ $member->name }}</p>
                    <p class="text-xs text-gray-200">{{ $member->division }}</p>
                </div>
            @empty
                <p class="col-span-full text-gray-400">No members yet.</p>
            @endforelse
        </div>
    </section>

    <!-- Programs Section -->
    <section class="font-redhat py-20 pb-32 px-6 text-center"> <!-- Increased padding to give space above trees -->
    <h2 class="text-3xl font-semibold mb-10">What We Do</h2>

    <div class="grid md:grid-cols-3 gap-6">
        @forelse ($department->works as $work)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <img src="{{ asset('storage/' . $work->image) }}" alt="{{ $work->title }}"
                    class="w-full h-56 object-cover"> <!-- taller image (was h-32) -->
                <div class="p-4">
                    <h3 class="font-semibold text-lg">{{ $work->title }}</h3>
                    <p class="text-sm mt-2">{{ $work->description }}</p>
                </div>
            </div>
        @empty
            <p class="col-span-full text-gray-500">No works found.</p>
        @endforelse
    </div>
    </section>

    <section class="flex flex-col gap-10 md:flex-row items-center justify-between px-6 my-10 md:px-10 pb-14">
        <!-- Bagian Kiri (Teks) -->
        <div class="w-full ml-10 md:w-1/3 mb-6 md:mb-0">
            <h2 class="font-redhat text-3xl md:text-3xl font-extrabold text-black flex items-center tracking-widest">
                Our <span class="text-[#104334] ml-2">Departments</span>
            </h2>
            <div class="w-16 h-1 bg-gray-500 mt-2 mr-8"></div>
            <p class="font-redhattext text-black mt-4 max-w-[85%] text-justify text-base md:text-lg font-semibold">
                Each of our departments strive to fulfill the needs. Achieving the vission and mission towards our SRE
                Goals.
            </p>
        </div>

        <!-- Bagian Kanan (Ikon Departemen) -->
        <div class="w-full md:w-2/3 grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
            <a href="/Departement">
                <img src="images/CoreNew.png" alt="Core"
                class="w-24 h-24 md:w-36 md:h-36 object-contain drop-shadow-[0px_4px_10px_rgba(0,0,0,0.6)] transition-transform duration-300 ease-in-out hover:scale-110">
            </a>
            <a href="/Departement">
                <img src="images/EVENT.png" alt="Event"
                class="w-24 h-24 md:w-36 md:h-36 object-contain drop-shadow-[0px_4px_10px_rgba(0,0,0,0.6)] transition-transform duration-300 ease-in-out hover:scale-110">
            </a>
            <a href="/Departement?id=1">
                <img src="images/IT.png"
                class="w-24 h-24 md:w-36 md:h-36 object-contain drop-shadow-[0px_4px_10px_rgba(0,0,0,0.6)] transition-transform duration-300 ease-in-out hover:scale-110">
            </a>
            <a href="/Departement">
                <img src="images/MULMED.png" alt="Multimedia"
                class="w-24 h-24 md:w-36 md:h-36 object-contain drop-shadow-[0px_4px_10px_rgba(0,0,0,0.6)] transition-transform duration-300 ease-in-out hover:scale-110">
            </a>
            <a href="/Departement">
                <img src="images/PR.png" alt="Public Relation"
                class="w-24 h-24 md:w-36 md:h-36 object-contain drop-shadow-[0px_4px_10px_rgba(0,0,0,0.6)] transition-transform duration-300 ease-in-out hover:scale-110">
            </a>
            <a href="/Departement">
                <img src="images/ACAD.png" alt="Academics"
                class="w-24 h-24 md:w-36 md:h-36 object-contain drop-shadow-[0px_4px_10px_rgba(0,0,0,0.6)] transition-transform duration-300 ease-in-out hover:scale-110">
            </a>
            <a href="/Departement">
                <img src="images/RND.png" alt="Research & Development"
                class="w-24 h-24 md:w-36 md:h-36 object-contain drop-shadow-[0px_4px_10px_rgba(0,0,0,0.6)] transition-transform duration-300 ease-in-out hover:scale-110">
            </a>
        </div>
    </section>

    <!-- Footer Section -->
    @include('partials.footer')

</body>

</html>
