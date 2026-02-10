<?php

namespace App\Services;

class ShippingService
{
    /**
     * Biaya pengiriman dummy/acak (Rp) sebagai simulasi.
     * Tanpa API Maps - digunakan langsung untuk perhitungan.
     */
    protected array $dummyCosts = [10000, 15000, 20000];

    /**
     * Hitung biaya pengiriman (dummy/randomized).
     * Tidak menggunakan API - hanya simulasi untuk keperluan demo.
     *
     * @return array{success: bool, distance_km: null, shipping_cost: int, shipping_lat: null, shipping_lng: null, formatted_address: string}
     */
    public function calculateFromAddress(string $address): array
    {
        $shippingCost = $this->dummyCosts[array_rand($this->dummyCosts)];

        return [
            'success' => true,
            'distance_km' => null,
            'shipping_cost' => $shippingCost,
            'shipping_lat' => null,
            'shipping_lng' => null,
            'formatted_address' => $address,
        ];
    }
}
