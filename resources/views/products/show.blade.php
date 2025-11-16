@extends('layouts.app')

@section('title', 'Product Detail - Todana')

@section('content')
<!-- Container utama -->
<div class="max-w-7xl mx-auto">
    <!-- Tombol kembali -->
    <a href="{{ route('products.index') }}" class="text-gray-600 hover:text-gray-900 mb-4 inline-block">← Kembali</a>

    <!-- Grid detail produk -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Gambar produk -->
        <div>
            <img src="{{ asset('images/todana/buku' . ($id % 6 == 0 ? 6 : $id % 6) . '.jpg') }}" class="w-full rounded-lg shadow-lg" alt="Product">
        </div>
        <!-- Informasi produk -->
        <div>
            <h1 class="text-3xl font-bold mb-2">Product {{ $id }}</h1>
            <p class="text-gray-600 mb-4">Kategori: Buku</p>
            <h3 class="text-2xl text-red-600 font-bold mb-6">Rp {{ number_format(50000 + ($id * 1000), 0, ',', '.') }}</h3>
            
            <!-- Deskripsi -->
            <div class="mb-6">
                <h4 class="text-xl font-bold mb-2">Deskripsi</h4>
                <p class="text-gray-700">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.</p>
            </div>

            <!-- Input jumlah -->
            <div class="mb-6">
                <label class="block text-sm font-bold mb-2">Jumlah</label>
                <input type="number" class="w-24 px-4 py-2 border rounded" value="1" min="1">
            </div>

            <!-- Tombol aksi -->
            <div class="flex gap-4">
                <button class="bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700 font-bold">Beli Sekarang</button>
                <button class="border-2 border-gray-300 text-gray-700 px-6 py-3 rounded hover:bg-gray-50 font-bold">Tambah ke Wishlist</button>
            </div>
        </div>
    </div>
</div>
@endsection
