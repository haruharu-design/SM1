@extends('layouts.app')

@section('title', 'Home - Todana')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <img src="{{ asset('images/todana/banner.png') }}" class="img-fluid rounded shadow" alt="Banner">
        </div>
    </div>

    <div class="text-center mb-5">
        <h2>Our Collections</h2>
        <p class="text-muted">Temukan produk terbaik untuk kebutuhan Anda</p>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <img src="{{ asset('images/todana/buku1.jpg') }}" class="card-img-top" alt="Product">
                <div class="card-body">
                    <h5 class="card-title">Product 1</h5>
                    <p class="card-text">Deskripsi produk singkat</p>
                    <a href="{{ route('products.show', 1) }}" class="btn btn-primary">Lihat Detail</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm">
                <img src="{{ asset('images/todana/buku2.jpg') }}" class="card-img-top" alt="Product">
                <div class="card-body">
                    <h5 class="card-title">Product 2</h5>
                    <p class="card-text">Deskripsi produk singkat</p>
                    <a href="{{ route('products.show', 2) }}" class="btn btn-primary">Lihat Detail</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm">
                <img src="{{ asset('images/todana/buku3.jpg') }}" class="card-img-top" alt="Product">
                <div class="card-body">
                    <h5 class="card-title">Product 3</h5>
                    <p class="card-text">Deskripsi produk singkat</p>
                    <a href="{{ route('products.show', 3) }}" class="btn btn-primary">Lihat Detail</a>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center">
        <a href="{{ route('products.index') }}" class="btn btn-outline-primary">Lihat Semua Produk</a>
    </div>
</div>
@endsection

