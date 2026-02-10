# Optional Features — Fitur Tambahan Pendukung Interaksi User

Dokumen ini menjelaskan fitur-fitur tambahan sebagai **pendukung interaksi user** dengan penekanan pada: **fungsi**, **alur kerja**, **manfaat bagi user**, dan **manfaat bagi sistem**. Penjelasan bersifat konseptual dan akademis; rincian teknis disebutkan hanya seperlunya.

---

## 1. Wishlist

### Fungsi
Wishlist adalah daftar produk yang disimpan user untuk dilihat atau dibeli nanti, **tanpa** memasukkannya ke keranjang belanja (cart).

### Perbedaan dengan Keranjang (Cart)
| Aspek | Keranjang (Cart) | Wishlist |
|-------|------------------|----------|
| **Tujuan** | Produk yang **siap dibeli** (checkout) | Produk yang **ingin diingat** untuk nanti |
| **Komitmen** | User berniat membayar dalam waktu dekat | User hanya menyimpan referensi, belum tentu beli |
| **Alur** | Cart → Checkout → Order | Browse → Simpan ke Wishlist → (opsional) Pindah ke Cart / Checkout |
| **Kapasitas** | Biasanya dibatasi oleh stok/kuota | Daftar “ingin punya”, bisa banyak item |

Dengan kata lain: **keranjang = niat beli sekarang; wishlist = simpan dulu, putuskan nanti**. Wishlist juga bisa dipakai sistem untuk personalisasi (produk yang “disukai” atau sering dilihat).

### Alur Kerja
1. User melihat produk → klik “Tambah ke Wishlist”.
2. Sistem menyimpan relasi user–produk di tabel wishlist.
3. User dapat melihat halaman “Wishlist” berisi daftar produk tersimpan.
4. Dari wishlist, user dapat menghapus item atau “Pindah ke Keranjang” untuk checkout.

### Manfaat bagi User
- Tidak kehilangan referensi produk yang menarik.
- Bisa membandingkan dan memutuskan beli nanti tanpa memenuhi cart.
- Pengalaman lebih terstruktur (daftar keinginan vs daftar belanja).

### Manfaat bagi Sistem
- Sinyal preferensi user: produk di wishlist bisa dipakai untuk **rekomendasi** dan **filter personalisasi** (produk serupa, sering dilihat/disukai).
- Metrik “produk paling di-wishlist” untuk analisis demand dan penempatan promosi.

---

## 2. Coupon

### Fungsi
Coupon (kode kupon) memungkinkan user mendapat potongan harga (diskon persen atau nominal) saat checkout jika memenuhi syarat (minimal belanja, masa berlaku, batas penggunaan).

### Skenario Penggunaan (Walaupun Opsional)
- **Promo periode**: Kupon “HARIINI10” diskon 10% untuk pembelian di hari tertentu.
- **Loyalitas**: Kupon “MEMBER20” untuk user yang sudah pernah belanja.
- **Kampanye pemasaran**: Kupon “NEWUSER” untuk registrasi baru; “FLASHSALE” untuk jam tertentu.
- **Kerjasama**: Kupon dari influencer atau partner dengan kode unik untuk tracking.

User memasukkan kode di halaman checkout; sistem memvalidasi (berlaku, minimal belanja, kuota) lalu mengaplikasikan diskon ke total. Admin mengelola kupon di Admin Page (lihat dokumen Admin Page).

### Alur Kerja
1. Admin membuat kupon (kode, tipe, nilai, syarat, masa berlaku).
2. User saat checkout memasukkan kode kupon.
3. Sistem memvalidasi: kode valid, belum kadaluarsa, min belanja terpenuhi, kuota masih ada.
4. Jika valid, total order dikurangi; jika tidak, pesan error ditampilkan.
5. Setelah dipakai, penggunaan kupon tercatat (untuk batas penggunaan dan analisis).

### Manfaat bagi User
- Harga lebih murah; rasa dapat penawaran khusus.
- Mendorong konversi (beli sekarang karena ada diskon).

### Manfaat bagi Sistem
- Pemasaran terukur (berapa order memakai kupon tertentu).
- Kontrol margin (min belanja, batas penggunaan) dan evaluasi efektivitas kampanye.

---

## 3. Notification (Email / In-App / Push)

### Fungsi
Notifikasi mengirimkan informasi penting ke user melalui **email**, **in-app** (pesan di dalam aplikasi), atau **push notification** (perangkat), agar user tetap terinformasi tanpa harus selalu membuka aplikasi.

