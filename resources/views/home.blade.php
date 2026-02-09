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

    <!-- ===================== -->
    <!-- Grid Produk (Placeholder) -->
    <!-- ===================== -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">

        @for ($i = 1; $i <= 6; $i++)
        <div class="bg-white/80 backdrop-blur-sm border border-gray-200 
                    rounded-xl shadow-lg p-4 text-gray-900">

            <!-- Placeholder gambar -->
            <div class="w-full h-64 rounded-lg mb-4 
                        bg-gradient-to-br from-gray-200 to-gray-300 
                        flex items-center justify-center 
                        text-gray-500 text-sm italic">
                Gambar produk akan ditampilkan di sini
            </div>

            <!-- Placeholder nama -->
            <h5 class="text-lg font-semibold mb-2 text-gray-500 italic">
                Nama produk
            </h5>

            <!-- Placeholder deskripsi -->
            <p class="text-gray-400 text-sm mb-3 italic">
                Isi deskripsi produk
            </p>

            <!-- Placeholder harga -->
            <p class="text-gray-500 font-medium mb-4 italic">
                Harga produk
            </p>

            <!-- Tombol -->
            <button 
                class="bg-gradient-to-r from-red-500 to-blue-500 
                       text-white px-4 py-2 rounded-lg 
                       opacity-60 cursor-not-allowed">
                Lihat Detail
            </button>
        </div>
        @endfor

    </div>

    <!-- ===================== -->
    <!-- Tombol Lihat Semua -->
    <!-- ===================== -->
    <div class="text-center">
        <button 
            class="border-2 border-gray-800 text-gray-800 
                   px-6 py-2 rounded-lg 
                   opacity-60 cursor-not-allowed">
            Lihat Semua Produk
        </button>
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
