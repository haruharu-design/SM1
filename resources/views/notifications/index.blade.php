@extends('layouts.app')

@section('title', 'Notifikasi')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Notifikasi</h1>
            @if(auth()->user()->unreadNotifications->isNotEmpty())
                <form action="{{ route('notifications.read-all') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-sm font-medium text-blue-600 hover:text-blue-800">
                        Tandai semua sudah dibaca
                    </button>
                </form>
            @endif
        </div>

        @if(session('success'))
            <p class="mb-4 text-sm text-green-700 bg-green-50 border border-green-200 rounded-lg px-4 py-3">{{ session('success') }}</p>
        @endif

        @if($notifications->isEmpty())
            <p class="text-gray-600 bg-white rounded-lg border border-gray-200 p-8 text-center">Belum ada notifikasi.</p>
        @else
            <ul class="space-y-3">
                @foreach($notifications as $notification)
                    @php
                        $data = $notification->data;
                        $orderId = $data['order_id'] ?? null;
                        $isUnread = $notification->read_at === null;
                    @endphp
                    <li class="rounded-lg border {{ $isUnread ? 'border-blue-200 bg-blue-50/50' : 'border-gray-200 bg-white' }} p-4 shadow-sm">
                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-2">
                            <div class="flex-1 min-w-0">
                                @if($isUnread)
                                    <span class="inline-block mb-1 text-xs font-semibold uppercase tracking-wide text-blue-600">Baru</span>
                                @endif
                                <p class="font-semibold text-gray-900">{{ $data['title'] ?? 'Pemberitahuan' }}</p>
                                <p class="mt-1 text-sm text-gray-700">{{ $data['body'] ?? '' }}</p>
                                <p class="mt-2 text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</p>
                            </div>
                            <div class="flex flex-shrink-0 items-center gap-2">
                                @if($orderId)
                                    <a href="{{ route('orders.show', $orderId) }}"
                                       class="text-sm font-medium text-blue-600 hover:text-blue-800 whitespace-nowrap">
                                        Lihat pesanan
                                    </a>
                                @endif
                                @if($isUnread)
                                    <form action="{{ route('notifications.read', $notification->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-sm text-gray-600 hover:text-gray-900 whitespace-nowrap">
                                            Sudah dibaca
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>

            <div class="mt-6">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>
@endsection
