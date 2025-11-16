<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>SRE Telkom University</title>
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
    @include('partials.navbar')

    {{-- Show Department Detail View --}}
    @isset($department)
        @php
            $backgroundImage = $department->image
                ? asset('storage/' . $department->image)
                : asset('images/corebg.jpg');
        @endphp

        <section
            class="font-redhat relative bg-cover bg-center  text-white flex items-center justify-center  w-full h-auto py-5 lg:pt-20 lg:pb-72"
            style="background-image: url('{{ $backgroundImage }}');">

            <div class="absolute inset-0 bg-black opacity-30"></div>

            <div class="relative z-10 text-center  px-6 max-w-3xl ">
                {{-- Department Logo, Name, Description --}}
                @if ($department->logo)
                    <img src="{{ asset('storage/' . $department->logo) }}" alt="{{ $department->name }}"
                        class="mx-auto mb-4 mt-20 w-36 h-36 object-contain">
                @endif
                <h1 class="text-3xl md:text-4xl font-bold mb-4">{{ $department->name }}</h1>
                <p class="text-base md:text-lg">{{ $department->description }}</p>
            </div>
        </section>



        {{-- Members --}}
        <section class="bg-[#104334] text-white py-10">
            <h2 class="text-center text-3xl font-semibold mb-8">Our Members</h2>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 px-6">
                @forelse($department->members as $member)
                    <div class="flex flex-col items-center">
                        <img src="{{ asset('storage/' . $member->image) }}" alt="{{ $member->name }}"
                            class="w-32 h-32 lg:w-48 lg:h-48 rounded-full object-cover mb-2">
                        <p class="text-lg text-center font-medium">{{ $member->name }}</p>
                        <p class="text-sm text-gray-300 text-center">{{ $member->role }}</p>
                    </div>
                @empty
                    <p class="col-span-full text-center text-gray-400">No members available.</p>
                @endforelse
            </div>
        </section>

        {{-- Works --}}
        <section class="py-10 px-6 max-w-7xl mx-auto">
            <h2 class="text-3xl font-semibold text-center mb-8">What We Do</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @forelse($department->works as $work)
                    <div class="bg-white shadow rounded overflow-hidden">
                        <img src="{{ asset('storage/' . $work->image) }}" alt="{{ $work->title }}"
                            class="h-48 w-full object-cover">
                        <div class="p-4">
                            <h3 class="text-xl font-bold mb-2">{{ $work->name }}</h3>
                            <p class="text-sm text-gray-700">{{ $work->description }}</p>
                        </div>
                    </div>
                @empty
                    <p class="col-span-full text-center text-gray-500">No works found.</p>
                @endforelse
            </div>
        </section>
    @endisset

    {{-- Show Department Grid if $departments is set --}}
    @isset($departments)
        <section class="flex flex-col gap-10 md:flex-row items-center justify-between px-6 my-10 md:px-10 py-10">
            <div class="w-full ml-6 md:w-1/3 mb-6 md:mb-0">
                <h2 class="font-redhat text-3xl md:text-3xl font-semibold  text-black flex items-center tracking-widest">
                    Our <span class="text-[#104334] ml-2">Departments</span>
                </h2>
                <div class="w-16 h-1 bg-gray-500 mt-2 mr-8"></div>
                <p class="font-redhattext text-black mt-4 max-w-[85%] text-justify text-base md:text-lg font-semibold">
                    Each of our departments strive to fulfill the needs. Achieving the vission and mission towards our SRE
                    Goals.
                </p>
            </div>

            <div class="w-full md:w-2/3 grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
                @foreach ($departments as $dept)
                    <a href="{{ route('departments.showDetail', ['slug' => $dept->slug]) }}">
                        <img src="{{ asset('storage/' . $dept->logo) }}" alt="{{ $dept->name }}"
                            class="w-24 h-24 md:w-36 md:h-36 object-contain drop-shadow-md hover:scale-105 transition">
                    </a>
                @endforeach
            </div>
        </section>
    @endisset

    @include('partials.footer')
</body>

</html>
