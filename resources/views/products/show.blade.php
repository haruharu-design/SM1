@extends('layouts.app')

@section('title', 'Product Detail - Todana')

@section('content')
<div class="container">
    <a href="{{ route('products.index') }}" class="btn btn-secondary mb-3">← Kembali</a>

    <div class="row">
        <div class="col-md-6">
            <img src="{{ asset('images/todana/buku' . ($id % 6 == 0 ? 6 : $id % 6) . '.jpg') }}" class="img-fluid rounded shadow" alt="Product">
        </div>
        <div class="col-md-6">
            <h1>Product {{ $id }}</h1>
            <p class="text-muted">Kategori: Buku</p>
            <h3 class="text-danger mb-4">Rp {{ number_format(50000 + ($id * 1000), 0, ',', '.') }}</h3>
            
            <div class="mb-4">
                <h4>Deskripsi</h4>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.</p>
            </div>

            <div class="mb-4">
                <label for="quantity" class="form-label">Jumlah</label>
                <input type="number" class="form-control" id="quantity" value="1" min="1" style="width: 100px;">
            </div>

            <button class="btn btn-primary btn-lg">Beli Sekarang</button>
            <button class="btn btn-outline-secondary btn-lg">Tambah ke Wishlist</button>
        </div>
    </div>
</div>
@endsection

