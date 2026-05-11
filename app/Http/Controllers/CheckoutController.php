<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\BankAccount;
use App\Services\CartService;
use App\Services\ShippingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function __construct(
        protected CartService $cart,
        protected ShippingService $shipping
    ) {}

    /**
     * Halaman checkout.
     * Bisa dari Beli Langsung (product_id + qty di query) atau dari Keranjang.
     */
    public function show(Request $request)
    {
        $items = [];
        $subtotal = 0;
        $isDirectBuy = false;

        if ($request->has('product_id')) {
            // Beli Langsung: 1 produk, qty dari param (default 1)
            $product = Product::where('is_active', true)->findOrFail($request->product_id);
            $qty = max(1, (int) $request->get('quantity', 1));
            $line = $product->sellingUnitPrice() * $qty;
            $items = [[
                'product' => $product,
                'quantity' => $qty,
                'subtotal' => $line,
            ]];
            $subtotal = $line;
            $isDirectBuy = true;
        } else {
            // Dari Keranjang
            $items = $this->cart->getItems();
            $subtotal = $this->cart->subtotal();

            if (empty($items)) {
                return redirect()->route('cart.index')
                    ->with('error', 'Keranjang kosong. Tambahkan produk terlebih dahulu.');
            }
        }

        $banks = BankAccount::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get(['code', 'name', 'account_number', 'account_name']);
        return view('checkout.show', compact('items', 'subtotal', 'isDirectBuy', 'banks'));
    }

    /**
     * Proses order (place order).
     */
    public function store(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string|max:500',
            'shipping_phone' => 'required|string|max:20',
            'payment_method' => 'required|in:cod,bank_transfer',
            'bank_id' => 'required_if:payment_method,bank_transfer|nullable|exists:bank_accounts,code',
            'product_id' => 'nullable|exists:products,id',
            'quantity' => 'nullable|integer|min:1',
        ]);

        $items = [];
        $subtotal = 0;

        if ($request->filled('product_id')) {
            // Beli Langsung
            $product = Product::where('is_active', true)->findOrFail($request->product_id);
            $qty = max(1, (int) $request->quantity);
            $line = $product->sellingUnitPrice() * $qty;
            $items = [[
                'product' => $product,
                'quantity' => $qty,
                'subtotal' => $line,
            ]];
            $subtotal = $line;
        } else {
            // Dari Keranjang
            $items = $this->cart->getItems();
            $subtotal = $this->cart->subtotal();

            if (empty($items)) {
                return redirect()->route('cart.index')
                    ->with('error', 'Keranjang kosong.');
            }
        }

        // Hitung ongkir
        $shippingResult = $this->shipping->calculateFromAddress($request->shipping_address);
        if (!$shippingResult['success']) {
            return back()
                ->withInput()
                ->with('error', $shippingResult['message'] ?? 'Gagal menghitung biaya pengiriman.');
        }

        $shippingCost = $shippingResult['shipping_cost'];
        $distanceKm = $shippingResult['distance_km'];

        $paymentMethod = $request->payment_method;
        $isCod = $paymentMethod === Payment::METHOD_COD;

        DB::beginTransaction();
        try {
            $total = round($subtotal + $shippingCost, 2);

            $orderInitialStatus = $isCod ? Order::STATUS_PROCESSING : Order::STATUS_WAITING_PAYMENT;

            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => Order::generateOrderNumber(),
                'subtotal' => $subtotal,
                'discount' => 0,
                'total' => $total,
                'status' => $orderInitialStatus,
                'shipping_address' => $request->shipping_address,
                'shipping_phone' => $request->shipping_phone,
                'distance_km' => $distanceKm,
                'shipping_cost' => $shippingCost,
                'shipping_lat' => $shippingResult['shipping_lat'] ?? null,
                'shipping_lng' => $shippingResult['shipping_lng'] ?? null,
            ]);

            foreach ($items as $item) {
                $p = $item['product'];
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $p->id,
                    'quantity' => $item['quantity'],
                    'list_unit_price' => $p->listUnitPrice(),
                    'unit_price' => $p->sellingUnitPrice(),
                    'total_price' => $item['subtotal'],
                ]);
            }

            $paymentStatus = $isCod ? Payment::STATUS_PENDING : Payment::STATUS_AWAITING_CONFIRMATION;

            Payment::create([
                'order_id' => $order->id,
                'amount' => $total,
                'method' => $paymentMethod,
                'bank_id' => $request->bank_id,
                'status' => $paymentStatus,
            ]);

            if (empty($request->product_id)) {
                $this->cart->clear();
            }

            DB::commit();

            $message = $isCod
                ? 'Pesanan berhasil dibuat. Pembayaran dilakukan saat barang diterima (COD).'
                : 'Pesanan berhasil dibuat. Silakan lakukan transfer ke rekening yang tercantum.';

            return redirect()->route('orders.show', $order->id)->with('success', $message);
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Gagal membuat pesanan. Silakan coba lagi.');
        }
    }
}
