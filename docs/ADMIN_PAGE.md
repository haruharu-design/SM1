# Admin Page — Konsep dan Implementasi

Dokumen ini menjelaskan konsep Admin Page secara akademis dengan penekanan pada pemahaman fungsional dan manfaat sistem, diikuti ringkasan implementasi teknis.

---

## 1. Konsep Dasar Admin Page

**Admin Page** (halaman administrasi) adalah antarmuka khusus yang hanya dapat diakses oleh pengguna dengan peran *administrator*. Fungsinya adalah mengelola seluruh aspek operasional aplikasi dari satu tempat, tanpa mengubah tampilan yang dilihat pengguna biasa (front-end tetap sama).

Dalam konteks toko online, admin bertindak sebagai *single point of control* untuk:
- **Data pengguna** — siapa yang boleh menggunakan sistem dan dalam kondisi apa
- **Katalog produk** — apa yang dijual, harga, dan ketersediaan
- **Transaksi** — order, pembayaran, dan status pengiriman
- **Promosi** — kupon dan aturan diskon
- **Pemantauan** — ringkasan bisnis (jumlah user, order, pendapatan) untuk pengambilan keputusan

Dengan demikian, Admin Page bukan sekadar “halaman tambahan”, melainkan **lapisan pengelolaan (management layer)** yang memisahkan tanggung jawab: pengguna berinteraksi dengan toko, admin mengelola toko.

---

## 2. Manajemen User (Lihat, Edit, Suspend)

### 2.1 Konsep

**Manajemen user** adalah kemampuan admin untuk melihat, mengubah data, dan mengendalikan status akses pengguna.

- **Lihat**: Admin dapat melihat daftar user beserta data profil (nama, email, peran, status) untuk keperluan verifikasi, dukungan, atau audit.
- **Edit**: Admin dapat memperbaiki data user (misalnya perbaikan nama/email) atau mengubah peran (misalnya menaikkan user menjadi admin) sesuai kebijakan organisasi.
- **Suspend**: Admin dapat menonaktifkan sementara akun user tanpa menghapus datanya. User yang di-suspend tidak dapat login sampai status dicabut. Ini berguna untuk menangani pelanggaran aturan, investigasi, atau permintaan user sendiri.

**Manfaat bagi sistem**: Kontrol akses yang terpusat, kepatuhan terhadap kebijakan, dan kemampuan menangani insiden tanpa kehilangan riwayat data.

### 2.2 Implementasi (Ringkasan Teknis)

- Tabel `users` memiliki kolom `suspended_at` (timestamp nullable). Jika terisi, user dianggap tersuspend.
- Middleware atau pengecekan di login: jika `suspended_at` tidak null, login ditolak.
- Di Filament Admin Panel: Resource **User** dengan aksi View, Edit, dan aksi kustom “Suspend”/“Unsuspend” yang mengisi atau mengosongkan `suspended_at`.

---

## 3. Manajemen Produk (CRUD)

### 3.1 Konsep

**CRUD** (Create, Read, Update, Delete) pada produk berarti admin dapat:
- **Create**: Menambah produk baru (nama, deskripsi, harga, stok, gambar, dll.) ke katalog.
- **Read**: Melihat daftar dan detail produk untuk memastikan data benar dan stok terkini.
- **Update**: Mengubah informasi produk (harga, stok, deskripsi) atau menonaktifkan sementara tanpa menghapus.
- **Delete**: Menghapus produk dari katalog bila sudah tidak dijual (dengan pertimbangan riwayat order yang mungkin mereferensi produk).

Ini adalah inti dari **manajemen katalog**: katalog yang rapi dan terkini meningkatkan kepercayaan pembeli dan memudahkan operasional.

**Manfaat bagi sistem**: Satu sumber kebenaran untuk data produk; perubahan harga dan stok langsung tercermin di front-end.

### 3.2 Implementasi (Ringkasan Teknis)

- Tabel `products` (nama, slug, deskripsi, harga, stok, gambar, is_active, dll.).
- Filament Resource **Product** dengan form Create/Edit dan tabel list; aksi Delete dengan konfirmasi. Front-end (Home, Product) tetap memakai data dari tabel ini tanpa mengubah tampilan yang ada.

---

## 4. Manajemen Order

### 4.1 Konsep

**Manajemen order** memungkinkan admin melihat dan mengelola seluruh pesanan: siapa memesan apa, kapan, berapa total, dan status (pending, diproses, dikirim, selesai).

Admin dapat:
- Melihat daftar order dan filter berdasarkan status/tanggal.
- Mengubah status order (misalnya dari “pending” ke “processed” setelah pembayaran dikonfirmasi, lalu “shipped” setelah barang dikirim).
- Melihat detail item per order untuk keperluan picking, packing, dan koordinasi dengan logistik.

