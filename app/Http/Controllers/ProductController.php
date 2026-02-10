<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where('is_active', true)->latest()->paginate(12);
        $wishlistIds = auth()->check()
            ? Wishlist::where('user_id', auth()->id())->pluck('product_id')->toArray()
            : [];
        return view('products.index', compact('products', 'wishlistIds'));
    }

    public function show($id)
    {
        $product = Product::where('is_active', true)
            ->with(['reviews' => fn ($q) => $q->where('is_visible', true)->with('user')->latest()])
            ->with(['productQuestions' => fn ($q) => $q->whereNotNull('answer')->with('user', 'answeredByUser')])
            ->findOrFail($id);

        $hasPurchased = auth()->check() && Order::where('user_id', auth()->id())
            ->whereIn('status', [Order::STATUS_DELIVERED, Order::STATUS_CONFIRMED, Order::STATUS_ON_DELIVERY, Order::STATUS_PICKED_UP])
            ->whereHas('items', fn ($q) => $q->where('product_id', $product->id))
            ->exists();

        $hasReviewed = auth()->check() && \App\Models\Review::where('product_id', $product->id)->where('user_id', auth()->id())->exists();
        $isInWishlist = auth()->check() && Wishlist::where('user_id', auth()->id())->where('product_id', $product->id)->exists();

        return view('products.show', compact('product', 'hasPurchased', 'hasReviewed', 'isInWishlist'));
    }
}

