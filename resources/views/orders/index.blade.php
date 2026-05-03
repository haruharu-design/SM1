@extends('layouts.app')

@section('title', 'Pesanan Saya - SM')

@section('content')
<div class="max-w-4xl mx-auto bg-gradient-to-br from-red-500/10 to-blue-500/10 rounded-2xl p-6">
    <h1 class="text-3xl font-bold mb-6 text-gray-900">Pesanan Saya</h1>

    @if($orders->isEmpty())
        <p class="text-gray-600">Belum ada pesanan.</p>
    @else
        <div class="space-y-4">
            @foreach($orders as $order)
            <a href="{{ route('orders.show', $order) }}" class="block bg-white/80 rounded-xl shadow p-4 hover:shadow-lg transition">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="font-bold">{{ $order->order_number }}</p>
                        <p class="text-sm text-gray-600">{{ $order->created_at->format('d M Y H:i') }}</p>
                        <p class="text-sm">Total: Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-sm
                        @if($order->status === 'menunggu_pembayaran') bg-yellow-100 text-yellow-800
                        @elseif($order->status === 'diproses') bg-blue-100 text-blue-800
                        @elseif($order->status === 'dikirim') bg-purple-100 text-purple-800
                        @elseif($order->status === 'selesai') bg-green-100 text-green-800
                        @else bg-red-100 text-red-800
                        @endif">
                        {{ \App\Models\Order::statusOptions()[$order->status] ?? $order->status }}
                    </span>
                </div>
            </a>
            @endforeach
        </div>
        <div class="mt-6">{{ $orders->links() }}</div>
    @endif
</div>
@endsection
