@extends('layouts.app')

@section('title', 'Checkout - SM')

@section('content')
<div class="max-w-4xl mx-auto bg-gradient-to-br from-red-500/10 to-blue-500/10 rounded-2xl p-6">
    <h1 class="text-3xl font-bold mb-6 text-gray-900">Checkout</h1>

    @if(session('error'))
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">{{ session('error') }}</div>
    @endif

    <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form">
        @csrf

        @if($isDirectBuy)
            <input type="hidden" name="product_id" value="{{ $items[0]['product']->id }}">
            <input type="hidden" name="quantity" value="{{ $items[0]['quantity'] }}">
        @endif

        {{-- Alamat Pengiriman --}}
        <div class="bg-white/80 rounded-xl shadow-lg p-6 mb-6">
            <h2 class="text-xl font-bold mb-4">Alamat Pengiriman</h2>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap *</label>
                    <textarea name="shipping_address" id="shipping_address" rows="3" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2"
                        placeholder="Contoh: Jl. Sudirman No. 123, Pontianak">{{ old('shipping_address') }}</textarea>
                    @error('shipping_address')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">No. Telepon *</label>
                    <input type="text" name="shipping_phone" id="shipping_phone" required
                        value="{{ old('shipping_phone') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2"
                        placeholder="08xxxxxxxxxx">
                    @error('shipping_phone')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <button type="button" id="btn-calc-shipping" class="text-blue-600 hover:underline text-sm">
                        Hitung Biaya Pengiriman →
                    </button>
                </div>
            </div>
        </div>

        {{-- Ringkasan Pesanan --}}
        <div class="bg-white/80 rounded-xl shadow-lg p-6 mb-6">
            <h2 class="text-xl font-bold mb-4">Ringkasan Pesanan</h2>
            <div class="space-y-3">
                @foreach($items as $item)
                <div class="flex justify-between border-b pb-2">
                    <span>{{ $item['product']->name }} × {{ $item['quantity'] }}</span>
                    <span>Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</span>
                </div>
                @endforeach
            </div>
            <div class="mt-4 pt-4 border-t space-y-2">
                <div class="flex justify-between">
                    <span>Subtotal Produk</span>
                    <span id="subtotal-display">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Biaya Pengiriman</span>
                    <span id="shipping-display" class="text-gray-500">Masukkan alamat lalu klik "Hitung Biaya Pengiriman"</span>
                </div>
                <div class="flex justify-between text-xl font-bold pt-2">
                    <span>Total Pembayaran</span>
                    <span id="total-display">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <input type="hidden" name="shipping_cost_calculated" id="shipping_cost_calculated" value="0">
        <div id="shipping-error" class="hidden mb-4 p-4 bg-red-100 text-red-700 rounded-lg"></div>

        {{-- Metode Pembayaran --}}
        <div class="bg-white/80 rounded-xl shadow-lg p-6 mb-6">
            <h2 class="text-xl font-bold mb-4">Metode Pembayaran</h2>
            <div class="space-y-4">
                <label class="flex items-start gap-3 p-4 border rounded-lg cursor-pointer hover:bg-gray-50 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50">
                    <input type="radio" name="payment_method" value="cod" {{ old('payment_method', 'cod') === 'cod' ? 'checked' : '' }} class="mt-1">
                    <div>
                        <span class="font-bold">Cash On Delivery (COD)</span>
                        <p class="text-sm text-gray-600">Bayar saat barang diterima</p>
                    </div>
                </label>
                <label class="flex items-start gap-3 p-4 border rounded-lg cursor-pointer hover:bg-gray-50 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50">
                    <input type="radio" name="payment_method" value="bank_transfer" {{ old('payment_method') === 'bank_transfer' ? 'checked' : '' }} class="mt-1">
                    <div>
                        <span class="font-bold">Transfer Bank</span>
                        <p class="text-sm text-gray-600">Transfer ke rekening toko, admin akan konfirmasi</p>
                    </div>
                </label>
            </div>
            <div id="bank-select" class="mt-4 hidden">
                <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Bank Tujuan</label>
                <select name="bank_id" class="w-full border rounded-lg px-4 py-2">
                    <option value="">-- Pilih Bank --</option>
                    @foreach($banks as $bank)
                    <option value="{{ $bank['id'] }}" {{ old('bank_id') === $bank['id'] ? 'selected' : '' }}>
                        {{ $bank['name'] }} - {{ $bank['account_number'] }} ({{ $bank['account_name'] }})
                    </option>
                    @endforeach
                </select>
                @if(count($banks) > 0)
                <div class="mt-2 p-3 bg-gray-50 rounded text-sm" id="bank-details">
                    @php $first = $banks[0]; @endphp
                    <p><strong>{{ $first['name'] }}</strong></p>
                    <p>No. Rek: {{ $first['account_number'] }}</p>
                    <p>a.n. {{ $first['account_name'] }}</p>
                </div>
                @endif
            </div>
        </div>

        <div class="flex justify-end gap-4">
            @if($isDirectBuy)
                <a href="{{ route('products.show', $items[0]['product']->id) }}" class="px-6 py-2 border rounded-lg text-gray-600 hover:bg-gray-100">Batal</a>
            @else
                <a href="{{ route('cart.index') }}" class="px-6 py-2 border rounded-lg text-gray-600 hover:bg-gray-100">← Kembali ke Keranjang</a>
            @endif
            <button type="submit" id="btn-submit" class="bg-gradient-to-r from-red-500 to-blue-500 text-white px-8 py-2 rounded-lg font-bold hover:opacity-90">
                Buat Pesanan
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const subtotal = {{ $subtotal }};
    let shippingCost = 0;

    let alreadyChecked = false;
    document.getElementById('btn-calc-shipping').addEventListener('click', function() {
        if (alreadyChecked) return;
        const address = document.getElementById('shipping_address').value.trim();
        if (!address) {
            alert('Masukkan alamat pengiriman terlebih dahulu.');
            return;
        }

        alreadyChecked = true;
        this.disabled = true;
        this.textContent = 'Menghitung...';

        fetch('{{ route("shipping.calculate") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
            body: JSON.stringify({ address: address })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                shippingCost = data.shipping_cost;
                document.getElementById('shipping-display').textContent = 'Rp ' + shippingCost.toLocaleString('id-ID');
                document.getElementById('shipping-display').classList.remove('text-gray-500');
                document.getElementById('shipping_cost_calculated').value = shippingCost;
                document.getElementById('total-display').textContent = 'Rp ' + (subtotal + shippingCost).toLocaleString('id-ID');
                document.getElementById('shipping-error').classList.add('hidden');
            } else {
                document.getElementById('shipping-display').textContent = data.message || 'Gagal menghitung';
                document.getElementById('shipping-display').classList.add('text-red-500');
                document.getElementById('shipping-error').textContent = data.message || 'Alamat tidak ditemukan.';
                document.getElementById('shipping-error').classList.remove('hidden');
            }
        })
        .catch(() => {
            document.getElementById('shipping-display').textContent = 'Error';
            document.getElementById('shipping-error').textContent = 'Gagal menghubungi server.';
            document.getElementById('shipping-error').classList.remove('hidden');
        })
        .finally(() => {
            this.textContent = 'Biaya telah dihitung';
        });
    });

    document.querySelectorAll('input[name="payment_method"]').forEach(function(radio) {
        radio.addEventListener('change', function() {
            var bankSelect = document.getElementById('bank-select');
            bankSelect.classList.toggle('hidden', this.value !== 'bank_transfer');
        });
    });
    document.querySelector('input[name="payment_method"]:checked')?.dispatchEvent(new Event('change'));

    document.getElementById('checkout-form').addEventListener('submit', function(e) {
        const addr = document.getElementById('shipping_address').value.trim();
        if (!addr) return;
        if (shippingCost === 0) {
            e.preventDefault();
            alert('Silakan klik "Hitung Biaya Pengiriman" terlebih dahulu untuk memastikan total pembayaran akurat.');
            return false;
        }
        var pm = document.querySelector('input[name="payment_method"]:checked')?.value;
        if (pm === 'bank_transfer' && !document.querySelector('select[name="bank_id"]')?.value) {
            e.preventDefault();
            alert('Pilih bank tujuan untuk transfer.');
            return false;
        }
    });
});
</script>
@endsection
