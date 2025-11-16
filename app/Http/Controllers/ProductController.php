<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // Untuk sekarang, kita return view saja
        // Nanti bisa ditambah query products dari database
        return view('products.index');
    }

    public function show($id)
    {
        // Untuk sekarang, kita return view saja
        // Nanti bisa ditambah query product by id dari database
        return view('products.show', compact('id'));
    }
}

