@extends('layouts.app')

@section('title', 'Home - Todana')

@section('content')
<!-- Hero Section dengan gradient background - full width -->
<div class="relative overflow-hidden bg-gradient-to-br from-blue-600 via-purple-600 to-indigo-700 -mx-4 -mt-8 mb-0">
    <div class="absolute inset-0 bg-black opacity-10"></div>
    <div class="relative max-w-7xl mx-auto px-4 py-16 md:py-24">
        <div class="text-center text-white">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold mb-4 animate-fade-in">
                Selamat Datang di <span class="text-yellow-300">Todana</span>
            </h1>
            <p class="text-lg md:text-xl text-blue-100 mb-8 max-w-2xl mx-auto animate-slide-up">
                Temukan koleksi produk terbaik dengan kualitas premium untuk kebutuhan Anda
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center animate-slide-up-delay">
                <a href="{{ route('products.index') }}" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-blue-50 transform hover:scale-105 transition-all duration-300 shadow-lg">
                    Jelajahi Produk
                </a>
                <a href="{{ route('about') }}" class="bg-transparent border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transform hover:scale-105 transition-all duration-300">
                    Tentang Kami
                </a>
            </div>
        </div>
    </div>
    <!-- Wave decoration -->
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0,64L48,69.3C96,75,192,85,288,80C384,75,480,53,576,48C672,43,768,53,864,58.7C960,64,1056,64,1152,58.7C1248,53,1344,43,1392,37.3L1440,32L1440,120L1392,120C1344,120,1248,120,1152,120C1056,120,960,120,864,120C768,120,672,120,576,120C480,120,384,120,288,120C192,120,96,120,48,120L0,120Z" fill="rgb(249, 250, 251)"/>
        </svg>
    </div>
</div>

