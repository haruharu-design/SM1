@extends('layouts.app')

@section('title', 'About - Todana')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 mb-4">
            <h1 class="mb-4">Tentang Kami</h1>
            <div class="d-flex align-items-center mb-4">
                <img src="{{ asset('images/todana/about-us.png') }}" class="me-4" style="width: 150px; height: auto;" alt="About Us">
                <div>
                    <p class="lead">Selamat datang di Todana - Toko Online Sederhana</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                    <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-12 bg-light p-4 rounded">
            <h3>Visi & Misi</h3>
            <h4 class="mt-3">Visi</h4>
            <p>Menjadi toko online terpercaya dan terdepan dalam memberikan pengalaman berbelanja yang mudah dan nyaman.</p>
            <h4 class="mt-3">Misi</h4>
            <ul>
                <li>Menyediakan produk berkualitas dengan harga terjangkau</li>
                <li>Memberikan pelayanan terbaik untuk kepuasan customer</li>
                <li>Mengembangkan teknologi untuk kemudahan transaksi</li>
            </ul>
        </div>
    </div>
</div>
@endsection

