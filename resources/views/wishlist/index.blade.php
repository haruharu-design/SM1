@extends('layouts.app')

@section('title', 'Wishlist - Todana')

@section('content')
<div class="max-w-7xl mx-auto bg-gradient-to-br from-red-500/10 to-blue-500/10 rounded-2xl p-6">
    <h1 class="text-3xl font-bold mb-6 text-gray-900">Wishlist Saya</h1>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">{{ session('success') }}</div>
    @endif

    @if($wishlists->isEmpty())
        <div class="text-center py-12 text-gray-600">
            <p class="mb-4">Wishlist Anda kosong.</p>
            <a href="{{ route('products.index') }}" class="inline-block bg-gradient-to-r from-red-500 to-blue-500 text-white px-6 py-2 rounded-lg hover:opacity-90">Jelajahi Produk</a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($wishlists as $wishlist)
            <div class="bg-white/80 rounded-xl shadow-lg p-4 relative">
                <form action="{{ route('wishlist.remove', $wishlist->product_id) }}" method="POST" class="absolute top-2 right-2">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="p-1 rounded-full bg-white/80 shadow hover:bg-red-100" title="Hapus dari wishlist">❤️</button>
                </form>
                @if($wishlist->product->image)
                    <img src="{{ asset('storage/' . $wishlist->product->image) }}" alt="{{ $wishlist->product->name }}" class="w-full h-48 object-cover rounded-lg mb-3">
                @else
                    <div class="w-full h-48 bg-gray-200 rounded-lg flex items-center justify-center text-gray-400 mb-3">No image</div>
                @endif
                <h3 class="font-bold text-gray-900">{{ $wishlist->product->name }}</h3>
                <p class="text-gray-700 font-bold">Rp {{ number_format($wishlist->product->price, 0, ',', '.') }}</p>
                <a href="{{ route('products.show', $wishlist->product_id) }}" class="inline-block mt-2 text-blue-600 hover:underline text-sm">Lihat Detail</a>
            </div>
            @endforeach
        </div>
        <div class="mt-6">{{ $wishlists->links() }}</div>
    @endif
</div>
@endsection
