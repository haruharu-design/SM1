<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::where('is_active', true)->latest()->take(6)->get();
        $wishlistIds = auth()->check()
            ? Wishlist::where('user_id', auth()->id())->pluck('product_id')->toArray()
            : [];
        return view('home', compact('products', 'wishlistIds'));
    }
}

