@extends('layouts.app')

@section('title', $product->name . ' - SM')

@section('content')

<!-- Container utama -->
<div class="max-w-7xl mx-auto
    bg-gradient-to-br from-red-500/10 to-blue-500/10
    rounded-2xl p-6">

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">{{ session('error') }}</div>
    @endif

    <!-- Tombol kembali -->
    <a href="{{ route('products.index') }}" 
       class="inline-block mb-6 text-gray-600 hover:text-gray-900 hover:underline">
        ← Kembali ke Produk
    </a>

    <!-- Grid detail -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

        <!-- Gambar produk (dengan wishlist icon) -->
        <div class="relative">
            @auth
            <form action="{{ route('wishlist.toggle') }}" method="POST" class="absolute top-2 right-2 z-10">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <button type="submit" class="p-2 rounded-full bg-white/90 shadow hover:bg-white" title="{{ $isInWishlist ? 'Hapus dari wishlist' : 'Tambah ke wishlist' }}">
                    <span class="text-2xl">{{ $isInWishlist ? '❤️' : '🤍' }}</span>
                </button>
            </form>
            @endauth
            <div class="w-full h-96 rounded-xl overflow-hidden bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" 
                     alt="{{ $product->name }}"
                     class="w-full h-full object-cover">
            @else
                <span class="text-gray-500 italic">Gambar produk</span>
            @endif
            </div>
        </div>

        <!-- Informasi produk -->
        <div class="bg-white/80 backdrop-blur-sm
                    border border-gray-200
                    rounded-xl shadow-lg p-6">

            <h1 class="text-3xl font-bold mb-2 text-gray-900">
                {{ $product->name }}
            </h1>

            @if($product->category)
            <p class="text-gray-500 mb-4">
                <span class="inline-block px-3 py-1 rounded-full bg-gray-200 text-gray-700">{{ $product->category->name }}</span>
            </p>
            @endif

            <div class="mb-6">
                <x-product-price :product="$product" class="text-2xl" />
            </div>

            <div class="mb-6">
                <h4 class="text-xl font-bold mb-2 text-gray-700">
                    Deskripsi
                </h4>
                <p class="text-gray-600">
                    {{ $product->description ?: 'Tidak ada deskripsi' }}
                </p>
                <p class="mt-3 text-sm font-medium {{ (int) $product->stock > 0 ? 'text-emerald-700' : 'text-red-600' }}">
                    Stok:
                    @if((int) $product->stock > 0)
                        {{ (int) $product->stock }} tersedia
                    @else
                        Habis
                    @endif
                </p>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold mb-2 text-gray-600">Jumlah</label>
                <input type="number" min="1" max="{{ max(1, (int) ($product->stock ?? 0)) }}"
                       class="w-24 px-4 py-2 border border-gray-300 rounded disabled:bg-gray-100 disabled:text-gray-500"
                       value="1" id="qty" name="quantity" {{ (int) $product->stock <= 0 ? 'disabled' : '' }}>
            </div>

            @auth
            <div class="flex gap-4 flex-wrap">
                {{-- Beli Langsung: langsung ke checkout dengan 1 produk --}}
                <form action="{{ route('checkout.show') }}" method="GET" class="inline" id="form-beli-langsung">
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="quantity" id="qty-beli-langsung" value="1">
                    <button type="submit" class="bg-gradient-to-r from-red-500 to-blue-500 text-white px-6 py-3 rounded-lg hover:opacity-90 font-bold disabled:opacity-50 disabled:cursor-not-allowed" {{ (int) $product->stock <= 0 ? 'disabled' : '' }}>
                        Beli Langsung
                    </button>
                </form>
                {{-- Tambah ke Keranjang --}}
                <form action="{{ route('cart.add') }}" method="POST" class="inline" id="form-keranjang">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="quantity" id="qty-keranjang" value="1">
                    <button type="submit" class="border-2 border-gray-800 text-gray-800 px-6 py-3 rounded-lg hover:bg-gray-100 font-bold disabled:opacity-50 disabled:cursor-not-allowed" {{ (int) $product->stock <= 0 ? 'disabled' : '' }}>
                        Tambah ke Keranjang
                    </button>
                </form>
            </div>
            @if((int) $product->stock <= 0)
            <p class="mt-3 text-sm text-red-600">Produk sedang habis, jadi belum bisa dibeli.</p>
            @endif
            <script>
                function syncQty() {
                    var qtyInput = document.getElementById('qty');
                    if (!qtyInput) return;
                    var maxStock = parseInt(qtyInput.getAttribute('max')) || 1;
                    var v = Math.max(1, Math.min(maxStock, parseInt(qtyInput.value) || 1));
                    qtyInput.value = v;
                    document.getElementById('qty-beli-langsung').value = v;
                    document.getElementById('qty-keranjang').value = v;
                }
                document.getElementById('qty')?.addEventListener('change', syncQty);
                document.getElementById('form-beli-langsung')?.addEventListener('submit', syncQty);
                document.getElementById('form-keranjang')?.addEventListener('submit', syncQty);
            </script>
            @else
            <p class="text-gray-600 mb-2">Login untuk membeli produk.</p>
            <a href="{{ route('login') }}" class="inline-block bg-gradient-to-r from-red-500 to-blue-500 text-white px-6 py-3 rounded-lg hover:opacity-90 font-bold">Login</a>
            @endauth

        </div>
    </div>

    {{-- Q&A (Tanya Jawab) --}}
    <div class="mt-10 bg-white/80 rounded-xl shadow-lg p-6">
        <h2 class="text-xl font-bold mb-4">Tanya Jawab</h2>
        @foreach($product->productQuestions as $qa)
        <div class="border-b border-gray-200 py-4">
            <p class="font-medium text-gray-800">Q: {{ $qa->question }}</p>
            <p class="text-sm text-gray-500">— {{ $qa->user->name }}</p>
            <p class="mt-2 text-gray-700 pl-4 border-l-2 border-blue-200">A: {{ $qa->answer }}</p>
            @if($qa->answeredByUser)
            <p class="text-xs text-gray-500 mt-1">— Admin</p>
            @endif
        </div>
        @endforeach
        @auth
        <form action="{{ route('product-questions.store') }}" method="POST" class="mt-4">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="text" name="question" required placeholder="Ajukan pertanyaan tentang produk ini..."
                class="w-full px-4 py-2 border rounded mb-2" maxlength="500">
            <button type="submit" class="text-blue-600 hover:underline text-sm">Kirim Pertanyaan</button>
        </form>
        @else
        <p class="mt-4 text-gray-500 text-sm">Login untuk mengajukan pertanyaan.</p>
        @endauth
    </div>

    {{-- Ulasan & Rating --}}
    <div class="mt-10 bg-white/80 rounded-xl shadow-lg p-6">
        <h2 class="text-xl font-bold mb-4">Ulasan</h2>
        @php
            $avgRating = $product->reviews->avg('rating');
            $reviewCount = $product->reviews->count();
        @endphp
        @if($reviewCount > 0)
        <p class="text-gray-600 mb-4">
            ⭐ {{ number_format($avgRating, 1) }} ({{ $reviewCount }} ulasan)
        </p>
        @endif
        @foreach($product->reviews as $review)
        <div class="border-b border-gray-200 py-4">
            <div class="flex items-center gap-2 mb-1">
                <span class="text-yellow-500">{{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}</span>
                <span class="font-medium">{{ $review->user->name }}</span>
            </div>
            @if($review->comment)
            <p class="text-gray-700">{{ $review->comment }}</p>
            @endif
        </div>
        @endforeach
        @auth
        @if($hasPurchased && !$hasReviewed)
        <form action="{{ route('reviews.store') }}" method="POST" class="mt-4 p-4 bg-gray-50 rounded-lg">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <label class="block font-medium mb-2">Beri Rating (1-5 bintang)</label>
            <select name="rating" required class="px-3 py-2 border rounded mb-2">
                <option value="5">★★★★★</option>
                <option value="4">★★★★☆</option>
                <option value="3">★★★☆☆</option>
                <option value="2">★★☆☆☆</option>
                <option value="1">★☆☆☆☆</option>
            </select>
            <textarea name="comment" placeholder="Tulis ulasan (opsional)..." class="w-full px-4 py-2 border rounded mb-2" rows="2" maxlength="1000"></textarea>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">Kirim Ulasan</button>
        </form>
        @elseif(!$hasPurchased)
        <p class="mt-4 text-gray-500 text-sm">Beli produk ini terlebih dahulu untuk memberikan ulasan.</p>
        @endif
        @else
        <p class="mt-4 text-gray-500 text-sm">Login untuk memberikan ulasan.</p>
        @endauth
    </div>

    {{-- Produk Terkait (berdasarkan kategori yang sama) --}}
    @if($relatedProducts->isNotEmpty())
    <div class="mt-10 bg-white/80 rounded-xl shadow-lg p-6">
        <h2 class="text-xl font-bold mb-4">Produk Terkait</h2>
        <p class="text-gray-600 text-sm mb-4">Produk lain dalam kategori {{ $product->category?->name ?? 'yang sama' }}</p>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach($relatedProducts as $rel)
            <a href="{{ route('products.show', $rel->id) }}" class="block border border-gray-200 rounded-lg p-3 hover:shadow-md transition-shadow">
                <div class="aspect-square rounded bg-gray-100 mb-2 overflow-hidden flex items-center justify-center">
                    @if($rel->image)
                        <img src="{{ asset('storage/' . $rel->image) }}" alt="{{ $rel->name }}" class="w-full h-full object-cover">
                    @else
                        <span class="text-gray-400 text-xs">Foto</span>
                    @endif
                </div>
                <p class="text-sm font-medium truncate">{{ $rel->name }}</p>
                <p class="text-sm font-bold text-gray-800">Rp {{ number_format($rel->sellingUnitPrice(), 0, ',', '.') }}</p>
            </a>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Rekomendasi Personalisasi --}}
    @if(isset($personalizedRecommendations) && $personalizedRecommendations->isNotEmpty())
    <div class="mt-10 bg-white/80 rounded-xl shadow-lg p-6">
        <h2 class="text-xl font-bold mb-4">Rekomendasi untuk Anda</h2>
        <p class="text-gray-600 text-sm mb-4">Berdasarkan perilaku belanja dan minat Anda</p>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach($personalizedRecommendations as $rec)
            <a href="{{ route('products.show', $rec->id) }}" class="block border border-gray-200 rounded-lg p-3 hover:shadow-md transition-shadow">
                <div class="aspect-square rounded bg-gray-100 mb-2 overflow-hidden flex items-center justify-center">
                    @if($rec->image)
                        <img src="{{ asset('storage/' . $rec->image) }}" alt="{{ $rec->name }}" class="w-full h-full object-cover">
                    @else
                        <span class="text-gray-400 text-xs">Foto</span>
                    @endif
                </div>
                <p class="text-sm font-medium truncate">{{ $rec->name }}</p>
                <p class="text-sm font-bold text-gray-800">Rp {{ number_format($rec->sellingUnitPrice(), 0, ',', '.') }}</p>
            </a>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
