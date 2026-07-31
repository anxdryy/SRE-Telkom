<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SRE Admin | SRE Telkom University</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Red+Hat+Display:wght@400;500;600;700&family=Onest:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Onest', sans-serif; }
        .font-redhat { font-family: 'Red Hat Display', sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-gray-100 flex">
    @include('partials.admin.sidebar')

    <div class="flex-1 flex flex-col min-h-screen md:ml-64">
        <header class="sticky top-0 z-20 flex items-center justify-between bg-white border-b border-gray-200 px-4 md:px-8 py-3">
            <button id="admin-sidebar-toggle" type="button" class="md:hidden text-gray-700 text-xl">
                <i class="fas fa-bars"></i>
            </button>
            <div class="hidden md:block"></div>
            <div class="flex items-center gap-4 text-sm text-gray-700">
                <span class="flex items-center gap-2">
                    <i class="fas fa-user-circle text-lg"></i>
                    {{ auth()->user()->name ?? 'Admin' }}
                </span>
                <form method="POST" action="{{ route('auth.logout') }}">
                    @csrf
                    <button type="submit" class="text-red-600 hover:underline">Logout</button>
                </form>
            </div>
        </header>

        <main class="flex-1 p-4 md:p-8">
            @include('partials.admin.flash')
            @yield('content')
        </main>
    </div>

    <script>
        const toggle = document.getElementById('admin-sidebar-toggle');
        const sidebar = document.getElementById('admin-sidebar');
        const overlay = document.getElementById('admin-sidebar-overlay');
        toggle?.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        });
        overlay?.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });
    </script>
</body>
</html>
