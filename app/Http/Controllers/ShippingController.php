<?php

namespace App\Http\Controllers;

use App\Services\ShippingService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ShippingController extends Controller
{
    /**
     * Hitung jarak dan biaya pengiriman berdasarkan alamat.
     * Dipanggil saat checkout agar user melihat estimasi ongkir sebelum bayar.
     */
    public function calculate(Request $request): JsonResponse
    {
        $request->validate([
            'address' => 'required|string|max:500',
        ]);

        $service = new ShippingService();
        $result = $service->calculateFromAddress($request->input('address'));

        return response()->json($result);
    }
}
