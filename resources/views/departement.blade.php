<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Core Team - SRE Universitas Telkom</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans antialiased text-gray-800">

    <!-- Hero Section -->
    <section class="relative bg-cover bg-center text-white h-[400px] flex items-center justify-center" style="background-image: url('{{ asset('images/core-team-bg.jpg') }}');">
        <div class="absolute inset-0 bg-black opacity-30"></div>
        <div class="relative z-10 text-center px-4">
            <h1 class="text-4xl font-bold mb-2">Core Team</h1>
            <p class="max-w-2xl mx-auto">
                A core team is a small, dedicated group responsible for organizational thinking and decision-making, support for coordination, interdepartmental alignment, and project coordination. They prioritize delivery to ensure smooth operations and alignment with overall goals.
            </p>
            <div class="mt-6">
                <img src="{{ asset('images/core-badge.png') }}" alt="Core Badge" class="mx-auto w-24">
            </div>
        </div>
    </section>

    <!-- Members Section -->
    <section class="bg-green-900 text-white py-12 text-center">
        <h2 class="text-3xl font-semibold mb-8">Our Members</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 px-6 md:px-20">
            @for ($i = 0; $i < 8; $i++)
                <div class="flex flex-col items-center">
                    <div class="w-24 h-24 bg-gray-400 rounded-full mb-2"></div>
                    <p>Sabrina</p>
                    <p class="text-sm text-gray-300">Division</p>
                </div>
            @endfor
        </div>
    </section>

    <!-- What We Do Section -->
    <section class="py-12 px-6 text-center">
        <h2 class="text-3xl font-semibold mb-8">What We Do</h2>
        <div class="grid md:grid-cols-4 gap-6">
            <!-- Card 1 -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <img src="{{ asset('images/bicycle.jpg') }}" alt="Bicycle Program" class="w-full h-32 object-cover">
                <div class="p-4">
                    <h3 class="font-semibold">Bicycle Program</h3>
                    <p class="text-sm">Weekly rides across town, promoting sustainable transportation.</p>
                </div>
            </div>
            <!-- Card 2 -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <img src="{{ asset('images/camping.jpg') }}" alt="Camping Trip" class="w-full h-32 object-cover">
                <div class="p-4">
                    <h3 class="font-semibold">Camping Trip</h3>
                    <p class="text-sm">Going to learn valuable things in the wild!</p>
                </div>
            </div>
            <!-- Card 3 -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <img src="{{ asset('images/hiking.jpg') }}" alt="The Hikers" class="w-full h-32 object-cover">
                <div class="p-4">
                    <h3 class="font-semibold">The 'Hikers'</h3>
                    <p class="text-sm">Hiking & happiness go hand-in-hand.</p>
                </div>
            </div>
            <!-- Circle Icon -->
            <div class="flex items-center justify-center">
                <div class="w-12 h-12 bg-yellow-500 rounded-full text-white text-xl font-bold flex items-center justify-center">H</div>
            </div>
        </div>
    </section>

    <!-- Departments Section -->
    <section class="py-12 text-center bg-gray-100">
        <h2 class="text-3xl font-semibold mb-4">Our Departments</h2>
        <p class="max-w-2xl mx-auto mb-8 text-sm text-gray-700">
            Each of our departments strive to build and maintain systems that reflect the mission and goals of SRE.
        </p>
        <div class="flex flex-wrap justify-center gap-6">
            @for ($i = 0; $i < 8; $i++)
                <div class="w-16 h-16 bg-white shadow rounded-full flex items-center justify-center">
                    <img src="{{ asset('images/icon' . $i . '.png') }}" alt="Icon {{ $i }}">
                </div>
            @endfor
        </div>
    </section>

</body>
</html>
