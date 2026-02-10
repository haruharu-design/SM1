<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Cek: user harus pernah membeli produk ini
        $hasPurchased = Order::where('user_id', auth()->id())
            ->whereIn('status', [Order::STATUS_DELIVERED, Order::STATUS_CONFIRMED, Order::STATUS_ON_DELIVERY, Order::STATUS_PICKED_UP])
            ->whereHas('items', fn ($q) => $q->where('product_id', $product->id))
            ->exists();

        if (!$hasPurchased) {
            return back()->with('error', 'Anda hanya dapat memberikan ulasan setelah melakukan pembelian produk ini.');
        }

        // Cek: user belum review produk ini
        if (Review::where('user_id', auth()->id())->where('product_id', $product->id)->exists()) {
            return back()->with('error', 'Anda sudah memberikan ulasan untuk produk ini.');
        }

        Review::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
            'order_id' => null,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_visible' => false, // Menunggu moderasi admin
        ]);

        return back()->with('success', 'Ulasan berhasil dikirim. Menunggu persetujuan admin.');
    }
}
