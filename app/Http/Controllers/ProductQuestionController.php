<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductQuestion;
use Illuminate\Http\Request;

class ProductQuestionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'question' => 'required|string|max:500',
        ]);

        ProductQuestion::create([
            'product_id' => $request->product_id,
            'user_id' => auth()->id(),
            'question' => $request->question,
        ]);

        return back()->with('success', 'Pertanyaan berhasil dikirim. Admin akan segera menjawab.');
    }
}
