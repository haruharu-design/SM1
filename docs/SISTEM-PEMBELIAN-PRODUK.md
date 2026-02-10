# Penjelasan Sistem Pembelian Produk

## Dokumentasi untuk Laporan Akademik

---

## 1. Perbedaan Beli Langsung dan Keranjang

### A. Beli Langsung (Direct Purchase)

**Definisi:** Metode pembelian di mana pengguna hanya membeli **satu produk** dalam satu transaksi dan langsung menuju proses checkout tanpa menyimpan produk ke keranjang terlebih dahulu.

**Karakteristik:**
- Hanya 1 produk per transaksi
- Langsung masuk ke halaman checkout setelah memilih produk
- Tidak disimpan ke keranjang (session)
- Cocok untuk pembelian impulsif atau kebutuhan mendesak
- Proses lebih cepat karena langkah lebih sedikit

**Alur:**
1. User melihat detail produk
2. User memilih jumlah
3. User klik "Beli Langsung"
4. User diarahkan ke halaman checkout
5. User mengisi alamat pengiriman
6. Sistem menghitung biaya pengiriman
7. User melakukan pembayaran

### B. Keranjang (Cart)

**Definisi:** Metode pembelian di mana pengguna dapat menambahkan **lebih dari satu produk** ke dalam wadah virtual (keranjang) sebelum melakukan checkout.

**Karakteristik:**
- Banyak produk dalam satu transaksi
- Setiap produk memiliki quantity (jumlah) yang dapat diubah
- User dapat menambah, mengurangi, atau menghapus produk sebelum checkout
- Total harga keranjang dihitung otomatis
- Cocok untuk belanja dalam jumlah banyak
- Data keranjang disimpan sementara di session

**Alur:**
1. User menambahkan produk ke keranjang (dari halaman produk atau listing)
2. User dapat mengunjungi halaman keranjang untuk mengubah jumlah atau menghapus produk
3. User klik "Checkout" saat siap membayar
4. User diarahkan ke halaman checkout
5. User mengisi alamat pengiriman
6. Sistem menghitung biaya pengiriman
7. User melakukan pembayaran

**Perbandingan Singkat:**

| Aspek | Beli Langsung | Keranjang |
|-------|---------------|-----------|
| Jumlah produk | 1 produk | Banyak produk |
| Penyimpanan | Tidak disimpan | Disimpan di session |
| Langkah | Lebih sedikit | Lebih banyak (tambah → keranjang → checkout) |
| Use case | Pembelian cepat | Belanja terencana |

---

## 2. Integrasi Sistem Pengiriman Berbasis Jarak

### Konsep Dasar

Sistem pengiriman ini menghitung biaya pengiriman berdasarkan **jarak geografis** antara lokasi penjual (toko) dan alamat pengiriman pembeli. Jarak diperoleh melalui proses **geocoding** (mengubah alamat teks menjadi koordinat lintang/bujur) dan perhitungan **Haversine** (jarak antara dua titik di bumi).

### Komponen Integrasi

1. **Lokasi Penjual (Store Location)**
   - Koordinat toko disimpan di konfigurasi (`config/delivery.php`)
   - Default: Pontianak (-0.0263, 109.3425)
   - Dapat diubah melalui variabel lingkungan `.env`

2. **Geocoding (Alamat → Koordinat)**
   - Menggunakan API eksternal untuk mengubah alamat teks menjadi koordinat
   - Mendukung **Nominatim (OpenStreetMap)** — gratis, tanpa API key
   - Mendukung **Google Maps Geocoding API** — akurat, perlu API key

3. **Perhitungan Jarak (Haversine)**
   - Rumus Haversine menghitung jarak "garis lurus" antara dua koordinat
   - Satuan: kilometer (km)
   - Akurat untuk jarak menengah

4. **Tarif Pengiriman**
   - Tarif: **Rp 3.000 per km**
   - Formula: `Biaya = Jarak (km) × Rp 3.000`
   - Contoh: 10 km → Rp 30.000