### Alur Kerja
- **Email**: Sistem mengirim email saat event tertentu (order dikonfirmasi, pengiriman, reset password).
- **In-app**: Pesan disimpan di database dan ditampilkan di area “Notifikasi” atau bell icon di aplikasi; user bisa menandai dibaca.
- **Push**: Integrasi dengan layanan push (FCM, OneSignal, dll.); user menerima notifikasi di perangkat saat ada event (order dikirim, promo).

Pilihan channel (email / in-app / push) bisa dikonfigurasi per jenis event atau preferensi user.

### Manfaat bagi User
- Tidak ketinggalan informasi (status order, pengiriman, promo).
- Transparansi dan kepercayaan (konfirmasi pembayaran, resi).

### Manfaat bagi Sistem
- Mengurangi support (“order saya sampai mana?”) karena user sudah dapat update.
- Re-engagement (promo, restok) dan peningkatan konversi.

---

## 4. Payment Gateway (Integrasi Pembayaran)

### Fungsi
Payment gateway adalah layanan pihak ketiga yang menangani **otorisasi dan penyelesaian pembayaran** (kartu, transfer virtual, e-wallet). Aplikasi tidak menyimpan nomor kartu; hanya mengirim permintaan pembayaran dan menerima konfirmasi sukses/gagal.

### Alur Kerja
1. User memilih metode pembayaran di checkout (misalnya transfer virtual / e-wallet).
2. Aplikasi memanggil API payment gateway: buat transaksi dengan nominal, order_id, callback URL.
3. User diarahkan ke halaman gateway (atau QR/instruksi transfer).
4. Setelah user bayar, gateway mengirim notifikasi (webhook) ke aplikasi.
5. Aplikasi memverifikasi signature, update status order dan payment menjadi “paid”, lalu trigger notifikasi ke user.

### Manfaat bagi User
- Pembayaran aman dan beragam (transfer, e-wallet, kartu).
- Konfirmasi otomatis; tidak perlu upload bukti manual (jika gateway mendukung verifikasi otomatis).

### Manfaat bagi Sistem
- Otomasi konfirmasi pembayaran; mengurangi input manual dan human error.
- Audit trail dari gateway; rekonsiliasi dengan laporan keuangan lebih mudah.

---

## 5. Rating & Review Produk

### Fungsi
User dapat memberi **rating** (skor, misalnya 1–5) dan **review** (ulasan teks) setelah membeli atau menggunakan produk. Data ini ditampilkan di halaman produk untuk calon pembeli lain.

### Alur Kerja
1. Setelah order selesai (delivered), user dapat mengisi rating dan review untuk tiap item.
2. Sistem menyimpan rating/review (user_id, product_id, order_id, rating, komentar, tanggal).
3. Di halaman produk: ditampilkan rata-rata rating dan daftar review (dengan moderasi jika perlu).
4. Rating/review dapat dipakai untuk **rekomendasi** (produk dengan rating tinggi, produk serupa berdasarkan ulasan).

### Manfaat bagi User
- Membantu keputusan belanja berdasarkan pengalaman pengguna lain.
- Umpan balik bagi penjual; rasa dihargai (suara didengar).

### Manfaat bagi Sistem
- Sinyal kualitas produk; mendukung algoritma rekomendasi (bukan hanya harga).
- Konten yang meningkatkan SEO dan kepercayaan toko.

---

## 6. Top Up Saldo

### Fungsi
User dapat **mengisi saldo** (top up) ke akun mereka. Saldo tersebut kemudian dapat dipakai untuk membayar order di dalam aplikasi (seperti e-wallet internal), sehingga checkout lebih cepat untuk pembelian berikutnya.

### Alur Kerja
1. User memilih “Top Up Saldo”, memasukkan nominal.
2. Sistem membuat transaksi top-up (pending) dan mengarahkan user ke payment gateway atau instruksi transfer.
3. Setelah pembayaran dikonfirmasi (webhook atau verifikasi manual), saldo user ditambah.
4. Saat checkout, user dapat memilih “Bayar dengan Saldo”; sistem mengurangi saldo sesuai total order dan mencatat penggunaan.

### Manfaat bagi User
- Pembayaran lebih cepat untuk transaksi berikutnya; tidak perlu input kartu/transfer setiap kali.
- Promo top up (misalnya bonus saldo) dapat mendorong isi ulang.

