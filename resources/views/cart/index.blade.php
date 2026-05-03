@extends('layouts.app')

@section('title', 'Keranjang - SM')

@section('content')
<div class="max-w-7xl mx-auto bg-gradient-to-br from-red-500/10 to-blue-500/10 rounded-2xl p-6">
    <h1 class="text-3xl font-bold mb-6 text-gray-900">Keranjang Belanja</h1>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">{{ session('success') }}</div>
    @endif

    @if(empty($items))
        <div class="text-center py-12 text-gray-600">
            <p class="mb-4">Keranjang Anda kosong.</p>
            <a href="{{ route('products.index') }}" class="inline-block bg-gradient-to-r from-red-500 to-blue-500 text-white px-6 py-2 rounded-lg hover:opacity-90">Belanja Sekarang</a>
        </div>
    @else
        <div class="bg-white/80 rounded-xl shadow-lg overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-left">Produk</th>
                        <th class="px-4 py-3 text-left">Harga</th>
                        <th class="px-4 py-3 text-left">Jumlah</th>
                        <th class="px-4 py-3 text-left">Subtotal</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                    <tr class="border-t border-gray-200">
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-4">
                                @if($item['product']->image)
                                    <img src="{{ asset('storage/' . $item['product']->image) }}" alt="{{ $item['product']->name }}" class="w-16 h-16 object-cover rounded">
                                @else
                                    <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center text-gray-400 text-xs">No img</div>
                                @endif
                                <span class="font-medium">{{ $item['product']->name }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-4">Rp {{ number_format($item['product']->price, 0, ',', '.') }}</td>
                        <td class="px-4 py-4">
                            <form action="{{ route('cart.update') }}" method="POST" class="inline-flex items-center gap-2">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="product_id" value="{{ $item['product']->id }}">
                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="w-20 px-2 py-1 border rounded">
                                <button type="submit" class="text-sm text-blue-600 hover:underline">Update</button>
                            </form>
                        </td>
                        <td class="px-4 py-4 font-bold">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                        <td class="px-4 py-4">
                            <form action="{{ route('cart.remove', $item['product']->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus dari keranjang?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline text-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="px-4 py-4 bg-gray-50 border-t flex justify-between items-center">
                <a href="{{ route('products.index') }}" class="text-gray-600 hover:underline">Lanjut Belanja</a>
                <div class="flex items-center gap-6">
                    <span class="text-lg font-bold">Total: Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    <a href="{{ route('checkout.show') }}" class="bg-gradient-to-r from-red-500 to-blue-500 text-white px-6 py-2 rounded-lg hover:opacity-90 font-bold">Checkout</a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
