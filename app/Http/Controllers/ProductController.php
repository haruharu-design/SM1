<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductView;
use App\Models\Wishlist;
use App\Services\RecommendationService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('is_active', true)->with('category');

        // Search: nama atau deskripsi
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        // Filter: Kategori
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter: Rentang harga
        if ($request->filled('price_min')) {
            $query->where('price', '>=', (float) $request->price_min);
        }
        if ($request->filled('price_max')) {
            $query->where('price', '<=', (float) $request->price_max);
        }

        // Sort
        $sort = $request->get('sort', 'terbaru');
        match ($sort) {
            'terpopuler' => $query->withCount(['orderItems' => fn ($q) => $q->join('orders', 'order_items.order_id', '=', 'orders.id')
                ->whereIn('orders.status', [Order::STATUS_COMPLETED, Order::STATUS_SHIPPED])])
                ->orderByDesc('order_items_count'),
            'rating' => $query->withAvg('reviews', 'rating')->orderByDesc('reviews_avg_rating'),
            'harga_terendah' => $query->orderBy('price'),
            'harga_tertinggi' => $query->orderByDesc('price'),
            default => $query->latest(),
        };

        $products = $query->paginate(12)->withQueryString();

        $categories = Category::orderBy('name')->get();
        $wishlistIds = auth()->check()
            ? Wishlist::where('user_id', auth()->id())->pluck('product_id')->toArray()
            : [];

        // Rekomendasi untuk user (sidebar atau section)
        $recommendationService = new RecommendationService();
        $recommendations = $recommendationService->getRecommendations(4);

        return view('products.index', compact('products', 'categories', 'wishlistIds', 'recommendations', 'request'));
    }

    public function show(Request $request, $id)
    {
        $product = Product::where('is_active', true)
            ->with('category')
            ->with(['reviews' => fn ($q) => $q->where('is_visible', true)->with('user')->latest()])
            ->with(['productQuestions' => fn ($q) => $q->whereNotNull('answer')->with('user', 'answeredByUser')])
            ->findOrFail($id);

        // Catat riwayat penayangan (Product View Tracking)
        $this->recordProductView($product->id);

        $hasPurchased = auth()->check() && Order::where('user_id', auth()->id())
            ->whereIn('status', [Order::STATUS_DELIVERED, Order::STATUS_CONFIRMED, Order::STATUS_ON_DELIVERY, Order::STATUS_PICKED_UP])
            ->whereHas('items', fn ($q) => $q->where('product_id', $product->id))
            ->exists();

        $hasReviewed = auth()->check() && \App\Models\Review::where('product_id', $product->id)->where('user_id', auth()->id())->exists();
        $isInWishlist = auth()->check() && Wishlist::where('user_id', auth()->id())->where('product_id', $product->id)->exists();

        // Produk terkait & rekomendasi (berdasarkan kategori produk yang sedang dilihat)
        $recommendationService = new RecommendationService();
        $relatedProducts = $recommendationService->getRelatedProducts($product->id, 6);
        $personalizedRecommendations = $recommendationService->getRecommendations(
            6,
            $product->id,
            $product->category_id // pakai kategori produk yang baru ditekan
        );

        return view('products.show', compact(
            'product',
            'hasPurchased',
            'hasReviewed',
            'isInWishlist',
            'relatedProducts',
            'personalizedRecommendations'
        ));
    }

    /**
     * Mencatat produk yang dilihat user (untuk algoritma rekomendasi)
     */
    protected function recordProductView(int $productId): void
    {
        $data = [
            'product_id' => $productId,
            'user_id' => auth()->id(),
            'session_id' => auth()->check() ? null : session()->getId(),
        ];

        // Batasi: 1x per user/session per produk per 5 menit (supaya "terakhir dilihat" tetap akurat)
        $exists = ProductView::where('product_id', $productId)
            ->where(function ($q) use ($data) {
                if ($data['user_id']) {
                    $q->where('user_id', $data['user_id']);
                } else {
                    $q->where('session_id', $data['session_id']);
                }
            })
            ->where('created_at', '>=', now()->subMinutes(5))
            ->exists();

        if (!$exists) {
            ProductView::create($data);
        }
    }
}