### Manfaat bagi Sistem
- Loyalitas dan retensi; saldo “mengunci” user untuk belanja lagi di platform.
- Arus kas lebih terprediksi jika banyak user top up di muka.

---

## 7. Filter Produk (Menuju Personalisasi)

### Fungsi
Filter memungkinkan user mempersempit daftar produk berdasarkan kriteria (kategori, harga, merek). Jika filter memanfaatkan **data user** (riwayat beli, preferensi, produk yang sering dilihat atau disukai), maka filter tersebut dapat berfungsi sebagai **personalisasi**: menampilkan produk yang lebih relevan untuk user tersebut.

### Konsep: Filter vs Personalisasi
- **Filter biasa**: Kriteria umum (kategori, harga) yang sama untuk semua user. User memilih filter secara eksplisit.
- **Filter berbasis data user (personalisasi)**: Sistem menyimpan riwayat pembelian, preferensi (kategori favorit, wishlist), atau produk yang sering dilihat; lalu menawarkan “Produk untuk Anda” atau memprioritaskan hasil yang sesuai profil user. Filter ini **reaktif terhadap perilaku user**.

Dengan demikian, **filter dapat menjadi personalisasi** ketika:
- Berdasarkan **riwayat pembelian** (misalnya “Lanjutkan dari kategori yang sering Anda beli”).
- Berdasarkan **preferensi user** (kategori/minat yang diset user atau disimpulkan dari wishlist/rating).
- Berdasarkan **produk yang sering dilihat atau disukai** (view count per user, wishlist).

Implementasi bisa berupa: filter “Rekomendasi untuk Anda” yang memakai data di atas, atau pengurutan/penyaringan hasil pencarian berdasarkan relevansi personal.

### Alur Kerja
1. Sistem merekam perilaku: pembelian, view produk, wishlist, rating.
2. Untuk setiap user (atau anonim sampai login), sistem membangun profil preferensi atau vektor “produk serupa”.
3. Di halaman produk atau hasil pencarian: selain filter eksplisit (kategori, harga), ditampilkan blok “Untuk Anda” atau hasil yang di-rank berdasarkan relevansi personal.
4. User dapat tetap memakai filter biasa; personalisasi menambah, tidak menggantikan.

### Manfaat bagi User
- Lebih cepat menemukan produk yang sesuai minat; pengalaman lebih relevan.
- Discovery produk baru yang masih sesuai dengan pola belanja mereka.

### Manfaat bagi Sistem
- Meningkatkan konversi dan engagement; mengurangi kebingungan di katalog besar.
- Data perilaku berguna untuk rekomendasi dan inventory planning.

---

## 8. Rekomendasi Produk

### Fungsi
Sistem menampilkan **rekomendasi produk** yang relevan bagi user, bukan sekadar “termurah” atau “termahal”, melainkan berdasarkan **riwayat pembelian**, **rating**, **produk serupa**, dan **popularitas yang relevan dengan user**.

### Pendekatan Algoritma (Konseptual)
- **Riwayat pembelian**: “User yang beli A juga beli B” (collaborative / association); atau “Lanjutkan dari kategori yang sering Anda beli”.
- **Rating**: Produk dengan rating tinggi dan banyak ulasan di kategori yang relevan dengan user.
- **Produk serupa**: Berdasarkan atribut (kategori, merek, tag) atau embedding (jika ada); “Produk mirip dengan yang Anda lihat”.
- **Popularitas yang relevan**: Trending di kategori yang user minati, atau produk yang sering dibeli bersama dengan produk yang user beli/like.

Dengan demikian, rekomendasi **tidak hanya berdasarkan harga murah/mahal**, melainkan **relevansi**: apa yang cocok dengan perilaku dan preferensi user.

### Alur Kerja
1. Sistem mengumpulkan data: pembelian, view, wishlist, rating, kategori.
2. Untuk halaman “Rekomendasi” atau blok “Untuk Anda”: algoritma memilih produk (item-based, user-based, atau hybrid) dan meranking berdasarkan skor relevansi.
3. Hasil ditampilkan di Home, setelah detail produk, atau di checkout (“Lengkapi belanja Anda”).
4. Interaksi user (klik, beli) dipakai umpan balik untuk memperbaiki model (opsional, untuk tahap lanjut).

