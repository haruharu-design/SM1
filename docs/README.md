# Dokumentasi Konseptual — Admin Page & Optional Features

Dokumentasi ini disusun untuk kebutuhan **akademik** dengan penekanan pada **konsep dan manfaat** sistem, bukan hanya implementasi teknis.

## Daftar Dokumen

1. **[ADMIN_PAGE.md](ADMIN_PAGE.md)** — Admin Page  
   - Konsep dasar Admin Page dan perannya sebagai pusat kendali.  
   - Manajemen user (lihat, edit, suspend).  
   - Manajemen produk (CRUD).  
   - Manajemen order.  
   - Manajemen coupon.  
   - Monitoring transaksi dan pembayaran.  
   - Dashboard ringkasan (jumlah user, order, pendapatan).  
   - Ringkasan implementasi teknis untuk setiap bagian.

2. **[OPTIONAL_FEATURES.md](OPTIONAL_FEATURES.md)** — Optional Features (Fitur Tambahan Pendukung Interaksi User)  
   Setiap fitur dijelaskan dengan: **fungsi**, **alur kerja**, **manfaat bagi user**, **manfaat bagi sistem**.  
   - Wishlist (dan perbedaannya dengan keranjang).  
   - Coupon (skenario penggunaan).  
   - Notification (email / in-app / push).  
   - Payment Gateway.  
   - Rating & Review produk.  
   - Top Up Saldo.  
   - Filter produk (dikaitkan dengan personalisasi).  
   - Rekomendasi produk (bukan hanya berdasarkan harga).  
   - Order status & pengantaran (dengan API eksternal tracking).

3. **[ORDER_STATUS_DAN_PENGANTARAN.md](ORDER_STATUS_DAN_PENGANTARAN.md)** — Order Status & Pengantaran (konsep ojek online)  
   - Biaya pengiriman berdasarkan jarak (Rp3.000/km).  
   - Perhitungan jarak otomatis berbasis peta (API Maps: Nominatim/Google).  
   - Alur: user input alamat → sistem tampilkan jarak & estimasi ongkir → ongkir masuk total pembayaran → status order (Pending → Confirmed → Picked Up → On Delivery → Delivered).  
   - Penjelasan: cara kerja perhitungan jarak, integrasi API Maps, manfaat bagi user dan sistem, peningkatan user experience.

## Cara Menggunakan

- Untuk **presentasi atau laporan**: gunakan penjelasan konseptual dari kedua dokumen.  
- Untuk **implementasi**: gunakan ringkasan teknis di ADMIN_PAGE.md dan struktur tabel/model yang sudah disiapkan di proyek (migrations, models, Filament resources).

## Implementasi di Proyek

- **Admin Panel**: `/admin` (hanya untuk user dengan role `admin`).  
- **Tabel dan model**: products, orders (termasuk distance_km, shipping_cost, shipping_lat, shipping_lng), order_items, coupons, payments, wishlists, reviews; kolom `suspended_at` pada users.  
- **Filament**: User, Product, Order (status: Pending, Confirmed, Picked Up, On Delivery, Delivered, Cancelled), Coupon, Payment resources; dashboard widget.  
- **Login**: Admin → redirect ke `/admin`; User → redirect ke halaman utama.  
- **Ongkir**: `POST /shipping/calculate` (body: `address`) → response: jarak km, biaya ongkir, koordinat; konfigurasi di `config/delivery.php`.  
- **Tampilan pengguna** (Login, Signup, Home, About, Product, Contact, Profile) **tidak diubah**.
