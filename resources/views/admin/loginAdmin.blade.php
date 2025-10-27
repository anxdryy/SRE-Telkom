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

            <!-- Error Alert -->
            @if ($errors->has('login'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
                    <strong class="font-bold">Error!</strong>
                    <span class="block sm:inline">{{ $errors->first('login') }}</span>
                </div>
            @endif

            <!-- Success Alert -->
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
                    <strong class="font-bold">Success!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('auth.login') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 mb-1 font-semibold" for="username">Username</label>
                    <input type="text" id="username" name="username" value="{{ old('username') }}"
                        class="w-full px-4 py-2 rounded-md bg-gray-300 focus:outline-none @error('username') border-2 border-red-500 @enderror" />
                    @error('username')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 mb-1 font-semibold" for="password">Password</label>
                    <input type="password" id="password" name="password"
                        class="w-full px-4 py-2 rounded-md bg-gray-300 focus:outline-none @error('password') border-2 border-red-500 @enderror" />
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="text-right">
                    <button type="submit"
                        class="bg-green-800 hover:bg-green-900 text-white font-semibold px-5 py-2 rounded-md transition-colors duration-200">
                        Login
                    </button>
                </div>
            </form>
        </div>
    </div>

    @include('partials.footer')

    <!-- Auto-hide alerts after 5 seconds -->
    <script>
        // Auto-hide success alerts
        setTimeout(function() {
            const successAlert = document.querySelector('.bg-green-100');
            if (successAlert) {
                successAlert.style.opacity = '0';
                successAlert.style.transition = 'opacity 0.5s ease-out';
                setTimeout(function() {
                    successAlert.remove();
                }, 500);
            }
        }, 5000);

        // Auto-hide error alerts
        setTimeout(function() {
            const errorAlert = document.querySelector('.bg-red-100');
            if (errorAlert) {
                errorAlert.style.opacity = '0';
                errorAlert.style.transition = 'opacity 0.5s ease-out';
                setTimeout(function() {
                    errorAlert.remove();
                }, 500);
            }
        }, 8000);
    </script>
</body>

</html>
