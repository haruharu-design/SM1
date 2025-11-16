@extends('layouts.app')

@section('title', 'About - Todana')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-8">
        <h1 class="text-4xl font-bold mb-6">Tentang Kami</h1>
        <div class="flex flex-col md:flex-row items-start gap-6 mb-8">
            <img src="{{ asset('images/todana/about-us.png') }}" class="w-40 h-auto flex-shrink-0" alt="About Us">
            <div>
                <p class="text-xl font-semibold mb-4">Selamat datang di Todana - Toko Online Sederhana</p>
                <p class="text-gray-700 mb-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                <p class="text-gray-700">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            </div>
        </div>
    </div>

    <div class="mt-10 bg-gray-100 p-6 rounded-lg">
        <h3 class="text-2xl font-bold mb-4">Visi & Misi</h3>
        <h4 class="text-xl font-semibold mt-4 mb-2">Visi</h4>
        <p class="text-gray-700 mb-4">Menjadi toko online terpercaya dan terdepan dalam memberikan pengalaman berbelanja yang mudah dan nyaman.</p>
        <h4 class="text-xl font-semibold mt-4 mb-2">Misi</h4>
        <ul class="list-disc list-inside text-gray-700 space-y-2">
            <li>Menyediakan produk berkualitas dengan harga terjangkau</li>
            <li>Memberikan pelayanan terbaik untuk kepuasan customer</li>
            <li>Mengembangkan teknologi untuk kemudahan transaksi</li>
        </ul>
    </div>
</div>
@endsection
