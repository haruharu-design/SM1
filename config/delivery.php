<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Lokasi Penjual (Toko / Gudang)
    |--------------------------------------------------------------------------
    | Koordinat digunakan sebagai titik awal perhitungan jarak pengiriman.
    | Format: latitude, longitude (contoh: Pontianak -0.0263, 109.3425)
    */
    'store' => [
        'latitude' => (float) env('STORE_LATITUDE', -0.0263),
        'longitude' => (float) env('STORE_LONGITUDE', 109.3425),
    ],

    /*
    |--------------------------------------------------------------------------
    | Tarif Pengiriman per Kilometer
    |--------------------------------------------------------------------------
    | Biaya pengiriman = jarak (km) × tarif per km.
    | Contoh: Rp3.000/km → 10 km = Rp30.000
    */
    'rate_per_km' => (int) env('DELIVERY_RATE_PER_KM', 3000),

    /*
    |--------------------------------------------------------------------------
    | Provider Peta untuk Geocoding
    |--------------------------------------------------------------------------
    | nominatim = OpenStreetMap (gratis, tanpa API key)
    | google = Google Maps Geocoding API (perlu API key)
    */
    'driver' => env('DELIVERY_MAP_DRIVER', 'nominatim'),

    /*
    |--------------------------------------------------------------------------
    | Google Maps API Key (opsional)
    |--------------------------------------------------------------------------
    | Diperlukan jika driver = google
    */
    'google_api_key' => env('GOOGLE_MAPS_API_KEY', ''),

];
