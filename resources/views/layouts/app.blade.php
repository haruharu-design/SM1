<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Todana - Toko Online')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <a href="{{ route('home') }}" class="text-xl font-bold text-gray-900">Todana.</a>
                    </div>
                    <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        <a href="{{ route('home') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-900 hover:text-gray-700">Home</a>
                        <a href="{{ route('products.index') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-500 hover:text-gray-700">Product</a>
                        <a href="{{ route('about') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-500 hover:text-gray-700">About</a>
                        <a href="{{ route('contact') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-500 hover:text-gray-700">Contact</a>
                    </div>
                </div>
                <div class="hidden sm:ml-6 sm:flex sm:items-center sm:space-x-4">
                    @auth
                        <a href="{{ route('profile') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">Profile</a>
                        @if(auth()->user()->isAdmin())
                            <a href="/admin" class="text-sm font-medium text-gray-500 hover:text-gray-700">Admin Panel</a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-sm font-medium text-gray-500 hover:text-gray-700">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">Login</a>
                        <a href="{{ route('register') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">Signup</a>
                    @endauth
                </div>
                <!-- Mobile menu button -->
                <div class="sm:hidden flex items-center">
                    <button type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500" id="mobile-menu-button">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <!-- Mobile menu -->
        <div class="sm:hidden hidden" id="mobile-menu">
            <div class="pt-2 pb-3 space-y-1">
                <a href="{{ route('home') }}" class="block pl-3 pr-4 py-2 text-base font-medium text-gray-900">Home</a>
                <a href="{{ route('products.index') }}" class="block pl-3 pr-4 py-2 text-base font-medium text-gray-500">Product</a>
                <a href="{{ route('about') }}" class="block pl-3 pr-4 py-2 text-base font-medium text-gray-500">About</a>
                <a href="{{ route('contact') }}" class="block pl-3 pr-4 py-2 text-base font-medium text-gray-500">Contact</a>
                @auth
                    <a href="{{ route('profile') }}" class="block pl-3 pr-4 py-2 text-base font-medium text-gray-500">Profile</a>
                    @if(auth()->user()->isAdmin())
                        <a href="/admin" class="block pl-3 pr-4 py-2 text-base font-medium text-gray-500">Admin Panel</a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST" class="block">
                        @csrf
                        <button type="submit" class="block w-full text-left pl-3 pr-4 py-2 text-base font-medium text-gray-500">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block pl-3 pr-4 py-2 text-base font-medium text-gray-500">Login</a>
                    <a href="{{ route('register') }}" class="block pl-3 pr-4 py-2 text-base font-medium text-gray-500">Signup</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
                <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.remove()">
                    <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <title>Close</title>
                        <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                    </svg>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
                <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.remove()">
                    <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <title>Close</title>
                        <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                    </svg>
                </button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-100 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <p class="text-center text-gray-600">&copy; {{ date('Y') }} Todana. - Toko Online Sederhana</p>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button')?.addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu?.classList.toggle('hidden');
        });
    </script>
</body>
</html>
