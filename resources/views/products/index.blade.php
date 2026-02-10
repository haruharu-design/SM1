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
            @if($products->total() > 0)
                {{ $products->total() }} produk tersedia
            @else
                Produk akan ditampilkan setelah admin mengisi data
            @endif
        </p>
    </div>

    <!-- Grid produk -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        @forelse($products as $product)
        <div class="bg-white/80 backdrop-blur-sm border border-gray-200 rounded-xl shadow-lg p-4 hover:shadow-xl transition-shadow relative">
            @auth
            <form action="{{ route('wishlist.toggle') }}" method="POST" class="absolute top-2 right-2 z-10">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <button type="submit" class="p-1 rounded-full bg-white/80 shadow" title="{{ in_array($product->id, $wishlistIds ?? []) ? 'Hapus dari wishlist' : 'Tambah ke wishlist' }}">
                    <span class="text-xl">{{ in_array($product->id, $wishlistIds ?? []) ? '❤️' : '🤍' }}</span>
                </button>
            </form>
            @endauth

            <!-- Gambar produk -->
            <div class="w-full h-64 rounded-lg mb-4 overflow-hidden
                        bg-gradient-to-br from-gray-200 to-gray-300
                        flex items-center justify-center">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" 
                         alt="{{ $product->name }}"
                         class="w-full h-full object-cover">
                @else
                    <span class="text-gray-500 text-sm italic">Gambar produk</span>
                @endif
            </div>

            <h5 class="text-lg font-semibold mb-2 text-gray-900">
                {{ $product->name }}
            </h5>

            <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                {{ Str::limit($product->description, 80) ?: 'Deskripsi produk' }}
            </p>

            <p class="text-gray-900 font-bold mb-4">
                Rp {{ number_format($product->price, 0, ',', '.') }}
            </p>

            <div class="flex gap-2 flex-wrap">
                <a href="{{ route('products.show', $product->id) }}"
                   class="inline-block bg-gradient-to-r from-red-500 to-blue-500 text-white px-4 py-2 rounded-lg hover:opacity-90 transition-opacity">
                    Lihat Detail
                </a>
                @auth
                <form action="{{ route('cart.add') }}" method="POST" class="inline">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="border border-gray-600 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-100">
                        + Keranjang
                    </button>
                </form>
                @endauth
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-12 text-gray-500">
            <p>Belum ada produk. Silakan tambah produk di Admin Panel.</p>
        </div>
        @endforelse

    </div>

    @if($products->hasPages())
    <div class="mt-8 flex justify-center">
        {{ $products->links() }}
    </div>
    @endif
</div>
@endsection
