@extends('layouts.app')

@section('title', 'Products - Todana')

@section('content')
<div class="max-w-7xl mx-auto">
    <h1 class="text-4xl font-bold mb-8">Daftar Produk</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @for($i = 1; $i <= 6; $i++)
        <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow">
            <img src="{{ asset('images/todana/buku' . $i . '.jpg') }}" class="w-full h-64 object-cover" alt="Product {{ $i }}">
            <div class="p-4">
                <h5 class="text-lg font-semibold mb-2">Product {{ $i }}</h5>
                <p class="text-gray-600 text-sm mb-3">Deskripsi produk singkat untuk produk {{ $i }}</p>
                <p class="text-red-600 font-bold mb-3">Rp {{ number_format(50000 + ($i * 1000), 0, ',', '.') }}</p>
                <a href="{{ route('products.show', $i) }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition-colors">Lihat Detail</a>
            </div>
        </div>
        @endfor
    </div>
</div>
@endsection
