<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CartService
{
    protected string $sessionKey = 'cart';

    /**
     * Ambil semua item di keranjang dengan detail produk.
     */
    public function getItems(): array
    {
        $cart = Session::get($this->sessionKey, []);
        $items = [];
        foreach ($cart as $productId => $quantity) {
            $product = Product::where('is_active', true)->find($productId);
            if ($product) {
                $items[] = [
                    'product' => $product,
                    'quantity' => (int) $quantity,
                    'subtotal' => $product->price * (int) $quantity,
                ];
            }
        }
        return $items;
    }

    /**
     * Tambah produk ke keranjang.
     */
    public function add(int $productId, int $quantity = 1): void
    {
        $cart = Session::get($this->sessionKey, []);
        $current = (int) ($cart[$productId] ?? 0);
        $cart[$productId] = $current + $quantity;
        Session::put($this->sessionKey, $cart);
    }

    /**
     * Update jumlah produk di keranjang.
     */
    public function update(int $productId, int $quantity): void
    {
        $cart = Session::get($this->sessionKey, []);
        if ($quantity <= 0) {
            unset($cart[$productId]);
        } else {
            $cart[$productId] = $quantity;
        }
        Session::put($this->sessionKey, $cart);
    }

    /**
     * Hapus produk dari keranjang.
     */
    public function remove(int $productId): void
    {
        $cart = Session::get($this->sessionKey, []);
        unset($cart[$productId]);
        Session::put($this->sessionKey, $cart);
    }

    /**
     * Kosongkan keranjang.
     */
    public function clear(): void
    {
        Session::forget($this->sessionKey);
    }

    /**
     * Subtotal keranjang (tanpa ongkir).
     */
    public function subtotal(): float
    {
        $items = $this->getItems();
        return collect($items)->sum('subtotal');
    }

    /**
     * Jumlah item (total quantity).
     */
    public function count(): int
    {
        $cart = Session::get($this->sessionKey, []);
        return (int) array_sum($cart);
    }

    /**
     * Apakah keranjang kosong?
     */
    public function isEmpty(): bool
    {
        return $this->count() === 0;
    }
}
