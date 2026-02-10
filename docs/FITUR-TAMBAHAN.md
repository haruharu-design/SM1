# Penjelasan Fitur Tambahan (Optional Features)

## Dokumentasi untuk Laporan Akademik

---

## 1. FITUR ULASAN (REVIEW & RATING)

### Tujuan Fitur
Memungkinkan pengguna yang telah membeli produk untuk memberikan ulasan dan rating (1–5 bintang) sebagai bentuk feedback terhadap kualitas produk.

### Cara Kerja
- User hanya dapat memberi ulasan setelah melakukan pembelian produk tersebut
- Rating berbentuk bintang (1–5)
- Ulasan baru disimpan dengan status `is_visible = false` (menunggu moderasi)
- Admin dapat menyetujui (approve) atau menghapus ulasan melalui menu **More Settings → Ulasan**
- Ulasan yang disetujui ditampilkan di halaman detail produk

### Manfaat bagi User
- **Kepercayaan sebelum membeli**: User dapat membaca pengalaman pembeli lain sehingga lebih yakin sebelum memutuskan membeli
- Mengurangi ketidakpastian terhadap kualitas produk

### Manfaat bagi Sistem
- **Feedback kualitas produk**: Ulasan memberikan data tentang kepuasan pelanggan
- Dapat digunakan untuk perbaikan produk atau layanan
- Meningkatkan kredibilitas toko

### Dampak terhadap UX
- Meningkatkan transparansi dan kepercayaan
- Membantu pengambilan keputusan pembelian yang lebih informatif

---

## 2. FITUR Q&A (TANYA JAWAB DENGAN ADMIN)

### Tujuan Fitur
Memungkinkan user mengajukan pertanyaan tentang produk sebelum membeli, dan admin menjawab untuk memberikan informasi tambahan.

### Cara Kerja
- User dapat mengajukan pertanyaan di halaman detail produk (bagian deskripsi)
- Pertanyaan disimpan dan ditampilkan di halaman produk
- Hanya admin yang dapat menjawab melalui menu **More Settings → Tanya Jawab Produk**
- Setelah dijawab, pertanyaan dan jawaban ditampilkan bersama di halaman produk

### Manfaat bagi User
- Mendapatkan informasi spesifik sebelum membeli
- Mengurangi keraguan yang tidak terjawab oleh deskripsi produk

### Dampak terhadap UX
- Meningkatkan kepuasan dengan layanan responsif
- Membantu user yang membutuhkan klarifikasi tambahan

---

## 3. FITUR WISHLIST (ICON LOVE ❤️)

### Tujuan Fitur
Memungkinkan user menyimpan produk favorit ke daftar wishlist untuk referensi di kemudian hari.

### Cara Kerja
- User dapat menambah/menghapus produk dari wishlist dengan ikon ❤️ (love) pada kartu produk
- Wishlist disimpan di akun user (database)
- Halaman **Wishlist** menampilkan semua produk yang disimpan
- Berbeda dengan keranjang: wishlist untuk favorit, keranjang untuk proses pembelian

### Perbedaan Wishlist vs Keranjang

| Aspek | Wishlist | Keranjang |
|-------|----------|-----------|
| Fungsi | Menyimpan produk favorit | Untuk proses pembelian |
| Penyimpanan | Database (permanen) | Session (sementara) |
| Tujuan | Referensi/preferensi | Checkout |

### Manfaat bagi User
- Menyimpan produk yang ingin dibeli nanti tanpa harus mengingat
- Dapat digunakan sebagai data preferensi user

### Dampak terhadap UX
- Meningkatkan engagement dan retensi
- Memudahkan user dalam mengelola minat belanja

---

## 4. FITUR PENGIRIMAN (DUMMY / RANDOMIZED COST)

### Tujuan Fitur
Menjadi alternatif ketika API Maps (Nominatim/Google) gagal atau tidak tersedia, sehingga proses checkout tetap dapat berjalan.

### Cara Kerja
- Jika geocoding gagal (alamat tidak ditemukan atau API error), sistem menggunakan **biaya acak** dari daftar: Rp10.000, Rp15.000, atau Rp20.000
- Biaya dipilih secara acak saat checkout
- Total pembayaran tetap dihitung: Subtotal + Biaya Pengiriman (dummy)
- Tetap ditambahkan ke total pembayaran seperti pengiriman normal

### Konteks Simulasi
Fitur ini bersifat **simulasi** namun tetap mencerminkan konsep pengiriman berbasis jarak:
- Dalam kondisi normal, biaya dihitung dari jarak × Rp3.000/km
- Saat API tidak tersedia, dummy cost menggantikan perhitungan aktual
- Konsep "biaya pengiriman sebagai komponen total" tetap konsisten

### Manfaat
- Memastikan aplikasi tetap berjalan meskipun API Maps bermasalah
- User tetap dapat menyelesaikan checkout

---

## 5. FITUR REVEAL PASSWORD (SHOW / HIDE PASSWORD)

### Tujuan Fitur
Meningkatkan usability pada halaman Login dan Signup dengan opsi menampilkan atau menyembunyikan password.

### Cara Kerja
- Tombol ikon mata (👁️) di sebelah field password
- Klik tombol untuk mengalihkan antara mode tampilkan (text) dan sembunyikan (password)
- Berlaku pada field Password dan Konfirmasi Password di halaman Signup
- Berlaku pada field Password di halaman Login

### Manfaat bagi User
- Memastikan password diketik dengan benar sebelum submit
- Mengurangi kesalahan input yang sering terjadi karena password tersembunyi
- Aksesibilitas lebih baik bagi pengguna

### Dampak terhadap UX
- Mengurangi frustrasi saat salah ketik password
- Meningkatkan kepercayaan user saat mendaftar (konfirmasi password terlihat)

---

## Ringkasan Tabel

| Fitur | Tujuan | Manfaat User | Manfaat Sistem |
|-------|--------|--------------|----------------|
| Review & Rating | Feedback pascapembelian | Kepercayaan sebelum beli | Data kualitas produk |
| Q&A | Informasi sebelum beli | Jawaban spesifik | Layanan responsif |
| Wishlist | Simpan favorit | Preferensi tersimpan | Data preferensi, engagement |
| Dummy Shipping | Fallback saat API gagal | Checkout tetap jalan | Resiliency |
| Reveal Password | Lihat password saat ketik | Kurangi kesalahan input | Usability |

---

*Dokumen ini disusun untuk keperluan laporan akademik dan dokumentasi fitur.*
