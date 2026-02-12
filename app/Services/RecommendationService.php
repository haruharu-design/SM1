<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductView;
use Illuminate\Support\Collection;

/**
 * Layanan Rekomendasi Berbasis Perilaku User (B2C Concept)
 *
 * Rekomendasi berdasarkan produk PALING TERAKHIR yang user tekan/lihat.
 * Jika user pindah ke kategori berbeda, rekomendasi berubah ke kategori baru itu.
 */
class RecommendationService
{
    public function __construct(
        protected ?int $userId = null,
        protected ?string $sessionId = null,
    ) {
        $this->userId = $userId ?? auth()->id();
        $this->sessionId = $sessionId ?? session()->getId();
    }

    /**
     * Mendapatkan rekomendasi produk untuk user.
     * Berdasarkan kategori produk yang PALING TERAKHIR user lihat.
     * Jika user klik produk kategori berbeda = clear lama, tampilkan kategori baru.
     *
     * @param  int  $limit
     * @param  int|null  $excludeProductId  Produk yang sedang dilihat (untuk halaman detail)
     * @param  int|null  $currentCategoryId  Kategori produk yang sedang dilihat (prioritas jika ada)
     * @return Collection<int, Product>
     */
    public function getRecommendations(int $limit = 8, ?int $excludeProductId = null, ?int $currentCategoryId = null): Collection
    {
        // Jika sedang di halaman detail produk, pakai kategori produk tersebut (baru ditekan)
        $categoryId = $currentCategoryId ?? $this->getMostRecentlyViewedCategoryId();

        if (!$categoryId) {
            return collect();
        }

        $excludeIds = $excludeProductId ? collect([$excludeProductId]) : collect();

        return $this->getPopularProductsInCategories(collect([$categoryId]), $limit, $excludeIds);
    }

    /**
     * ID kategori dari produk yang PALING TERAKHIR user lihat
     */
    protected function getMostRecentlyViewedCategoryId(): ?int
    {
        $query = ProductView::query()
            ->join('products', 'product_views.product_id', '=', 'products.id')
            ->where('product_views.created_at', '>=', now()->subDays(30))
            ->where('products.is_active', true)
            ->whereNotNull('products.category_id');

        if ($this->userId) {
            $query->where('product_views.user_id', $this->userId);
        } else {
            $query->where('product_views.session_id', $this->sessionId);
        }

        $row = $query
            ->orderByDesc('product_views.created_at')
            ->select('products.category_id')
            ->first();

        return $row?->category_id;
    }

    /**
     * Rekomendasi "Produk Terkait" berdasarkan kategori produk saat ini
     *
     * @param  int  $productId
     * @param  int  $limit
     * @return Collection<int, Product>
     */
    public function getRelatedProducts(int $productId, int $limit = 6): Collection
    {
        $product = Product::find($productId);
        if (!$product || !$product->category_id) {
            return collect();
        }

        return Product::where('is_active', true)
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $productId)
            ->withAvg('reviews', 'rating')
            ->orderByDesc('reviews_avg_rating')
            ->orderByDesc('created_at')
            ->take($limit)
            ->get();
    }

    /**
     * Produk populer dalam kategori tertentu (berdasarkan rating & penjualan)
     */
    protected function getPopularProductsInCategories(Collection $categoryIds, int $limit, Collection $excludeIds): Collection
    {
        if ($categoryIds->isEmpty()) {
            return collect();
        }

        return Product::where('is_active', true)
            ->whereIn('category_id', $categoryIds)
            ->when($excludeIds->isNotEmpty(), fn ($q) => $q->whereNotIn('id', $excludeIds->toArray()))
            ->withAvg('reviews', 'rating')
            ->withCount(['orderItems' => fn ($q) => $q->join('orders', 'order_items.order_id', '=', 'orders.id')
                ->whereIn('orders.status', [Order::STATUS_COMPLETED, Order::STATUS_SHIPPED])])
            ->get()
            ->sortByDesc(fn ($p) => ($p->reviews_avg_rating ?? 0) * 2 + $p->order_items_count)
            ->take($limit)
            ->values();
    }

}
