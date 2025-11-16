@extends('layouts.app')

@section('title', 'Home - Todana')

@section('content')
<!-- Container utama -->
<div class="max-w-7xl mx-auto">
    <!-- Banner -->
    <div class="mb-8">
        <img src="{{ asset('images/todana/banner.png') }}" class="w-full rounded-lg shadow-lg" alt="Banner">
    </div>

    <!-- Judul section -->
    <div class="text-center mb-10">
        <h2 class="text-3xl font-bold mb-2">Our Collections</h2>
        <p class="text-gray-600">Temukan produk terbaik untuk kebutuhan Anda</p>
    </div>

    <!-- Grid produk -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <!-- Card produk 1 -->
        <div class="bg-white rounded-lg shadow p-4">
            <img src="{{ asset('images/todana/buku1.jpg') }}" class="w-full h-64 object-cover rounded mb-4" alt="Product">
            <h5 class="text-lg font-bold mb-2">Product 1</h5>
            <p class="text-gray-600 text-sm mb-3">Deskripsi produk singkat</p>
            <a href="{{ route('products.show', 1) }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Lihat Detail</a>
        </div>
        <!-- Card produk 2 -->
        <div class="bg-white rounded-lg shadow p-4">
            <img src="{{ asset('images/todana/buku2.jpg') }}" class="w-full h-64 object-cover rounded mb-4" alt="Product">
            <h5 class="text-lg font-bold mb-2">Product 2</h5>
            <p class="text-gray-600 text-sm mb-3">Deskripsi produk singkat</p>
            <a href="{{ route('products.show', 2) }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Lihat Detail</a>
        </div>
        <!-- Card produk 3 -->
        <div class="bg-white rounded-lg shadow p-4">
            <img src="{{ asset('images/todana/buku3.jpg') }}" class="w-full h-64 object-cover rounded mb-4" alt="Product">
            <h5 class="text-lg font-bold mb-2">Product 3</h5>
            <p class="text-gray-600 text-sm mb-3">Deskripsi produk singkat</p>
            <a href="{{ route('products.show', 3) }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Lihat Detail</a>
        </div>
    </div>

    <!-- Tombol lihat semua -->
    <div class="text-center">
        <a href="{{ route('products.index') }}" class="border-2 border-blue-600 text-blue-600 px-6 py-2 rounded hover:bg-blue-600 hover:text-white">Lihat Semua Produk</a>
    </div>
</div>
@endsection
