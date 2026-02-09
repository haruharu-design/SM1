@extends('layouts.app')

@section('title', 'Product Detail - Todana')

@section('content')

<!-- Container utama -->
<div class="max-w-7xl mx-auto
    bg-gradient-to-br from-red-500/10 to-blue-500/10
    rounded-2xl p-6">

    <!-- Tombol kembali -->
    <a href="{{ route('products.index') }}" 
       class="inline-block mb-6 text-gray-600 hover:text-gray-900">
        ← Kembali ke Produk
    </a>

    <!-- Grid detail -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

        <!-- Placeholder gambar -->
        <div class="w-full h-96 rounded-xl
                    bg-gradient-to-br from-gray-200 to-gray-300
                    flex items-center justify-center
                    text-gray-500 italic">
            Gambar produk
        </div>

        <!-- Informasi produk -->
        <div class="bg-white/80 backdrop-blur-sm
                    border border-gray-200
                    rounded-xl shadow-lg p-6">

            <!-- Nama produk -->
            <h1 class="text-3xl font-bold mb-2 text-gray-500 italic">
                Nama produk
            </h1>

            <!-- Kategori -->
            <p class="text-gray-400 mb-4 italic">
                Kategori produk
            </p>

            <!-- Harga -->
            <h3 class="text-2xl font-bold mb-6 text-gray-500 italic">
                Harga produk
            </h3>

            <!-- Deskripsi -->
            <div class="mb-6">
                <h4 class="text-xl font-bold mb-2 text-gray-700">
                    Deskripsi
                </h4>
                <p class="text-gray-400 italic">
                    Isi deskripsi produk akan ditampilkan di sini
                </p>
            </div>

            <!-- Jumlah -->
            <div class="mb-6">
                <label class="block text-sm font-bold mb-2 text-gray-600">
                    Jumlah
                </label>
                <input type="number"
                       class="w-24 px-4 py-2 border rounded
                              opacity-60 cursor-not-allowed"
                       value="1" disabled>
            </div>

            <!-- Tombol aksi -->
            <div class="flex gap-4">
                <button
                    class="bg-gradient-to-r from-red-500 to-blue-500
                           text-white px-6 py-3 rounded-lg
                           opacity-60 cursor-not-allowed font-bold">
                    Beli Sekarang
                </button>

                <button
                    class="border-2 border-gray-300
                           text-gray-500 px-6 py-3 rounded-lg
                           opacity-60 cursor-not-allowed font-bold">
                    Tambah ke Wishlist
                </button>
            </div>

        </div>
    </div>
</div>
@endsection
