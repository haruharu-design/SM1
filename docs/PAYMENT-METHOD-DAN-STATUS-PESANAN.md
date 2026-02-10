# Payment Method dan Otomatisasi Status Pesanan

## Dokumentasi untuk Laporan Akademik

---

## 1. METODE PEMBAYARAN

### A. Cash On Delivery (COD)

**Definisi:** Pembayaran dilakukan secara tunai saat barang diterima oleh pembeli.

**Alur:**
1. User memilih metode COD saat checkout
2. User menyelesaikan checkout
3. Status pembayaran: **Pending**
4. Status pesanan langsung: **Diproses** (menunggu pengiriman)
5. Pembayaran dilakukan saat kurir menyerahkan barang

**Karakteristik:**
- Tidak memerlukan transfer terlebih dahulu
- Pembeli bayar di tempat
- Risiko tertunda bayar minim bagi penjual (barang sudah diterima)

### B. Transfer Bank

**Definisi:** Pembayaran dilakukan dengan transfer ke rekening bank toko sebelum pengiriman.

**Alur:**
1. User memilih metode Transfer Bank saat checkout
2. User memilih bank tujuan (BCA, BNI, Mandiri, dll)
3. Sistem menampilkan nomor rekening dan nama pemilik rekening
4. User melakukan transfer ke rekening tersebut
5. Status pembayaran: **Menunggu Konfirmasi**
6. Admin memverifikasi transfer dan mengonfirmasi pembayaran
7. Status pembayaran: **Terkonfirmasi**
8. Status pesanan otomatis berubah menjadi **Diproses** (dalam beberapa detik)

**Karakteristik:**
- Membutuhkan konfirmasi manual oleh admin
- User harus menunggu verifikasi sebelum pesanan diproses

### Perbandingan COD vs Transfer Bank

| Aspek | COD | Transfer Bank |
|-------|-----|---------------|
| Waktu pembayaran | Saat barang diterima | Sebelum pengiriman |
| Konfirmasi | Tidak perlu | Admin verifikasi |
| Status awal order | Langsung Diproses | Menunggu Pembayaran |
| Risiko | Penjual menunggu sampai diterima | Pembeli transfer dulu |

---

## 2. STATUS PEMBAYARAN

| Status | Keterangan |
|--------|------------|
| **Pending** | Menunggu (untuk COD: bayar saat terima) |
| **Menunggu Konfirmasi** | Transfer sudah dilakukan, menunggu verifikasi admin |
| **Terkonfirmasi** | Pembayaran sudah diverifikasi admin |
| **Gagal** | Pembayaran gagal / dibatalkan |

---

## 3. OTOMATISASI STATUS PESANAN

### Konsep

Setelah pembayaran **terkonfirmasi** (untuk Transfer Bank), sistem secara otomatis mengubah status pesanan menjadi **Diproses** tanpa input manual admin.

### Cara Kerja Teknis

- Menggunakan **Job Queue** (Laravel)
- Job `ProcessOrderAfterPaymentConfirmed` dijalankan dengan **delay 5 detik** setelah admin mengonfirmasi pembayaran
- Job mengupdate field `status` pesanan menjadi `diproses`

### Alur Otomatisasi

1. User memilih payment method (COD atau Transfer Bank)
2. User menyelesaikan checkout
3. **Untuk Transfer Bank:** User transfer → Admin konfirmasi pembayaran
4. Sistem menjalankan job (delay 5 detik)
5. Status pesanan otomatis berubah ke **Diproses**

### Manfaat Otomatisasi

**Bagi Admin:**
- Tidak perlu mengubah status pesanan secara manual setelah konfirmasi
- Mengurangi langkah kerja
- Konsistensi status terjamin

**Bagi User:**
- Status pesanan terupdate otomatis
- Transparansi alur pemesanan

**Bagi Sistem:**
- Alur bisnis konsisten
- Mengurangi human error

---

## 4. STATUS PESANAN

| Status | Keterangan |
|--------|------------|
| **Menunggu Pembayaran** | Order baru, belum bayar (Transfer Bank) |
| **Diproses** | Pembayaran OK, pesanan sedang dipersiapkan |
| **Dikirim** | Pesanan sudah dikirim |
| **Selesai** | Pesanan diterima / selesai |
| **Dibatalkan** | Pesanan dibatalkan |

---

## 5. DAMPAK TERHADAP EFISIENSI SISTEM

1. **Alur jelas**: Setiap metode punya alur yang terdefinisi
2. **Otomatisasi mengurangi beban admin**: Status Diproses terisi otomatis
3. **User mendapat kepastian**: Status transparan di setiap tahap
4. **Skalabilitas**: Sistem siap menangani banyak order dengan alur yang sama

---

*Dokumen ini disusun untuk keperluan laporan akademik.*
