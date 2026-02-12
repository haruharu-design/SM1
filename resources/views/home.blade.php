@extends('layouts.app')

@section('title', 'Home - Todana')

@section('content')

<!-- Container utama -->
<div class="max-w-7xl mx-auto 
    bg-gradient-to-br from-red-500/10 to-blue-500/10 
    rounded-2xl p-6">

    <!-- ===================== -->
    <!-- Banner Carousel -->
    <!-- ===================== -->
    <div class="relative mb-10 overflow-hidden rounded-xl shadow-lg">

        <!-- Slides -->
        <div id="carousel" class="flex transition-transform duration-700">

            <!-- Slide 1 -->
            <div class="min-w-full h-64 flex items-center justify-center
                        bg-gradient-to-r from-red-500 to-red-400 text-white">
                <div class="text-center px-6">
                    <h2 class="text-3xl font-bold mb-2">
                        Promo Spesial Hari Ini
                    </h2>
                    <p class="text-white/90">
                        Diskon menarik untuk produk pilihan
                    </p>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="min-w-full h-64 flex items-center justify-center
                        bg-gradient-to-r from-blue-500 to-blue-400 text-white">
                <div class="text-center px-6">
                    <h2 class="text-3xl font-bold mb-2">
                        Koleksi Terbaru
                    </h2>
                    <p class="text-white/90">
                        Produk terbaru dengan kualitas terbaik
                    </p>
                </div>
            </div>

            <!-- Slide 3 -->
            <div class="min-w-full h-64 flex items-center justify-center
                        bg-gradient-to-r from-purple-500 to-pink-500 text-white">
                <div class="text-center px-6">
                    <h2 class="text-3xl font-bold mb-2">
                        Belanja Lebih Mudah
                    </h2>
                    <p class="text-white/90">
                        Pengalaman belanja nyaman dan aman
                    </p>
                </div>
            </div>

        </div>

        <!-- Indicator -->
        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2">
            <span class="dot w-3 h-3 bg-white/50 rounded-full"></span>
            <span class="dot w-3 h-3 bg-white/50 rounded-full"></span>
            <span class="dot w-3 h-3 bg-white/50 rounded-full"></span>
        </div>
    </div>

    <!-- ===================== -->
    <!-- Judul Section -->
    <!-- ===================== -->
    <div class="text-center mb-10">
        <h2 class="text-3xl font-bold mb-2 text-gray-900">
            Our Collections
        </h2>
        <p class="text-gray-600">
            Temukan produk terbaik untuk kebutuhan Anda
        </p>
    </div>

    {{-- Rekomendasi Personalisasi (jika ada) --}}
    @if(isset($recommendations) && $recommendations->isNotEmpty())
    <div class="mb-12">
        <h3 class="text-xl font-bold mb-4 text-gray-900">Rekomendasi untuk Anda</h3>
        <p class="text-gray-600 text-sm mb-4">Berdasarkan minat dan riwayat belanja Anda</p>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            @foreach($recommendations->take(6) as $product)
            <div class="bg-white/80 backdrop-blur-sm border border-gray-200 rounded-xl shadow-lg p-4 text-gray-900 hover:shadow-xl transition-shadow relative">
                @auth
                <form action="{{ route('wishlist.toggle') }}" method="POST" class="absolute top-2 right-2 z-10">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <button type="submit" class="p-1 rounded-full bg-white/80 shadow">
                        <span class="text-xl">{{ in_array($product->id, $wishlistIds ?? []) ? '❤️' : '🤍' }}</span>
                    </button>
                </form>
                @endauth
                <div class="w-full h-48 rounded-lg mb-4 overflow-hidden bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    @else
                        <span class="text-gray-500 text-sm italic">Gambar produk</span>
                    @endif
                </div>
                <h5 class="text-lg font-semibold mb-2 text-gray-900">{{ $product->name }}</h5>
                <p class="text-gray-900 font-bold mb-4">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                <div class="flex gap-2">
                    <a href="{{ route('products.show', $product->id) }}" class="inline-block bg-gradient-to-r from-red-500 to-blue-500 text-white px-4 py-2 rounded-lg hover:opacity-90 transition-opacity text-sm">Lihat Detail</a>
                    @auth
                    <form action="{{ route('cart.add') }}" method="POST" class="inline">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="border border-gray-600 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-100 text-sm">+ Keranjang</button>
                    </form>
                    @endauth
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- ===================== -->
    <!-- Grid Produk -->
    <!-- ===================== -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">

        @forelse($products as $product)
        <div class="bg-white/80 backdrop-blur-sm border border-gray-200 rounded-xl shadow-lg p-4 text-gray-900 hover:shadow-xl transition-shadow relative">
            @if($product->category)
            <span class="absolute top-2 left-2 text-xs px-2 py-0.5 rounded bg-gray-200/90 text-gray-600 z-10">{{ $product->category->name }}</span>
            @endif
            @auth
            <form action="{{ route('wishlist.toggle') }}" method="POST" class="absolute top-2 right-2 z-10">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <button type="submit" class="p-1 rounded-full bg-white/80 shadow">
                    <span class="text-xl">{{ in_array($product->id, $wishlistIds ?? []) ? '❤️' : '🤍' }}</span>
                </button>
            </form>
            @endauth

            <div class="w-full h-64 rounded-lg mb-4 overflow-hidden
                        bg-gradient-to-br from-gray-200 to-gray-300 
                        flex items-center justify-center">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" 
                         alt="{{ $product->name }}"
                         class="w-full h-full object-cover">
                @else
                    <span class="text-gray-500 text-sm italic">Gambar produk</span>
                @endif
            </div>

            <h5 class="text-lg font-semibold mb-2 text-gray-900">
                {{ $product->name }}
            </h5>

            <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                {{ Str::limit($product->description, 60) ?: 'Deskripsi produk' }}
            </p>

            <p class="text-gray-900 font-bold mb-4">
                Rp {{ number_format($product->price, 0, ',', '.') }}
            </p>

            <div class="flex gap-2 flex-wrap">
                <a href="{{ route('products.show', $product->id) }}"
                   class="inline-block bg-gradient-to-r from-red-500 to-blue-500 text-white px-4 py-2 rounded-lg hover:opacity-90 transition-opacity">
                    Lihat Detail
                </a>
                @auth
                <form action="{{ route('cart.add') }}" method="POST" class="inline">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="border border-gray-600 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-100">+ Keranjang</button>
                </form>
                @endauth
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-8 text-gray-500 italic">
            Belum ada produk. Silakan tambah produk di Admin Panel.
        </div>
        @endforelse

    </div>

    <!-- Tombol Lihat Semua -->
    <div class="text-center">
        <a href="{{ route('products.index') }}"
           class="inline-block border-2 border-gray-800 text-gray-800 
                  px-6 py-2 rounded-lg hover:bg-gray-800 hover:text-white transition-colors">
            Lihat Semua Produk
        </a>
    </div>

</div>

<!-- ===================== -->
<!-- Carousel Script -->
<!-- ===================== -->
<script>
    const carousel = document.getElementById('carousel');
    const dots = document.querySelectorAll('.dot');
    let index = 0;
    const totalSlides = 3;

    function showSlide(i) {
        carousel.style.transform = `translateX(-${i * 100}%)`;
        dots.forEach((dot, idx) => {
            dot.classList.toggle('bg-white', idx === i);
            dot.classList.toggle('bg-white/50', idx !== i);
        });
    }

    setInterval(() => {
        index = (index + 1) % totalSlides;
        showSlide(index);
    }, 4000);

    showSlide(index);
</script>

@endsection
