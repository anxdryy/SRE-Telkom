<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | SRE Telkom University</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Red+Hat+Display:wght@400;600;700&family=Onest:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Onest', sans-serif; }
        .font-redhat { font-family: 'Red Hat Display', sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-[#104334] flex items-center justify-center px-4">
    <div class="w-full max-w-md rounded-2xl bg-white p-8 shadow-xl">
        <div class="mb-6 flex justify-center">
            <img src="{{ asset('images/logo2.png') }}" alt="SRE Logo" class="h-16">
        </div>
        <h1 class="mb-6 text-center font-redhat text-xl font-semibold text-[#104334]">Admin Dashboard</h1>

        @if ($errors->has('login'))
            <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                {{ $errors->first('login') }}
            </div>
        @endif

        @if (session('success'))
            <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('auth.login') }}" class="space-y-4">
            @csrf
            <div>
                <label for="email" class="mb-1 block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}"
                    class="w-full rounded-lg border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#104334] {{ $errors->has('email') ? 'border-red-500' : 'border-gray-300' }}">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="password" class="mb-1 block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="password"
                    class="w-full rounded-lg border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#104334] {{ $errors->has('password') ? 'border-red-500' : 'border-gray-300' }}">
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="w-full rounded-lg bg-[#104334] py-2.5 text-sm font-semibold text-white hover:bg-[#0c3327] transition-colors">
                Login
            </button>
        </form>
    </div>
</body>
</html>
