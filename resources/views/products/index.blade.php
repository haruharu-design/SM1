@extends('layouts.app')

@section('title', 'Products - Todana')

@section('content')
<!-- Container utama -->
<div class="max-w-7xl mx-auto">
    <!-- Judul halaman -->
    <h1 class="text-4xl font-bold mb-8">Daftar Produk</h1>

    <!-- Grid produk -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @for($i = 1; $i <= 6; $i++)
        <!-- Card produk -->
        <div class="bg-white rounded-lg shadow p-4">
            <img src="{{ asset('images/todana/buku' . $i . '.jpg') }}" class="w-full h-64 object-cover rounded mb-4" alt="Product {{ $i }}">
            <h5 class="text-lg font-bold mb-2">Product {{ $i }}</h5>
            <p class="text-gray-600 text-sm mb-3">Deskripsi produk singkat untuk produk {{ $i }}</p>
            <p class="text-red-600 font-bold mb-3">Rp {{ number_format(50000 + ($i * 1000), 0, ',', '.') }}</p>
            <a href="{{ route('products.show', $i) }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Lihat Detail</a>
        </div>
        @endfor
    </div>
</div>
@endsection
