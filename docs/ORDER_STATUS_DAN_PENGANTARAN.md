# Order Status & Pengantaran — Konsep dan Implementasi

Dokumen ini menjelaskan fitur **Order Status & Pengantaran** dengan konsep pengiriman mirip layanan ojek online (Gojek/Grab), termasuk perhitungan biaya berdasarkan jarak dan integrasi peta. Penjelasan bersifat konseptual dan mudah dipahami untuk keperluan laporan akademik.

---

## 1. Konsep Dasar: Pengiriman Berbasis Jarak

Dalam layanan ojek online, biaya perjalanan sering dihitung berdasarkan **jarak tempuh**: semakin jauh tujuan, semakin tinggi ongkos. Fitur pengantaran di toko online ini mengadopsi gagasan yang sama:

- **Lokasi penjual (toko/gudang)** dianggap sebagai titik awal.
- **Alamat pembeli** adalah titik tujuan.
- **Jarak** antara kedua titik dihitung secara otomatis (berbasis peta).
- **Biaya pengiriman** = jarak (km) × tarif per km.

Dengan demikian, pembeli hanya perlu memasukkan alamat; sistem yang menghitung jarak dan menampilkan estimasi ongkir. Transparansi ini meningkatkan kepercayaan dan mengurangi pertanyaan “kenapa ongkirnya segini?”.

---

## 2. Ketentuan Fitur (Implementasi)

### 2.1 Biaya Pengiriman Berdasarkan Jarak

- **Tarif**: Rp3.000 per 1 km.
- **Rumus**: `Biaya pengiriman = jarak (km) × 3.000`
- **Contoh**:
  - 1 km → Rp3.000  
  - 10 km → Rp30.000  

Tarif dan rumus ini dapat diubah melalui konfigurasi (file `config/delivery.php` atau variabel environment) tanpa mengubah logika aplikasi.

### 2.2 Perhitungan Jarak Secara Otomatis (Berbasis Peta)

Perhitungan jarak dilakukan dalam dua tahap:

1. **Geocoding**: Alamat teks (yang user ketik) diubah menjadi **koordinat** (latitude, longitude) dengan bantuan **API peta** (Google Maps, Mapbox, atau OpenStreetMap/Nominatim).
2. **Menghitung jarak**: Dari koordinat lokasi penjual dan koordinat alamat pembeli, sistem menghitung **jarak** (dalam km). Dalam implementasi ini digunakan rumus **Haversine** (jarak garis lurus di permukaan Bumi). Alternatif lain adalah **Distance Matrix API** (jarak jalan/estimasi waktu), yang lebih mendekati pengalaman ojek online.

Dengan demikian, perhitungan **otomatis** dan **berbasis peta**: tidak ada input manual jarak oleh admin; sistem yang menentukan dari alamat.

### 2.3 Alur Pengiriman (User dan Sistem)

1. **User memasukkan alamat pengiriman** (dan nomor telepon jika perlu) saat checkout.
2. **Sistem menampilkan jarak tempuh dan estimasi biaya** — dengan memanggil layanan geocoding dan perhitungan jarak, lalu mengalikan dengan tarif per km.
3. **Biaya pengiriman otomatis ditambahkan ke total pembayaran** — total order = subtotal produk − diskon (jika ada) + biaya pengiriman.
4. **Status order berubah sesuai proses pengiriman** — dari Pending sampai Delivered, mirip alur order di aplikasi ojek online.

Alur ini memberikan pengalaman yang **konsisten dan dapat diprediksi** bagi user.

### 2.4 Status Order & Pengiriman

Status order dirancang mengikuti tahapan pengiriman yang umum:

| Status        | Makna singkat |
|---------------|----------------|
| **Pending**   | Order baru, menunggu konfirmasi / pembayaran. |
| **Confirmed** | Sudah dikonfirmasi (misalnya pembayaran diterima); siap diproses. |
| **Picked Up** | Barang sudah diambil kurir dari penjual (mirip “driver sampai di penjemputan”). |
| **On Delivery** | Barang dalam perjalanan ke alamat pembeli. |
| **Delivered** | Barang sudah sampai dan diserahkan ke pembeli. |
| **Cancelled** | Order dibatalkan. |

Admin dapat mengubah status order di dashboard (misalnya dari Pending → Confirmed → Picked Up → On Delivery → Delivered) sehingga pembeli dan penjual sama-sama memahami di tahap mana order berada.

---

## 3. Cara Kerja Perhitungan Jarak

### 3.1 Secara Konseptual

1. **Titik awal**: Lokasi penjual (toko) disimpan sebagai koordinat (latitude, longitude) di konfigurasi.
2. **Titik tujuan**: User memasukkan alamat dalam bentuk teks. Sistem mengirim alamat ini ke **API Geocoding**; API mengembalikan koordinat (lat, lng) yang mewakili alamat tersebut di peta.
3. **Menghitung jarak**: Dari dua pasang koordinat (penjual dan pembeli), sistem menghitung jarak dengan **rumus Haversine**. Rumus ini memperhitungkan kelengkungan Bumi sehingga hasilnya dalam satuan kilometer (atau meter) yang wajar untuk kebutuhan estimasi.
4. **Menghitung biaya**: Jarak (km) dikalikan tarif per km (Rp3.000); hasilnya adalah estimasi biaya pengiriman yang kemudian ditambahkan ke total pembayaran.

### 3.2 Secara Teknis (Ringkasan)

- **Geocoding**:  
  - **Nominatim (OpenStreetMap)**: Gratis, tanpa API key. Request HTTP GET ke Nominatim dengan parameter alamat; respons berisi `lat` dan `lon`.  
  - **Google Geocoding API**: Memerlukan API key; mengembalikan koordinat dan alamat terformat. Lebih akurat untuk alamat kompleks jika dikonfigurasi.

