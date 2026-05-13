<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(
        protected CartService $cart
    ) {}

    public function index()
    {
        $items = $this->cart->getItems();
        $subtotal = $this->cart->subtotal();

        return view('cart.index', compact('items', 'subtotal'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::where('is_active', true)->findOrFail($request->product_id);
        $qtyToAdd = (int) $request->quantity;
        $stock = (int) ($product->stock ?? 0);

        if ($stock <= 0) {
            return back()->with('error', 'Stok produk habis, tidak bisa ditambahkan ke keranjang.');
        }

        $existingQty = collect($this->cart->getItems())
            ->firstWhere('product.id', $product->id)['quantity'] ?? 0;
        $targetQty = (int) $existingQty + $qtyToAdd;

        if ($targetQty > $stock) {
            return back()->with('error', 'Jumlah melebihi stok tersedia (stok: '.$stock.').');
        }

        $this->cart->add($product->id, $qtyToAdd);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Produk ditambahkan ke keranjang',
                'cart_count' => $this->cart->count(),
            ]);
        }

        return back()->with('success', 'Produk ditambahkan ke keranjang');
    }

    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:0',
        ]);

        $product = Product::where('is_active', true)->findOrFail($request->product_id);
        $stock = (int) ($product->stock ?? 0);
        $newQty = (int) $request->quantity;

        if ($newQty > $stock) {
            return back()->with('error', 'Jumlah melebihi stok tersedia (stok: '.$stock.').');
        }

        $this->cart->update($request->product_id, $newQty);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'cart_count' => $this->cart->count(),
                'subtotal' => $this->cart->subtotal(),
            ]);
        }

        return back()->with('success', 'Keranjang diperbarui');
    }

    public function remove(Request $request, int $productId)
    {
        $this->cart->remove($productId);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'cart_count' => $this->cart->count(),
                'subtotal' => $this->cart->subtotal(),
            ]);
        }

        return back()->with('success', 'Produk dihapus dari keranjang');
    }
}