**Manfaat bagi sistem**: Alur order yang terpusat dan terdokumentasi; memudahkan pelaporan, retur, dan integrasi dengan pembayaran/pengiriman.

### 4.2 Implementasi (Ringkasan Teknis)

- Tabel `orders` (user_id, nomor_order, total, status, alamat_pengiriman, dll.) dan `order_items` (order_id, product_id, qty, harga_satuan).
- Filament Resource **Order** (list, view, edit status). Detail order menampilkan relasi ke `order_items` dan produk.

---

## 5. Manajemen Coupon

### 5.1 Konsep

**Kupon** adalah kode diskon yang dapat dipakai user saat checkout. Admin perlu mengelola:
- Pembuatan kupon (kode, jenis: persen atau nominal, nilai, masa berlaku, batas penggunaan).
- Melihat penggunaan kupon (berapa kali dipakai, oleh siapa) untuk evaluasi kampanye.
- Menonaktifkan atau mengubah kupon tanpa menghapus riwayat.

Ini mendukung strategi pemasaran (promo, loyalitas) sekaligus mengontrol risiko (batas penggunaan, expiry).

**Manfaat bagi sistem**: Promosi yang terukur dan terkontrol; data penggunaan untuk analisis efektivitas kampanye.

### 5.2 Implementasi (Ringkasan Teknis)

- Tabel `coupons` (kode, tipe, nilai, min_pembelian, max_penggunaan, digunakan, valid_from, valid_until, is_active).
- Filament Resource **Coupon** (CRUD). Validasi kupon dilakukan di sisi aplikasi saat checkout (opsional; lihat dokumen Optional Features).

---

## 6. Monitoring Transaksi dan Pembayaran

### 6.1 Konsep

**Monitoring transaksi dan pembayaran** berarti admin dapat memantau:
- Transaksi pembayaran per order (status: pending, paid, failed, refunded).
- Metode pembayaran, nominal, dan waktu transaksi.
- Rekonsiliasi antara order dan pembayaran untuk keperluan keuangan dan dukungan pelanggan.

Ini menjembatani **operasional** (order) dengan **keuangan** (uang masuk/keluar), sehingga admin dapat memastikan pembayaran yang masuk sesuai dengan order yang diproses.

**Manfaat bagi sistem**: Audit trail pembayaran, deteksi gagal bayar atau duplikasi, dan dasar untuk laporan pendapatan.

### 6.2 Implementasi (Ringkasan Teknis)

- Tabel `payments` (order_id, amount, method, status, reference_id, paid_at, dll.).
- Di Admin: Resource **Payment** atau halaman **Monitoring Transaksi** yang menampilkan daftar pembayaran dengan filter status/tanggal dan link ke order terkait.

---

## 7. Dashboard Ringkasan

### 7.1 Konsep

**Dashboard ringkasan** menyajikan metrik utama dalam satu layar:
- **Jumlah user** (total terdaftar, atau aktif dalam periode tertentu).
- **Jumlah order** (hari ini, minggu ini, atau total).
- **Pendapatan** (total atau dalam periode tertentu).

Tujuannya adalah **decision support**: admin dapat dengan cepat menilai kesehatan bisnis (pertumbuhan user, volume order, revenue) tanpa harus menjalankan query manual. Tampilan berupa kartu statistik (widget) atau grafik sederhana.

**Manfaat bagi sistem**: Fokus pada indikator kunci; mendukung perencanaan stok, promosi, dan kapasitas layanan.

### 7.2 Implementasi (Ringkasan Teknis)

- Di Filament Admin: **Widgets** di Dashboard—misalnya StatsOverviewWidget yang menampilkan:
  - Total User (count dari `users`)
  - Total Order (count dari `orders`)
  - Total Pendapatan (sum dari `payments` yang status paid, atau sum order total).
- Data dihitung dari model Eloquent (aggregasi). Tampilan front-end aplikasi tidak berubah.

---

## 8. Kesimpulan Konseptual

Admin Page merupakan **pusat kendali** untuk:
1. **User** — siapa yang boleh akses dan dalam kondisi apa (lihat, edit, suspend).
2. **Produk** — apa yang dijual dan datanya selalu terkini (CRUD).
3. **Order** — alur pesanan dari masuk sampai selesai (manajemen order).
4. **Coupon** — promosi yang terukur dan terkontrol (manajemen kupon).
5. **Transaksi & pembayaran** — pemantauan untuk keuangan dan audit.
6. **Dashboard** — ringkasan jumlah user, order, dan pendapatan untuk keputusan cepat.

Implementasi teknis (Filament, tabel, resource) mengikuti konsep di atas tanpa mengubah tampilan yang dilihat pengguna di halaman Login, Signup, Home, About, Product, Contact, dan Profile.
