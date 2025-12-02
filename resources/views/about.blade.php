@extends('layouts.app')

@section('title', 'About - Todana')

@section('content')
<!-- Container utama -->
<div class="max-w-7xl mx-auto">
    <!-- Section tentang kami -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold mb-6">Tentang Kami</h1>
        <!-- Flex layout dengan gambar -->
        <div class="flex flex-col md:flex-row gap-6 mb-8">
            <img src="{{ asset('images/todana/about-us.png') }}" class="w-40 h-auto" alt="About Us">
            <div>
                <p class="text-xl font-bold mb-4">Selamat datang di Toko Sinar Mentari</p>
                <p class="text-gray-700 mb-3">Kami menyediakan berbagai kebutuhan alat tulis kantor (ATK) lengkap dan berkualitas dengan harga terjangkau. Hadir dengan pelayanan ramah dan pilihan produk yang variatif, kami siap menjadi tempat terbaik untuk memenuhi kebutuhan sekolah, kerja, maupun usaha Anda.</p>
            </div>
        </div>
    </div>

    <!-- Section visi misi -->
    <div class="bg-gray-100 p-6 rounded-lg">
        <h3 class="text-2xl font-bold mb-4">Komitmen Kami</h3>
        <!-- isi -->
        <ul class="list-disc list-inside text-gray-700 space-y-2 text-justify leading-relaxed">
            <li>Toko Sinar Mentari hadir sebagai tempat belanja ATK yang lengkap, terjangkau, dan mudah dijangkau oleh siapa pun. Kami menghadirkan berbagai perlengkapan sekolah dan kantor dengan kualitas terbaik, didukung pelayanan ramah agar setiap kunjungan terasa menyenangkan. Berawal dari kebutuhan masyarakat akan toko ATK yang praktis dan terpercaya.</li>
           <li>Kami akan terus berkembang menjadi pilihan utama bagi pelanggan yang mencari produk variatif, harga bersahabat, dan pengalaman belanja yang nyaman. Dengan komitmen untuk selalu memberikan layanan yang cepat, responsif, dan dapat diandalkan, kami siap menjadi mitra terbaik dalam memenuhi kebutuhan Anda setiap hari.”</li>
        </ul>
    </div>
</div>
@endsection

