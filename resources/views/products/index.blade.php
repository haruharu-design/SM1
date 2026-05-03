@extends('layouts.app')

@section('title', 'Products - SM' )

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

    <!-- Search Bar -->
    <form method="GET" action="{{ route('products.index') }}" class="mb-8 max-w-2xl mx-auto">
        <div class="flex gap-2">
            @foreach(request()->except('search', 'page') as $k => $v)
                @if($v)
                    <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                @endif
            @endforeach
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk (nama atau deskripsi)..."
                   class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-red-500 to-blue-500 text-white font-medium rounded-lg hover:opacity-90">
                Cari
            </button>
        </div>
    </form>

    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Sidebar Filter -->
        <aside class="lg:w-64 shrink-0">
            <div class="bg-white/90 backdrop-blur border border-gray-200 rounded-xl shadow-lg p-4 sticky top-4">
                <h3 class="font-bold text-gray-900 mb-4">Filter Produk</h3>

                <form method="GET" action="{{ route('products.index') }}" class="space-y-4" id="filter-form">
                    @foreach(request()->except('category', 'price_min', 'price_max', 'page') as $k => $v)
                        @if($v)
                            <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                        @endif
                    @endforeach

                    {{-- Filter Kategori --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                        <select name="category" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Filter Rentang Harga --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Harga Min (Rp)</label>
                        <input type="number" name="price_min" placeholder="0" min="0" step="1000"
                               value="{{ request('price_min') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Harga Max (Rp)</label>
                        <input type="number" name="price_max" placeholder="999999999" min="0" step="1000"
                               value="{{ request('price_max') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="flex-1 bg-gradient-to-r from-red-500 to-blue-500 text-white px-4 py-2 rounded-lg text-sm font-medium hover:opacity-90">
                            Terapkan
                        </button>
                        <a href="{{ route('products.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm hover:bg-gray-50">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            {{-- Rekomendasi personalisasi --}}
            @if($recommendations->isNotEmpty())
            <div class="mt-6 bg-white/90 backdrop-blur border border-gray-200 rounded-xl shadow-lg p-4">
                <h3 class="font-bold text-gray-900 mb-3">Rekomendasi untuk Anda</h3>
                <div class="space-y-3">
                    @foreach($recommendations->take(4) as $rec)
                    <a href="{{ route('products.show', $rec->id) }}" class="flex gap-3 p-2 rounded-lg hover:bg-gray-50">
                        <div class="w-14 h-14 rounded bg-gray-200 shrink-0 overflow-hidden flex items-center justify-center">
                            @if($rec->image)
                                <img src="{{ asset('storage/' . $rec->image) }}" alt="" class="w-full h-full object-cover">
                            @else
                                <span class="text-gray-400 text-xs">Foto</span>
                            @endif
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ $rec->name }}</p>
                            <p class="text-sm font-bold text-gray-700">Rp {{ number_format($rec->price, 0, ',', '.') }}</p>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </aside>

        <!-- Area Produk -->
        <div class="flex-1 min-w-0">
            {{-- Sort --}}
            <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
                <form method="GET" action="{{ route('products.index') }}" class="flex items-center gap-2" id="sort-form">
                    @foreach(request()->except('sort', 'page') as $k => $v)
                        @if($v)
                            <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                        @endif
                    @endforeach
                    <label class="text-sm text-gray-600">Urutkan:</label>
                    <select name="sort" class="px-3 py-2 border rounded-lg text-sm" onchange="this.form.submit()">
                        <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                        <option value="terpopuler" {{ request('sort') == 'terpopuler' ? 'selected' : '' }}>Terpopuler</option>
                        <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Rating Tertinggi</option>
                        <option value="harga_terendah" {{ request('sort') == 'harga_terendah' ? 'selected' : '' }}>Harga Terendah</option>
                        <option value="harga_tertinggi" {{ request('sort') == 'harga_tertinggi' ? 'selected' : '' }}>Harga Tertinggi</option>
                    </select>
                </form>
            </div>

            <!-- Grid produk -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

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

                    @if($product->category)
                    <span class="inline-block text-xs px-2 py-0.5 rounded bg-gray-200 text-gray-600 mb-2">{{ $product->category->name }}</span>
                    @endif

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
                    <p>Belum ada produk yang sesuai filter. Coba ubah filter atau lihat semua produk.</p>
                    <a href="{{ route('products.index') }}" class="text-blue-600 hover:underline mt-2 inline-block">Reset Filter</a>
                </div>
                @endforelse

            </div>

            @if($products->hasPages())
            <div class="mt-8 flex justify-center">
                {{ $products->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