- **Jarak**:  
  - **Haversine**: Input dua pasang (lat, lng); output jarak dalam km. Implementasi ada di kelas layanan (misalnya `ShippingService`).  
  - **Alternatif**: Google Distance Matrix API memberikan jarak *jalan* dan estimasi waktu; cocok jika ingin tampilan “mirip ojek online” (estimasi waktu sampai).

- **Biaya**:  
  - `shipping_cost = ceil(distance_km × rate_per_km)`  
  - Nilai disimpan di order bersama `distance_km` dan koordinat alamat pengiriman (opsional, untuk audit atau peta).

---

## 4. Integrasi API Maps

### 4.1 Peran API Peta

- **Geocoding**: Mengubah “alamat teks” → “koordinat”. Tanpa ini, sistem tidak bisa menghitung jarak secara otomatis dari alamat.
- **Alternatif lanjutan**: **Distance Matrix** atau **Directions API** untuk jarak jalan dan estimasi waktu (seperti di aplikasi ojek online).

### 4.2 Pilihan Provider

- **OpenStreetMap (Nominatim)**  
  - Gratis, tanpa API key.  
  - Cocok untuk pembelajaran dan laporan akademik.  
  - Batas penggunaan (rate limit) perlu diperhatikan.

- **Google Maps (Geocoding / Distance Matrix)**  
  - Memerlukan API key dan berpotensi berbayar setelah kuota gratis.  
  - Akurasi dan cakupan alamat umumnya sangat baik.  
  - Dapat dipilih jika ingin hasil lebih akurat atau jarak jalan.

- **Mapbox**  
  - Juga menyediakan geocoding dan routing; alternatif lain jika ingin mengganti provider.

Implementasi di proyek ini dirancang agar **driver** (provider) bisa dipilih lewat konfigurasi (misalnya `nominatim` atau `google`), sehingga penjelasan konseptual “integrasi API Maps” tetap berlaku: sistem memanggil API peta untuk mendapatkan koordinat (dan bila perlu jarak jalan), lalu menggunakan hasil tersebut untuk menghitung biaya dan menampilkan informasi ke user.

---

## 5. Manfaat Fitur bagi User dan Sistem

### 5.1 Manfaat bagi User

- **Transparansi**: User melihat jarak dan biaya pengiriman **sebelum** membayar, sehingga tidak ada kejutan di akhir.
- **Kepastian**: Estimasi ongkir konsisten dengan aturan (Rp3.000/km), mirip perhitungan tarif ojek yang mudah dipahami.
- **Kenyamanan**: Cukup memasukkan alamat; tidak perlu mencari jarak sendiri atau menebak ongkir.
- **Pelacakan status**: Status order (Pending → Confirmed → Picked Up → On Delivery → Delivered) memberi gambaran jelas di tahap mana pesanan berada, mirip tracking di aplikasi ojek online.

### 5.2 Manfaat bagi Sistem (Bisnis / Operasional)

- **Operasional**: Admin punya alur status yang jelas untuk mengkoordinasikan pengambilan barang dan pengantaran.
- **Keuangan**: Biaya pengiriman tercatat per order (jarak, ongkir), memudahkan rekonsiliasi dan analisis margin.
- **Kepercayaan**: Perhitungan yang otomatis dan terdokumentasi mengurangi sengketa “ongkir tidak jelas” dan mendukung profesionalitas layanan.

---

## 6. Alasan Fitur Ini Meningkatkan User Experience

1. **Predictable cost**: User tahu total yang harus dibayar (produk + ongkir) sebelum checkout, sehingga keputusan belanja lebih informatif.  
2. **Fair pricing**: Ongkir mengikuti jarak, bukan angka sembarang; terasa adil dan mudah dipahami.  
3. **Familiar flow**: Alur status (Confirmed → Picked Up → On Delivery → Delivered) mirip aplikasi ojek online yang sudah biasa digunakan, sehingga user cepat memahami.  
4. **Less friction**: Satu input (alamat) menghasilkan jarak dan ongkir; tidak perlu langkah tambahan atau komunikasi manual untuk “tanya ongkir”.  
5. **Trust**: Transparansi perhitungan dan status yang jelas membangun kepercayaan terhadap toko dan sistem.

---

## 7. Ringkasan Implementasi di Proyek

- **Redirect login**: Admin → `/admin` (dashboard Filament); User → halaman utama.  
- **Konfigurasi**: `config/delivery.php` — koordinat toko, tarif per km (Rp3.000), pilihan driver (Nominatim/Google).  
- **Layanan**: `ShippingService` — geocoding alamat, perhitungan jarak (Haversine), perhitungan biaya ongkir.  
- **Endpoint**: `POST /shipping/calculate` — input alamat; output jarak (km), biaya ongkir, koordinat (untuk disimpan di order).  
- **Order**: Kolom `distance_km`, `shipping_cost`, `shipping_lat`, `shipping_lng`; status mengikuti enum Pending, Confirmed, Picked Up, On Delivery, Delivered, Cancelled.  
- **Admin**: Di resource Order, admin mengubah status dan melihat jarak serta ongkir; alur pengiriman mengikuti status di atas.

Dengan demikian, fitur Order Status & Pengantaran tidak hanya memenuhi ketentuan teknis (biaya per jarak, peta, alur, status), tetapi juga dijelaskan secara konseptual untuk laporan akademik: cara kerja perhitungan jarak, integrasi API Maps, manfaat bagi user dan sistem, serta alasan peningkatan user experience.
