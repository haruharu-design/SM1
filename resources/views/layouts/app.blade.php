<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Todana - Toko Online')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <!-- Navigation bar -->
    <nav class="bg-white shadow">
        <!-- Container navigation -->
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <!-- Logo dan menu utama -->
                <div class="flex">
                    <a href="{{ route('home') }}" class="flex items-center text-xl font-bold">Todana.</a>
                    <div class="hidden md:flex ml-6 space-x-4">
                        <a href="{{ route('home') }}" class="flex items-center px-3 text-sm font-medium">Home</a>
                        <a href="{{ route('products.index') }}" class="flex items-center px-3 text-sm text-gray-600 hover:text-gray-900">Product</a>
                        <a href="{{ route('about') }}" class="flex items-center px-3 text-sm text-gray-600 hover:text-gray-900">About</a>
                        <a href="{{ route('contact') }}" class="flex items-center px-3 text-sm text-gray-600 hover:text-gray-900">Contact</a>
                    </div>
                </div>
                <!-- Menu kanan (login/profile) -->
                <div class="hidden md:flex items-center space-x-4">
                    @auth
                        <a href="{{ route('profile') }}" class="text-sm text-gray-600 hover:text-gray-900">Profile</a>
                        @if(auth()->user()->isAdmin())
                            <a href="/admin" class="text-sm text-gray-600 hover:text-gray-900">Admin Panel</a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-sm text-gray-600 hover:text-gray-900">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-900">Login</a>
                        <a href="{{ route('register') }}" class="text-sm text-gray-600 hover:text-gray-900">Signup</a>
                    @endauth
                </div>
                <!-- Tombol mobile menu -->
                <div class="md:hidden flex items-center">
                    <button type="button" class="p-2" id="mobile-menu-button">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <!-- Mobile menu -->
        <div class="md:hidden hidden" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="{{ route('home') }}" class="block px-3 py-2 text-base font-medium">Home</a>
                <a href="{{ route('products.index') }}" class="block px-3 py-2 text-base text-gray-600">Product</a>
                <a href="{{ route('about') }}" class="block px-3 py-2 text-base text-gray-600">About</a>
                <a href="{{ route('contact') }}" class="block px-3 py-2 text-base text-gray-600">Contact</a>
                @auth
                    <a href="{{ route('profile') }}" class="block px-3 py-2 text-base text-gray-600">Profile</a>
                    @if(auth()->user()->isAdmin())
                        <a href="/admin" class="block px-3 py-2 text-base text-gray-600">Admin Panel</a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST" class="block">
                        @csrf
                        <button type="submit" class="block w-full text-left px-3 py-2 text-base text-gray-600">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block px-3 py-2 text-base text-gray-600">Login</a>
                    <a href="{{ route('register') }}" class="block px-3 py-2 text-base text-gray-600">Signup</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main content -->
    <main class="max-w-7xl mx-auto px-4 py-8">
        <!-- Alert success -->
        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                <span>{{ session('success') }}</span>
                <button type="button" class="absolute top-0 right-0 px-4 py-3" onclick="this.parentElement.remove()">
                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                    </svg>
                </button>
            </div>
        @endif

        <!-- Alert error -->
        @if(session('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                <span>{{ session('error') }}</span>
                <button type="button" class="absolute top-0 right-0 px-4 py-3" onclick="this.parentElement.remove()">
                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                    </svg>
                </button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-100 mt-12">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <p class="text-center text-gray-600">&copy; {{ date('Y') }} Todana. - Toko Online Sederhana</p>
        </div>
    </footer>

    <script>
        // Toggle mobile menu
        document.getElementById('mobile-menu-button')?.addEventListener('click', function() {
            document.getElementById('mobile-menu')?.classList.toggle('hidden');
        });
    </script>
</body>
</html>
