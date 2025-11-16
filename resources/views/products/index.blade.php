@extends('layouts.app')

@section('title', 'Products - Todana')

@section('content')
<div class="container">
    <h1 class="mb-4">Daftar Produk</h1>

    <div class="row g-4">
        @for($i = 1; $i <= 6; $i++)
        <div class="col-md-4">
            <div class="card shadow-sm">
                <img src="{{ asset('images/todana/buku' . $i . '.jpg') }}" class="card-img-top" alt="Product {{ $i }}">
                <div class="card-body">
                    <h5 class="card-title">Product {{ $i }}</h5>
                    <p class="card-text">Deskripsi produk singkat untuk produk {{ $i }}</p>
                    <p class="text-danger fw-bold">Rp {{ number_format(50000 + ($i * 1000), 0, ',', '.') }}</p>
                    <a href="{{ route('products.show', $i) }}" class="btn btn-primary">Lihat Detail</a>
                </div>
            </div>
        </div>
        @endfor
    </div>
</div>
@endsection

