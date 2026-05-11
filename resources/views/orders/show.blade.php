@extends('layouts.app')

@section('title', 'Detail Pesanan - SM')

@section('content')
<div class="max-w-4xl mx-auto bg-gradient-to-br from-red-500/10 to-blue-500/10 rounded-2xl p-6">
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">{{ session('success') }}</div>
    @endif

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">{{ $order->order_number }}</h1>
        <span class="px-4 py-2 rounded-full text-sm
            @if($order->status === 'menunggu_pembayaran') bg-yellow-100 text-yellow-800
            @elseif($order->status === 'diproses') bg-blue-100 text-blue-800
            @elseif($order->status === 'dikirim') bg-purple-100 text-purple-800
            @elseif($order->status === 'selesai') bg-green-100 text-green-800
            @else bg-red-100 text-red-800
            @endif">
            {{ \App\Models\Order::statusOptions()[$order->status] ?? $order->status }}
        </span>
    </div>

    <div class="bg-white/80 rounded-xl shadow-lg p-6 mb-6">
        <h2 class="font-bold mb-2">Alamat Pengiriman</h2>
        <p>{{ $order->shipping_address }}</p>
        <p class="text-gray-600">{{ $order->shipping_phone }}</p>
    </div>

    <div class="bg-white/80 rounded-xl shadow-lg p-6 mb-6">
        <h2 class="font-bold mb-4">Detail Produk</h2>
        <div class="space-y-3">
            @foreach($order->items as $item)
            @php
                $listUnit = $item->list_unit_price ?? $item->unit_price;
                $hadItemDiscount = $item->list_unit_price !== null && (float) $item->list_unit_price > (float) $item->unit_price;
            @endphp
            <div class="flex justify-between border-b pb-2 gap-4">
                <div>
                    <span>{{ $item->product->name }} × {{ $item->quantity }}</span>
                    @if($hadItemDiscount)
                        <p class="text-xs text-gray-500 mt-0.5">Harga katalog Rp {{ number_format((float) $listUnit, 0, ',', '.') }} / unit</p>
                    @endif
                </div>
                <span class="shrink-0">Rp {{ number_format($item->total_price, 0, ',', '.') }}</span>
            </div>
            @endforeach
        </div>
        <div class="mt-4 pt-4 border-t space-y-1">
            <div class="flex justify-between">
                <span>Subtotal barang @if($order->productDiscountSaved() > 0)<span class="text-xs font-normal text-gray-500">(setelah diskon per produk)</span>@endif</span>
                <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
            </div>
            @if($order->shipping_cost)
            <div class="flex justify-between">
                <span>Ongkir {{ $order->distance_km ? '(' . $order->distance_km . ' km)' : '(estimasi)' }}</span>
                <span>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
            </div>
            @endif
            <div class="flex justify-between font-bold text-lg">
                <span>Total</span>
                <span>Rp {{ number_format($order->total, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    @php $payment = $order->payments->first(); @endphp
    @if($payment)
    <div class="bg-white/80 rounded-xl shadow-lg p-6 mb-6">
        <h2 class="font-bold mb-2">Metode Pembayaran</h2>
        <p>
            @if($payment->method === 'cod')
                Cash On Delivery (COD) — Bayar saat barang diterima
            @else
                Transfer Bank
                @if($payment->bankAccount)
                    — {{ $payment->bankAccount->name }} {{ $payment->bankAccount->account_number }} a.n. {{ $payment->bankAccount->account_name }}
                @endif
            @endif
        </p>
        <p class="text-sm text-gray-600 mt-1">Status: {{ \App\Models\Payment::statusOptions()[$payment->status] ?? $payment->status }}</p>
    </div>
    @endif

    @if(in_array($order->status, ['menunggu_pembayaran']) && $payment && $payment->status === 'awaiting_confirmation')
    <p class="text-gray-600 text-sm">Silakan lakukan transfer ke rekening di atas. Setelah transfer, admin akan mengonfirmasi pembayaran Anda.</p>
    @endif
    @if($order->status === 'menunggu_pembayaran' && $payment && $payment->method === 'cod')
    <p class="text-gray-600 text-sm">Pembayaran dilakukan saat barang diterima (COD).</p>
    @endif

    <a href="{{ route('orders.index') }}" class="inline-block mt-4 text-blue-600 hover:underline">← Kembali ke Daftar Pesanan</a>
</div>
@endsection
