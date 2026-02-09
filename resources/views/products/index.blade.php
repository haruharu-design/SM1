@extends('layouts.app')

@section('title', 'Products - Todana')

@section('content')

<!-- Container utama -->
<div class="max-w-7xl mx-auto 
    bg-gradient-to-br from-red-500/10 to-blue-500/10 
    rounded-2xl p-6">

    <!-- Judul halaman -->
    <div class="text-center mb-10">
        <h1 class="text-4xl font-bold mb-2 text-gray-900">
            Daftar Produk
        </h1>
        <p class="text-gray-600">
            Produk akan ditampilkan setelah admin mengisi data
        </p>
    </div>

    <!-- Grid produk (PLACEHOLDER) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        @for($i = 1; $i <= 6; $i++)
        <div class="bg-white/80 backdrop-blur-sm 
                    border border-gray-200 
                    rounded-xl shadow-lg p-4">

            <!-- Placeholder gambar -->
            <div class="w-full h-64 rounded-lg mb-4
                        bg-gradient-to-br from-gray-200 to-gray-300
                        flex items-center justify-center
                        text-gray-500 text-sm italic">
                Gambar produk
            </div>

            <!-- Placeholder nama -->
            <h5 class="text-lg font-semibold mb-2 text-gray-500 italic">
                Nama produk
            </h5>

            <!-- Placeholder deskripsi -->
            <p class="text-gray-400 text-sm mb-3 italic">
                Deskripsi produk
            </p>

            <!-- Placeholder harga -->
            <p class="text-gray-500 font-medium mb-4 italic">
                Harga produk
            </p>

            <!-- Tombol non-aktif -->
            <button
                class="bg-gradient-to-r from-red-500 to-blue-500
                       text-white px-4 py-2 rounded-lg
                       opacity-60 cursor-not-allowed">
                Lihat Detail
            </button>
        </div>
        @endfor

    </div>
</div>
@endsection
