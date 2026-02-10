<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = Wishlist::where('user_id', auth()->id())
            ->with('product')
            ->latest()
            ->paginate(12);

        return view('wishlist.index', compact('wishlists'));
    }

    public function toggle(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $product = Product::where('is_active', true)->findOrFail($request->product_id);
        $existing = Wishlist::where('user_id', auth()->id())->where('product_id', $product->id)->first();

        if ($existing) {
            $existing->delete();
            $added = false;
        } else {
            Wishlist::create([
                'user_id' => auth()->id(),
                'product_id' => $product->id,
            ]);
            $added = true;
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'added' => $added,
            ]);
        }

        return back()->with('success', $added ? 'Ditambahkan ke wishlist' : 'Dihapus dari wishlist');
    }

    public function remove(Request $request, int $productId)
    {
        Wishlist::where('user_id', auth()->id())->where('product_id', $productId)->delete();
        return back()->with('success', 'Produk dihapus dari wishlist');
    }
}
