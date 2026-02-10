<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Sinar Mentari - Toko Online')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">

    <!-- Navigation bar -->
    <nav class="bg-gradient-to-r from-red-500/80 to-blue-500/80 backdrop-blur shadow">
        <!-- Container navigation -->
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">

                <!-- Logo dan menu utama -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2 font-bold">
                        <img 
                            src="{{ asset('images/todana/logo2.png') }}" 
                            alt="Sinar Mentari Logo"
                            class="h-8 w-auto"
                        >
                    </a>

                    <div class="hidden md:flex ml-6 space-x-4">
                        <a href="{{ route('home') }}" class="px-3 text-sm font-medium text-white hover:underline">
                            Home
                        </a>
                        <a href="{{ route('products.index') }}" class="px-3 text-sm text-white/90 hover:underline">
                            Product
                        </a>
                        <a href="{{ route('about') }}" class="px-3 text-sm text-white/90 hover:underline">
                            About
                        </a>
                        <a href="{{ route('contact') }}" class="px-3 text-sm text-white/90 hover:underline">
                            Contact
                        </a>
                    </div>
                </div>

                <!-- Menu kanan -->
                <div class="hidden md:flex items-center space-x-4 text-white">
                    @auth
                        <a href="{{ route('cart.index') }}" class="text-sm hover:underline">Keranjang</a>
                        <a href="{{ route('wishlist.index') }}" class="text-sm hover:underline">Wishlist</a>
                        <a href="{{ route('orders.index') }}" class="text-sm hover:underline">Pesanan</a>
                        <a href="{{ route('profile') }}" class="text-sm hover:underline">Profile</a>
                        @if(auth()->user()->isAdmin())
                            <a href="/admin" class="text-sm hover:underline">Admin Panel</a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="text-sm hover:underline">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-sm hover:underline">Login</a>
                        <a href="{{ route('register') }}" class="text-sm hover:underline">Signup</a>
                    @endauth
                </div>

                <!-- Tombol mobile -->
                <div class="md:hidden flex items-center text-white">
                    <button type="button" class="p-2" id="mobile-menu-button">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>

            </div>
        </div>

        <!-- Mobile menu -->
        <div class="md:hidden hidden bg-gradient-to-b from-red-500/90 to-blue-500/90" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1 text-white">
                <a href="{{ route('home') }}" class="block px-3 py-2">Home</a>
                <a href="{{ route('products.index') }}" class="block px-3 py-2">Product</a>
                <a href="{{ route('about') }}" class="block px-3 py-2">About</a>
                <a href="{{ route('contact') }}" class="block px-3 py-2">Contact</a>

                @auth
                    <a href="{{ route('cart.index') }}" class="block px-3 py-2">Keranjang</a>
                    <a href="{{ route('wishlist.index') }}" class="block px-3 py-2">Wishlist</a>
                    <a href="{{ route('orders.index') }}" class="block px-3 py-2">Pesanan</a>
                    <a href="{{ route('profile') }}" class="block px-3 py-2">Profile</a>
                    @if(auth()->user()->isAdmin())
                        <a href="/admin" class="block px-3 py-2">Admin Panel</a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="block w-full text-left px-3 py-2">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block px-3 py-2">Login</a>
                    <a href="{{ route('register') }}" class="block px-3 py-2">Signup</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main content -->
    <main class="max-w-7xl mx-auto px-4 py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-100 mt-12">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <p class="text-center text-gray-600">
                &copy; {{ date('Y') }} SM. - Toko Sinar Mentari Pontianak
            </p>
        </div>
    </footer>

    <script>
        document.getElementById('mobile-menu-button')
            ?.addEventListener('click', () => {
                document.getElementById('mobile-menu')?.classList.toggle('hidden')
            })
    </script>

</body>
</html>
