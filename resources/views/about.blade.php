@extends('layouts.app')

@section('title', 'About - SM')

@section('content')

<!-- Container utama (SAMA KAYAK HOME) -->
<div class="max-w-7xl mx-auto 
    bg-gradient-to-br from-red-500/10 to-blue-500/10 
    rounded-2xl p-6">

    <!-- Section tentang kami -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold mb-6 text-gray-900">
            Tentang Kami
        </h1>

        <!-- Card konten -->
        <div class="bg-white/80 backdrop-blur-sm 
                    border border-gray-200 
                    rounded-xl shadow-lg p-6">

            <!-- Flex layout -->
            <div class="flex flex-col md:flex-row items-center gap-6 mb-6">

                <!-- Logo -->
                <img 
                    src="{{ asset('images/todana/logo2.png') }}" 
                    alt="Logo Sinar Mentari"
                    class="w-32 h-auto flex-shrink-0"
                >

                <!-- Teks (TIDAK DIUBAH) -->
                <div>
                    <p class="text-xl font-bold mb-4">
                        Selamat datang di Toko Sinar Mentari
                    </p>
                    <p class="text-gray-700 mb-3">
                        Kami menyediakan berbagai kebutuhan alat tulis kantor (ATK) lengkap dan berkualitas dengan harga terjangkau. Hadir dengan pelayanan ramah dan pilihan produk yang variatif, kami siap menjadi tempat terbaik untuk memenuhi kebutuhan sekolah, kerja, maupun usaha Anda.
                    </p>
                </div>

            </div>
        </div>
    </div>

    <!-- Section visi misi -->
    <div class="bg-white/80 backdrop-blur-sm 
                border border-gray-200 
                rounded-xl shadow-lg p-6">

        <h3 class="text-2xl font-bold mb-4 text-gray-900">
            Komitmen Kami
        </h3>

        <ul class="list-disc list-inside text-gray-700 space-y-3 text-justify leading-relaxed">
            <li>
                Toko Sinar Mentari hadir sebagai tempat belanja ATK yang lengkap, terjangkau, dan mudah dijangkau oleh siapa pun. Kami menghadirkan berbagai perlengkapan sekolah dan kantor dengan kualitas terbaik, didukung pelayanan ramah agar setiap kunjungan terasa menyenangkan. Berawal dari kebutuhan masyarakat akan toko ATK yang praktis dan terpercaya.
            </li>
            <li>
                Kami akan terus berkembang menjadi pilihan utama bagi pelanggan yang mencari produk variatif, harga bersahabat, dan pengalaman belanja yang nyaman. Dengan komitmen untuk selalu memberikan layanan yang cepat, responsif, dan dapat diandalkan, kami siap menjadi mitra terbaik dalam memenuhi kebutuhan Anda setiap hari.
            </li>
        </ul>
    </div>

</div>

@endsection