### Alur Kerja

```
Alamat Pembeli (teks)
        ↓
   Geocoding API (Nominatim/Google)
        ↓
   Koordinat Pembeli (lat, lng)
        ↓
   Rumus Haversine (toko ↔ pembeli)
        ↓
   Jarak (km)
        ↓
   Jarak × Rp 3.000 = Biaya Pengiriman
```

---

## 3. Cara Perhitungan Total Harga

### A. Beli Langsung

```
Total Pembayaran = (Harga Produk × Jumlah) + Biaya Pengiriman
```

Contoh:
- Produk A: Rp 50.000 × 1 = Rp 50.000
- Jarak: 5 km → Ongkir: 5 × Rp 3.000 = Rp 15.000
- **Total: Rp 65.000**

### B. Keranjang

```
Total Pembayaran = Σ (Harga Produk × Quantity) + Biaya Pengiriman
```

- Biaya pengiriman hanya dihitung **1 kali per order**, tidak per item
- Subtotal produk = jumlah dari (harga × qty) setiap item
- Total = Subtotal + Ongkir

Contoh:
- Produk A: Rp 50.000 × 2 = Rp 100.000
- Produk B: Rp 30.000 × 1 = Rp 30.000
- Subtotal: Rp 130.000
- Jarak: 8 km → Ongkir: 8 × Rp 3.000 = Rp 24.000
- **Total: Rp 154.000**

### Pembaruan Otomatis

Total harga diperbarui otomatis saat:
- **Alamat berubah** — sistem menghitung ulang jarak dan ongkir
- **Produk ditambah/dikurangi di keranjang** — subtotal berubah
- **Quantity diubah** — subtotal item dan total keranjang berubah

---

## 4. Manfaat Fitur bagi User

1. **Fleksibilitas Pembelian**
   - User bisa memilih antara pembelian cepat (Beli Langsung) atau belanja terencana (Keranjang)

2. **Transparansi Harga**
   - Biaya pengiriman dihitung sebelum checkout, sehingga user tahu total pembayaran sejak awal

3. **Kontrol atas Keranjang**
   - User dapat mengubah jumlah atau menghapus produk sebelum membayar

4. **Efisiensi**
   - Beli Langsung mengurangi langkah untuk pembelian tunggal
   - Keranjang memungkinkan pembelian banyak item dalam satu transaksi (ongkir satu kali)

5. **Kejelasan Lokasi**
   - Sistem memvalidasi alamat melalui geocoding, meminimalkan kesalahan pengiriman

---

## 5. Dampak terhadap User Experience (UX)

1. **Kemudahan (Ease of Use)**
   - Dua opsi jelas: Beli Langsung dan Keranjang
   - Tombol dan label yang deskriptif

2. **Kepuasan (Satisfaction)**
   - Perhitungan ongkir yang transparan meningkatkan kepercayaan
   - User tidak merasa "dikejutkan" oleh biaya tersembunyi

3. **Efisiensi Waktu**
   - Beli Langsung mempercepat pembelian untuk kebutuhan mendesak
   - Keranjang menghindari pembayaran berulang untuk banyak item

4. **Kontrol (Control)**
   - User merasa memiliki kendali penuh atas keranjang dan total belanja

5. **Konsistensi (Consistency)**
   - Alur checkout sama untuk Beli Langsung dan Keranjang, hanya sumber datanya yang berbeda

---

## Ringkasan Teknis

| Komponen | Implementasi |
|----------|--------------|
| Keranjang | Session-based (`CartService`) |
| Checkout | Satu halaman untuk Beli Langsung & Keranjang |
| Geocoding | Nominatim (default) / Google Maps API |
| Jarak | Rumus Haversine |
| Tarif | Rp 3.000/km (konfigurasi `.env`) |
| Order | Model `Order`, `OrderItem`, `Payment` |

---

*Dokumen ini disusun untuk keperluan laporan akademik dan dokumentasi sistem.*