<!-- Container utama -->
<div class="max-w-7xl mx-auto px-4">
    <!-- Banner Section dengan efek modern -->
    <div class="mb-12 mt-8 relative group">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl blur opacity-25 group-hover:opacity-40 transition-opacity duration-300"></div>
        <div class="relative rounded-2xl overflow-hidden shadow-2xl">
            <img src="{{ asset('images/todana/banner.png') }}" class="w-full h-auto rounded-2xl transform group-hover:scale-105 transition-transform duration-500" alt="Banner">
        </div>
    </div>

    <!-- Judul section dengan dekorasi -->
    <div class="text-center mb-12 relative">
        <div class="inline-block">
            <h2 class="text-4xl md:text-5xl font-bold mb-4 bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                Our Collections
            </h2>
            <div class="mx-auto w-24 h-1 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full mb-4"></div>
            <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                Temukan produk terbaik dengan kualitas premium untuk kebutuhan Anda
            </p>
        </div>
    </div>

    @php
        $products = [
            ['id'=>1,'title'=>'Product 1','image'=>'images/todana/buku1.jpg','desc'=>'Deskripsi produk singkat'],
            ['id'=>2,'title'=>'Product 2','image'=>'images/todana/buku2.jpg','desc'=>'Deskripsi produk singkat'],
            ['id'=>3,'title'=>'Product 3','image'=>'images/todana/buku3.jpg','desc'=>'Deskripsi produk singkat'],
            ['id'=>4,'title'=>'Product 4','image'=>'images/todana/buku1.jpg','desc'=>'Deskripsi produk singkat'],
            ['id'=>5,'title'=>'Product 5','image'=>'images/todana/buku2.jpg','desc'=>'Deskripsi produk singkat'],
            ['id'=>6,'title'=>'Product 6','image'=>'images/todana/buku3.jpg','desc'=>'Deskripsi produk singkat'],
        ];
    @endphp

    <!-- Grid produk dengan desain card modern -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 md:gap-8 mb-12">
        @foreach($products as $index => $product)
            <!-- Modal toggle (checkbox) placed before the card so checkbox sibling selector can target the overlay -->
            <input type="checkbox" id="modal-{{ $product['id'] }}" class="hidden">

            <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 group relative overflow-hidden border border-gray-100">
                <!-- Gradient overlay on hover -->
                <div class="absolute inset-0 bg-gradient-to-br from-blue-500/0 to-purple-500/0 group-hover:from-blue-500/5 group-hover:to-purple-500/5 transition-all duration-300 pointer-events-none"></div>
                
                <!-- Favorite toggle dengan animasi -->
                <input type="checkbox" id="fav-{{ $product['id'] }}" class="hidden">
                <label for="fav-{{ $product['id'] }}" class="absolute top-4 right-4 cursor-pointer z-10 transition-all duration-300" aria-hidden>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-300 hover:text-red-500 transition-colors duration-200" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                    </svg>
                </label>
                <style>
                    #fav-{{ $product['id'] }}:checked + label svg {
                        fill: #ef4444;
                        color: #ef4444;
                    }
                </style>

                <!-- Image container dengan overlay effect -->
                <label for="modal-{{ $product['id'] }}" class="block cursor-pointer relative overflow-hidden rounded-t-2xl bg-gray-100">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10"></div>
                    <img src="{{ asset($product['image']) }}" class="w-full h-64 object-cover transform transition-all duration-500 group-hover:scale-110" alt="{{ $product['title'] }}">
                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-20">
                        <span class="bg-white/90 text-blue-600 px-4 py-2 rounded-full font-semibold text-sm">Lihat Detail</span>
                    </div>
                </label>

                <!-- Content area -->
                <div class="p-5 relative z-10">
                    <h5 class="text-xl font-bold mb-2 text-gray-800 group-hover:text-blue-600 transition-colors duration-300">
                        {{ $product['title'] }}
                    </h5>
                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                        {{ $product['desc'] }}
                    </p>

                    <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                        <a href="{{ route('products.show', $product['id']) }}" class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-5 py-2.5 rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all duration-300 font-medium text-sm shadow-md hover:shadow-lg transform hover:scale-105">
                            Detail
                        </a>
                        <span class="text-xs text-gray-400 font-medium">#{{ $product['id'] }}</span>
                    </div>
                </div>
            </div>

            <!-- Modal overlay dengan animasi fade -->
            <style>
                #modal-{{ $product['id'] }}:checked ~ .modal-overlay-{{ $product['id'] }} { 
                    display: flex; 
                    animation: fadeIn 0.3s ease;
                }
                #modal-{{ $product['id'] }}:checked ~ .modal-overlay-{{ $product['id'] }} .modal-content-{{ $product['id'] }} { 
                    animation: slideUp 0.3s ease;
                }
                @keyframes fadeIn {
                    from { opacity: 0; }
                    to { opacity: 1; }
                }
                @keyframes slideUp {
                    from { transform: translateY(20px); opacity: 0; }
                    to { transform: translateY(0); opacity: 1; }
                }
            </style>
            <div class="modal-overlay-{{ $product['id'] }} fixed inset-0 z-50 hidden items-center justify-center bg-black/60 backdrop-blur-sm p-4">
                <div class="modal-content-{{ $product['id'] }} bg-white rounded-2xl max-w-3xl w-full shadow-2xl relative overflow-hidden">
                    <label for="modal-{{ $product['id'] }}" class="absolute top-4 right-4 cursor-pointer z-20 bg-white/90 hover:bg-white rounded-full p-2 shadow-lg transition-all duration-300 hover:scale-110">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </label>
                    <div class="flex flex-col md:flex-row">
                        <div class="md:w-1/2 bg-gray-100">
                            <img src="{{ asset($product['image']) }}" class="w-full h-64 md:h-full object-cover" alt="{{ $product['title'] }}">
                        </div>
                        <div class="md:w-1/2 p-6 md:p-8">
                            <h3 class="text-3xl font-bold mb-3 text-gray-800">{{ $product['title'] }}</h3>
                            <p class="text-gray-600 mb-6 leading-relaxed">{{ $product['desc'] }}</p>
                            <a href="{{ route('products.show', $product['id']) }}" class="inline-block bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-3 rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all duration-300 font-semibold shadow-lg hover:shadow-xl transform hover:scale-105">
                                Lihat Detail Lengkap
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Tombol lihat semua dengan style modern -->
    <div class="text-center mb-12">
        <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white px-8 py-4 rounded-xl hover:from-blue-700 hover:to-purple-700 transition-all duration-300 font-semibold text-lg shadow-xl hover:shadow-2xl transform hover:scale-105">
            <span>Lihat Semua Produk</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
            </svg>
        </a>
    </div>
</div>

<!-- Custom CSS untuk animasi -->
<style>
    @keyframes fade-in {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slide-up {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in {
        animation: fade-in 0.8s ease-out;
    }

    .animate-slide-up {
        animation: slide-up 0.8s ease-out;
    }

    .animate-slide-up-delay {
        animation: slide-up 1s ease-out;
    }

    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection