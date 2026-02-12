# Filter Produk, Manajemen Kategori, dan Algoritma Rekomendasi Berbasis Perilaku User (B2C Concept)

## Dokumentasi untuk Laporan Akademik

---

## Daftar Isi

1. [Manajemen Kategori](#1-manajemen-kategori-admin---filament)
2. [Filter Produk](#2-filter-produk-user-side)
3. [Algoritma Rekomendasi Berbasis Perilaku User](#3-algoritma-rekomendasi-berbasis-perilaku-user)
4. [Implementasi Konsep B2C](#4-implementasi-konsep-b2c)
5. [Ringkasan Dampak Fitur](#5-ringkasan-dampak-fitur)

---

## 1. MANAJEMEN KATEGORI (ADMIN - FILAMENT)

### 1.1 Tujuan Fitur

- **Segmentasi pasar** — Produk dikelompokkan berdasarkan kategori agar memudahkan segmentasi dan analisis.
- **Navigasi terstruktur** — User dapat menjelajahi produk berdasarkan kebutuhan (contoh: Bayi, Elektronik).
- **Manajemen konten** — Admin dapat mengatur hierarki dan pengelompokan produk secara terpusat.

### 1.2 Cara Kerja Sistem

- Admin mengakses panel **Filament** → menu **Kategori**.
- Admin dapat **membuat** kategori baru (nama, slug, deskripsi).
- Admin dapat **mengedit** dan **menghapus** kategori.
- Setiap **produk wajib memiliki 1 kategori** (relasi one-to-many).
- Kategori tidak dapat dihapus jika masih memiliki produk (harus pindahkan produk terlebih dahulu).

**Contoh kategori default:**

| Kategori             | Deskripsi                  |
|----------------------|----------------------------|
| Bayi                 | Produk kebutuhan bayi      |
| Makanan & Minuman    | Makanan dan minuman        |
| Elektronik           | Perangkat elektronik       |
| Kesehatan            | Produk kesehatan           |
| Fashion              | Pakaian dan aksesoris      |
| Lainnya              | Kategori lainnya           |

### 1.3 Dampak terhadap User Experience

- User dapat melihat produk dalam kategori tertentu (misalnya hanya "Bayi").
- Pencarian dan penelusuran produk menjadi lebih terarah.
- Pengalaman belanja lebih terstruktur dan mudah dipahami.

### 1.4 Dampak terhadap Peningkatan Penjualan

- Produk lebih mudah ditemukan → **tingkat konversi lebih tinggi**.
- Segmentasi pasar memungkinkan pemasaran yang lebih tepat sasaran.
- Pengelolaan stok dan katalog produk menjadi lebih efisien.

---

## 2. FILTER PRODUK (USER SIDE)

### 2.1 Tujuan Fitur

- **Memudahkan navigasi** — User tidak perlu scroll panjang untuk menemukan produk yang sesuai.
- **Mengurangi informasi berlebihan** — Hasil produk disesuaikan dengan preferensi user.
- **Mendukung keputusan pembelian** — User dapat membandingkan produk dalam rentang kriteria tertentu.

### 2.2 Cara Kerja Sistem

Filter yang tersedia:

| Filter         | Deskripsi                                                |
|----------------|----------------------------------------------------------|
| **Kategori**   | Menampilkan hanya produk dalam kategori tertentu         |
| **Harga Min**  | Produk dengan harga ≥ nilai yang diinput                 |
| **Harga Max**  | Produk dengan harga ≤ nilai yang diinput                 |
| **Sort**       | Terbaru, Terpopuler, Rating Tertinggi, Harga Terendah/Tertinggi |

**Karakteristik filter:**

- Filter dapat **dikombinasikan** (misal: Kategori Bayi + Harga Rp 10.000–50.000).
- Hasil berubah **secara dinamis** sesuai parameter yang dipilih.
- URL menyimpan parameter filter sehingga dapat dibagikan atau di-bookmark.

**Contoh penggunaan:**

- User memilih kategori "Bayi" → muncul hanya produk bayi.
- User menambah filter harga min 10.000 dan max 50.000 → muncul produk bayi dengan harga dalam rentang tersebut.
- User memilih sort "Terpopuler" → produk diurutkan berdasarkan jumlah penjualan.

### 2.3 Manfaat Filter terhadap Kemudahan Navigasi User

1. **Penghematan waktu** — User tidak perlu menelusuri seluruh katalog.
2. **Fokus pada kebutuhan** — Produk yang relevan muncul lebih dulu.
3. **Transparansi** — User memahami cara hasil produk ditampilkan.
4. **Kemudahan perbandingan** — Filter harga dan rating membantu perbandingan produk.

### 2.4 Dampak terhadap User Experience

- Proses pencarian produk menjadi lebih cepat dan nyaman.
- Tingkat kepuasan user meningkat karena hasil sesuai ekspektasi.
- Penggunaan filter yang intuitif mengurangi rasa kewalahan saat melihat banyak produk.

### 2.5 Dampak terhadap Peningkatan Penjualan

- User menemukan produk yang sesuai lebih cepat → **peluang pembelian meningkat**.
- Filter harga membantu user dengan budget tertentu → **konversi lebih tinggi**.
- Sort "Terpopuler" dan "Rating" mendorong kepercayaan terhadap produk pilihan.

---

## 3. ALGORITMA REKOMENDASI BERBASIS PERILAKU USER

### 3.1 Tujuan Fitur

- **Personalisasi** — Setiap user mendapat rekomendasi yang berbeda berdasarkan perilakunya.
- **Meningkatkan discovery produk** — Produk relevan tampil tanpa user harus mencari manual.
- **Mendukung konsep B2C** — Fokus pada kebutuhan individu konsumen.

### 3.2 Data yang Dicatat Sistem

| Data                    | Sumber                            | Kegunaan                                        |
|-------------------------|-----------------------------------|-------------------------------------------------|
| Produk yang dilihat     | `product_views` (per user/session)| Most viewed products                            |
| Kategori yang dibeli    | Order items selesai               | Frequently bought category                      |
| Produk di wishlist      | Tabel `wishlists`                 | Kategori minat user                             |
| Rating & penjualan      | Reviews, Order items              | Popular products dalam kategori                 |

**Catatan:** Algoritma **tidak hanya** berdasarkan harga murah/mahal. Kombinasi rating, penjualan, dan perilaku user digunakan untuk prioritas rekomendasi.

### 3.3 Cara Kerja Algoritma

Sistem menggabungkan beberapa sumber rekomendasi dengan prioritas skor:

1. **Most Viewed Products** (skor tertinggi)  
   - Produk yang sering dilihat user dalam 30 hari terakhir.  
   - Menggambarkan minat eksplisit user.

2. **Frequently Bought Category**  
   - Kategori yang sering dibeli user (dari order selesai).  
   - Menampilkan produk populer dalam kategori tersebut.

3. **Wishlist Category**  
   - Kategori dari produk yang ada di wishlist.  
   - Menunjukkan kategori yang diminati user.

4. **Related Products**  
   - Produk dalam kategori yang sama dengan produk sedang dilihat.  
   - Diurutkan berdasarkan rating dan relevansi kategori.

5. **Popular Products**  
   - Produk dengan rating tinggi dan penjualan banyak.  
   - Fallback ketika data perilaku user belum cukup.

**Contoh kasus:**

- User sering melihat/membeli produk kategori "Bayi" (susu bayi).  
- Sistem menampilkan: produk lain kategori Bayi, popok, botol susu, vitamin bayi, dan produk rating tinggi dalam kategori Bayi.  
- Rekomendasi tidak didasarkan hanya pada harga murah/mahal, melainkan kombinasi perilaku dan popularitas.

### 3.4 Dampak terhadap User Experience

- User merasa produk yang ditampilkan sesuai kebutuhan dan minat.
- Waktu pencarian berkurang karena rekomendasi muncul di halaman produk dan beranda.
- Pengalaman belanja lebih personal dan responsif terhadap perilaku.

### 3.5 Dampak terhadap Peningkatan Penjualan

- **Cross-selling** — Produk terkait dan dalam kategori yang sama lebih mudah ditemukan.
- **Upselling** — Produk populer dan rating tinggi mendorong pembelian tambahan.
- **Retensi** — User yang merasa dipahami cenderung kembali menggunakan platform.
- **Konversi** — Rekomendasi yang tepat meningkatkan peluang pembelian.

---

## 4. IMPLEMENTASI KONSEP B2C (BUSINESS TO CUSTOMER)

### 4.1 Konsep B2C

B2C adalah model bisnis di mana bisnis menjual produk/jasa **langsung ke konsumen akhir**. Fitur yang diimplementasikan mendukung konsep ini dengan fokus pada pengalaman individu.

### 4.2 Dukungan Fitur terhadap B2C

| Aspek B2C              | Dukungan Fitur                                                        |
|------------------------|-----------------------------------------------------------------------|
| **Personalisasi**      | Rekomendasi berdasarkan perilaku (lihat, beli, wishlist)              |
| **Kenyamanan user**    | Filter dan kategori memudahkan pencarian tanpa bantuan staf           |
| **Kebutuhan individu** | Produk ditampilkan sesuai kategori, harga, dan minat per user         |
| **Responsif**          | Sistem menyesuaikan tampilan berdasarkan riwayat dan preferensi       |
| **Konversi**           | Navigasi cepat dan rekomendasi tepat meningkatkan peluang pembelian   |

### 4.3 Manfaat dalam Konteks B2C

1. **Personalisasi meningkatkan kenyamanan user**  
   Setiap user melihat rekomendasi yang sesuai minat dan riwayat belanja.

2. **Produk ditampilkan sesuai kebutuhan individu**  
   Kategori, filter, dan rekomendasi membantu user menemukan produk yang tepat.

3. **Sistem lebih responsif terhadap perilaku konsumen**  
   Data penayangan, pembelian, dan wishlist digunakan untuk memperbarui rekomendasi.

4. **Meningkatkan peluang konversi pembelian**  
   Kombinasi filter, kategori, dan rekomendasi mendorong user dari browsing ke pembelian.

---

## 5. RINGKASAN DAMPAK FITUR

| Fitur                  | Tujuan Utama              | Cara Kerja Singkat                          | Dampak UX                 | Dampak Penjualan                |
|------------------------|---------------------------|---------------------------------------------|---------------------------|---------------------------------|
| Manajemen Kategori     | Segmentasi & navigasi     | CRUD kategori di Admin, produk punya 1 kategori | Pencarian lebih terarah   | Konversi dan efisiensi katalog  |
| Filter Produk          | Memudahkan pencarian      | Filter kategori, harga, sort dinamis        | Navigasi cepat, fokus     | Peluang pembelian meningkat     |
| Rekomendasi Perilaku   | Personalisasi B2C         | Gabungan view, beli, wishlist, popularitas  | Pengalaman personal       | Cross-sell, retensi, konversi   |

---

## 6. STRUKTUR TEKNIS (Referensi Implementasi)

- **Model:** `Category`, `Product` (dengan `category_id`), `ProductView`
- **Tabel:** `categories`, `products` (category_id), `product_views`
- **Layanan:** `RecommendationService` — mengimplementasikan logika rekomendasi
- **Controller:** `ProductController` — filter, tracking view, rekomendasi
- **Views:** `products.index` (filter UI), `products.show` (related + rekomendasi), `home` (rekomendasi)

---

*Dokumen ini disusun untuk keperluan laporan akademik.*
