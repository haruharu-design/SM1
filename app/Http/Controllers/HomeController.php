<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use App\Services\RecommendationService;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::where('is_active', true)->with('category')->latest()->take(6)->get();
        $wishlistIds = auth()->check()
            ? Wishlist::where('user_id', auth()->id())->pluck('product_id')->toArray()
            : [];

        // Rekomendasi personalisasi (B2C) - untuk user yang punya riwayat
        $recommendations = (new RecommendationService())->getRecommendations(6);

        return view('home', compact('products', 'wishlistIds', 'recommendations'));
    }
}

