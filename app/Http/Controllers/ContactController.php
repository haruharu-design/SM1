<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        // Untuk sekarang, kita hanya redirect dengan success message
        // Nanti bisa ditambah kirim email atau simpan ke database
        return redirect()->route('contact')->with('success', 'Pesan berhasil dikirim!');
    }
}

