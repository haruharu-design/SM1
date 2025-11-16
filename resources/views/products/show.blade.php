@extends('layouts.app')

@section('title', 'Product Detail - Todana')

@section('content')
<div class="max-w-7xl mx-auto">
    <a href="{{ route('products.index') }}" class="inline-block text-gray-600 hover:text-gray-900 mb-4">← Kembali</a>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div>
            <img src="{{ asset('images/todana/buku' . ($id % 6 == 0 ? 6 : $id % 6) . '.jpg') }}" class="w-full rounded-lg shadow-lg" alt="Product">
        </div>
        <div>
            <h1 class="text-3xl font-bold mb-2">Product {{ $id }}</h1>
            <p class="text-gray-600 mb-4">Kategori: Buku</p>
            <h3 class="text-2xl text-red-600 font-bold mb-6">Rp {{ number_format(50000 + ($id * 1000), 0, ',', '.') }}</h3>
            
            <div class="mb-6">
                <h4 class="text-xl font-semibold mb-2">Deskripsi</h4>
                <p class="text-gray-700">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.</p>
            </div>

            <div class="mb-6">
                <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">Jumlah</label>
                <input type="number" class="w-24 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" id="quantity" value="1" min="1">
            </div>

            <div class="flex gap-4">
                <button class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors text-lg font-semibold">Beli Sekarang</button>
                <button class="border-2 border-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-50 transition-colors text-lg font-semibold">Tambah ke Wishlist</button>
            </div>
        </div>
    </div>
</div>
@endsection