### Manfaat bagi User
- Menemukan produk yang benar-benar sesuai minat; tidak hanya daftar generic.
- Pengalaman lebih personal; rasa “toko mengerti saya”.

### Manfaat bagi Sistem
- Peningkatan penjualan (cross-sell, discovery); metrik engagement dan retention lebih baik.
- Pembeda dari toko yang hanya menampilkan “terlaris” atau “termurah” tanpa konteks user.

---

## 9. Order Status & Pengantaran

### Fungsi
User dan admin dapat memantau **status order** dari pembayaran sampai barang diterima. **Pengantaran** dilacak melalui integrasi dengan **API eksternal** layanan logistik (JNE, J&T, POS, dll.) untuk mendapatkan status pengiriman dan nomor resi secara otomatis.

### Status Order (Contoh)
- **Pending**: Order dibuat, menunggu pembayaran.
- **Processed**: Pembayaran dikonfirmasi; order diproses (picking, packing).
- **Shipped**: Barang sudah diserahkan ke kurir; nomor resi tercatat; pengiriman dalam perjalanan.
- **Delivered**: Barang sudah diterima oleh penerima (dikonfirmasi kurir atau user).

Status dapat diperluas (misalnya Cancelled, Returned) sesuai kebijakan bisnis.

### Penggunaan API Eksternal untuk Tracking
- Setelah order **Shipped**, sistem menyimpan **nomor resi** (awb) dan **kode layanan** (JNE, J&T, dll.).
- Aplikasi memanggil **API tracking** yang disediakan layanan logistik (REST): kirim nomor resi → dapat status terbaru (dipickup, in transit, delivered).
- Hasil tracking (deskripsi status, lokasi, estimasi) ditampilkan di halaman “Lacak Order” untuk user dan di Admin untuk monitoring.
- Pemanggilan API bisa periodik (cron) atau on-demand saat user membuka halaman lacak.

Dengan demikian, **status order** menggabungkan status internal (pending, processed, shipped) dengan **status pengiriman eksternal** dari API kurir, sehingga transparansi dan kepercayaan user meningkat.

### Alur Kerja
1. User checkout → order status **Pending**.
2. Pembayaran masuk → admin atau sistem ubah ke **Processed**.
3. Admin input resi dan pilih kurir → status **Shipped**; sistem bisa memanggil API kurir untuk tracking.
4. User melihat “Lacak Order” → sistem menampilkan status dari API (atau cache terakhir).
5. Ketika kurir menandai delivered (atau API mengembalikan status “delivered”) → status order **Delivered**; notifikasi ke user; opsi rating/review dibuka.

### Manfaat bagi User
- Kejelasan di mana order berada; mengurangi kecemasan dan pertanyaan ke CS.
- Pengalaman profesional dan transparan.

### Manfaat bagi Sistem
- Mengurangi beban customer service; otomasi update status melalui API.
- Data pengiriman untuk analisis on-time delivery dan pilihan kurir.

---

## 10. Ringkasan

| Fitur | Fungsi Singkat | Manfaat User | Manfaat Sistem |
|-------|----------------|--------------|-----------------|
| Wishlist | Simpan produk untuk nanti (beda dengan cart) | Referensi, putuskan beli nanti | Sinyal preferensi; rekomendasi |
| Coupon | Diskon saat checkout dengan kode | Harga lebih murah | Kampanye terukur, kontrol margin |
| Notification | Email / in-app / push | Tidak ketinggalan info | Kurangi support, re-engagement |
| Payment Gateway | Bayar via pihak ketiga | Aman, beragam metode | Konfirmasi otomatis, audit |
| Rating & Review | Nilai dan ulasan produk | Bantu keputusan belanja | Kualitas, rekomendasi, SEO |
| Top Up Saldo | Isi saldo, bayar pakai saldo | Checkout cepat | Retensi, arus kas |
| Filter (personalisasi) | Filter berdasarkan data user | Hasil lebih relevan | Konversi, engagement |
| Rekomendasi | Produk relevan (bukan hanya harga) | Discovery sesuai minat | Penjualan, diferensiasi |
| Order Status & Pengantaran | Status order + API tracking kurir | Lacak kiriman | Transparansi, kurangi CS |

Semua fitur di atas bersifat **pendukung interaksi user** dan dapat diimplementasikan bertahap; penjelasan konseptual ini dapat digunakan untuk kebutuhan akademik dan presentasi tanpa bergantung pada detail teknis tertentu.
