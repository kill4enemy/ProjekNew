# Product Requirements Document (PRD)
## Sistem Pemesanan Lapangan Padel Hans Padel

---

### 1. Ringkasan Eksekutif

**Hans Padel Booking System** adalah platform berbasis web yang dirancang untuk memodernisasi dan mengotomatisasi proses pemesanan lapangan di Hans Padel. Sistem ini menggantikan metode pemesanan manual (WhatsApp, telepon, dan kunjungan langsung) dengan solusi terintegrasi yang mencakup pengecekan ketersediaan secara real-time, pemrosesan pembayaran yang aman melalui Midtrans, pembuatan invoice otomatis, dan alat manajemen administratif.

Sistem ini bertujuan untuk menghilangkan *double booking*, menyederhanakan rekonsiliasi pembayaran, dan meningkatkan pengalaman pelanggan secara keseluruhan. Dengan memanfaatkan Laravel 12, Filament V3, dan berbagai layanan pendukung, platform ini memberikan solusi yang andal, aman, dan mudah digunakan bagi pelanggan maupun admin.

---

### 2. Tujuan Produk

#### 2.1 Tujuan Bisnis

| **No.** | **Tujuan** | **Metrik Keberhasilan** |
|---------|------------|-------------------------|
| 1 | Menghilangkan *double booking* | Nol insiden *double booking* |
| 2 | Mengotomatisasi pembayaran dan konfirmasi | 100% pembayaran dikonfirmasi melalui *webhook* |
| 3 | Menyediakan invoice dan laporan otomatis | Invoice terbuat dalam < 5 detik setelah pembayaran |
| 4 | Mempermudah pengelolaan lapangan dan monitoring transaksi | Waktu admin berkurang 70% |
| 5 | Meningkatkan pengalaman pelanggan | Skor kepuasan > 4.5/5 |

#### 2.2 Indikator Kinerja Utama (KPI)

- **Tingkat Konversi Pemesanan:** ≥ 80%
- **Tingkat Keberhasilan Pembayaran:** ≥ 95%
- **Uptime Sistem:** ≥ 99.5%
- **Waktu Respons:** < 2 detik
- **Tingkat Pengiriman Email:** ≥ 98%

---

### 3. Pengguna Sasaran (User Personas)

#### 3.1 Persona 1: Budi (Pelanggan)

| **Atribut** | **Keterangan** |
|-------------|----------------|
| **Usia** | 35 tahun |
| **Pekerjaan** | Profesional Korporat |
| **Pain Points** | Ingin memesan dengan cepat, tidak suka menunggu konfirmasi lama |
| **Kebutuhan** | Pemesanan mudah, konfirmasi instan, harga jelas |

#### 3.2 Persona 2: Rina (Admin)

| **Atribut** | **Keterangan** |
|-------------|----------------|
| **Usia** | 28 tahun |
| **Pekerjaan** | Manajer Operasional |
| **Pain Points** | Manajemen pemesanan manual, rekonsiliasi pembayaran sulit |
| **Kebutuhan** | Dashboard ringkas, manajemen lapangan mudah, pelaporan otomatis |

#### 3.3 Persona 3: Pak Hans (Pemilik)

| **Atribut** | **Keterangan** |
|-------------|----------------|
| **Usia** | 45 tahun |
| **Pekerjaan** | Pemilik Bisnis |
| **Pain Points** | Tidak memiliki wawasan tentang operasional bisnis |
| **Kebutuhan** | Laporan bisnis, pelacakan pendapatan, pengawasan operasional |

---

### 4. Fitur dan Persyaratan Fungsional

#### 4.1 Modul F1: Autentikasi & Registrasi

| **ID** | **Fitur** | **Prioritas** | **Kriteria Penerimaan** |
|--------|-----------|---------------|--------------------------|
| F1.1 | Registrasi Pengguna | P0 | Pengguna dapat mendaftar dengan nama, email, dan kata sandi |
| F1.2 | Login Pengguna | P0 | Pengguna dapat masuk dengan kredensial terdaftar |
| F1.3 | Logout Pengguna | P0 | Pengguna dapat keluar dengan aman |
| F1.4 | Reset Kata Sandi | P1 | Pengguna dapat mereset kata sandi melalui tautan email |
| F1.5 | Penetapan Peran | P0 | Sistem menetapkan peran (admin/pelanggan) saat registrasi |

#### 4.2 Modul F2: Manajemen Fasilitas (CRUD)

| **ID** | **Fitur** | **Prioritas** | **Kriteria Penerimaan** |
|--------|-----------|---------------|--------------------------|
| F2.1 | Tambah Fasilitas | P0 | Admin dapat menambahkan lapangan/fasilitas baru |
| F2.2 | Lihat Fasilitas | P0 | Admin dapat melihat semua fasilitas |
| F2.3 | Ubah Fasilitas | P0 | Admin dapat mengedit detail fasilitas |
| F2.4 | Hapus Fasilitas | P0 | Admin dapat menghapus fasilitas |
| F2.5 | Kolom Fasilitas | P0 | Nama, deskripsi, harga, tipe, gambar |

#### 4.3 Modul F3: Jam Operasional

| **ID** | **Fitur** | **Prioritas** | **Kriteria Penerimaan** |
|--------|-----------|---------------|--------------------------|
| F3.1 | Atur Jam Operasional | P0 | Admin dapat mengatur jam buka/tutup |
| F3.2 | Manajemen Hari Libur | P1 | Admin dapat mengatur jam khusus/libur |
| F3.3 | Jam Musiman | P2 | Admin dapat mengatur variasi musiman |

#### 4.4 Modul F4: Daftar Lapangan

| **ID** | **Fitur** | **Prioritas** | **Kriteria Penerimaan** |
|--------|-----------|---------------|--------------------------|
| F4.1 | Lihat Semua Lapangan | P0 | Pelanggan dapat melihat semua lapangan tersedia |
| F4.2 | Detail Lapangan | P0 | Pelanggan dapat melihat detail per lapangan |
| F4.3 | Filter/Cari | P1 | Pelanggan dapat memfilter berdasarkan tipe, harga, ketersediaan |

#### 4.5 Modul F5: Pengecekan Ketersediaan

| **ID** | **Fitur** | **Prioritas** | **Kriteria Penerimaan** |
|--------|-----------|---------------|--------------------------|
| F5.1 | Ketersediaan Real-time | P0 | Sistem menampilkan slot tersedia secara real-time |
| F5.2 | Tampilan Kalender | P0 | Ketersediaan ditampilkan dalam format kalender |
| F5.3 | Pemilihan Slot Waktu | P0 | Pengguna dapat memilih slot waktu tertentu |
| F5.4 | Pemilihan Durasi | P0 | Pengguna dapat memilih durasi pemesanan |

#### 4.6 Modul F6: Sistem Pemesanan

| **ID** | **Fitur** | **Prioritas** | **Kriteria Penerimaan** |
|--------|-----------|---------------|--------------------------|
| F6.1 | Buat Pemesanan | P0 | Pengguna dapat membuat pemesanan |
| F6.2 | Detail Pemesanan | P0 | Pemesanan mencakup: lapangan, tanggal, waktu, durasi |
| F6.3 | Proses Checkout | P0 | Pengguna dapat melanjutkan ke pembayaran |
| F6.4 | Riwayat Pemesanan | P0 | Pengguna dapat melihat riwayat pemesanan |
| F6.5 | Pembatalan Pemesanan | P1 | Pengguna dapat membatalkan pemesanan (sesuai kebijakan) |
| F6.6 | Lihat Status Pemesanan | P0 | Pengguna dapat melihat status (pending, confirmed, completed) |

#### 4.7 Modul F7: Anti-Double Booking

| **ID** | **Fitur** | **Prioritas** | **Kriteria Penerimaan** |
|--------|-----------|---------------|--------------------------|
| F7.1 | Penguncian Slot | P0 | Sistem mengunci slot selama proses checkout |
| F7.2 | Kontrol Konkurensi | P0 | Penguncian database mencegah pemesanan bersamaan |
| F7.3 | Deteksi Konflik | P0 | Sistem mendeteksi dan mencegah pemesanan tumpang tindih |
| F7.4 | Pembaruan Real-time | P0 | Ketersediaan diperbarui secara real-time |

#### 4.8 Modul F8: Integrasi Pembayaran Midtrans

| **ID** | **Fitur** | **Prioritas** | **Kriteria Penerimaan** |
|--------|-----------|---------------|--------------------------|
| F8.1 | Gateway Pembayaran | P0 | Integrasi dengan API Midtrans Snap |
| F8.2 | Metode Pembayaran Ganda | P1 | Mendukung berbagai metode pembayaran |
| F8.3 | Pelacakan Status Pembayaran | P0 | Melacak status pembayaran real-time |
| F8.4 | Kadaluwarsa Pembayaran | P0 | Mengatur waktu kadaluwarsa (15 menit) |
| F8.5 | Transaksi Aman | P0 | Semua pembayaran harus aman |

#### 4.9 Modul F9: Webhook Otomatis

| **ID** | **Fitur** | **Prioritas** | **Kriteria Penerimaan** |
|--------|-----------|---------------|--------------------------|
| F9.1 | Endpoint Webhook | P0 | Sistem menyediakan endpoint untuk callback Midtrans |
| F9.2 | Konfirmasi Pembayaran | P0 | Konfirmasi pemesanan otomatis saat pembayaran berhasil |
| F9.3 | Penanganan Gagal Bayar | P0 | Menangani pembayaran gagal dengan tepat |
| F9.4 | Pemicu Notifikasi | P0 | Memicu notifikasi berdasarkan webhook |
| F9.5 | Logging Webhook | P1 | Mencatat semua permintaan webhook untuk debugging |

#### 4.10 Modul F10: Pembuatan Invoice PDF

| **ID** | **Fitur** | **Prioritas** | **Kriteria Penerimaan** |
|--------|-----------|---------------|--------------------------|
| F10.1 | Pembuatan Invoice | P0 | Membuat invoice setelah pembayaran berhasil |
| F10.2 | Konten Invoice | P0 | Mencakup: detail pemesanan, jumlah, info pelanggan |
| F10.3 | Penomoran Invoice | P0 | Nomor invoice unik berurutan |
| F10.4 | Unduh PDF | P0 | Pengguna dapat mengunduh invoice sebagai PDF |
| F10.5 | Desain Invoice | P0 | Tata letak profesional sesuai merek |

#### 4.11 Modul F11: Otomatisasi Email

| **ID** | **Fitur** | **Prioritas** | **Kriteria Penerimaan** |
|--------|-----------|---------------|--------------------------|
| F11.1 | Konfirmasi Pemesanan | P0 | Mengirim email setelah pemesanan berhasil |
| F11.2 | Konfirmasi Pembayaran | P0 | Mengirim email setelah pembayaran berhasil |
| F11.3 | Lampiran Invoice | P0 | Melampirkan invoice PDF di email konfirmasi |
| F11.4 | Email Pengingat | P1 | Mengirim pengingat 24 jam sebelum jadwal |
| F11.5 | Template Email | P0 | Template email profesional |

#### 4.12 Modul F12: Dashboard Admin (Filament V3)

| **ID** | **Fitur** | **Prioritas** | **Kriteria Penerimaan** |
|--------|-----------|---------------|--------------------------|
| F12.1 | Dashboard Overview | P0 | Menampilkan metrik kunci (booking, pendapatan, okupansi) |
| F12.2 | Manajemen Pemesanan | P0 | Lihat, buat, edit, batalkan pemesanan |
| F12.3 | Manajemen Fasilitas | P0 | CRUD penuh untuk fasilitas |
| F12.4 | Manajemen Pengguna | P0 | Lihat dan kelola pengguna |
| F12.5 | Monitoring Pembayaran | P0 | Lihat semua pembayaran dan transaksi |
| F12.6 | Pembuatan Laporan | P0 | Buat berbagai laporan |
| F12.7 | Log Sistem | P1 | Lihat log sistem |
| F12.8 | Widget | P1 | Widget dashboard yang dapat disesuaikan |

#### 4.13 Modul F13: Konfigurasi Sistem

| **ID** | **Fitur** | **Prioritas** | **Kriteria Penerimaan** |
|--------|-----------|---------------|--------------------------|
| F13.1 | Pengaturan Umum | P0 | Nama situs, kontak, dll. |
| F13.2 | Pengaturan Pembayaran | P0 | Konfigurasi Midtrans |
| F13.3 | Pengaturan Email | P0 | Konfigurasi SMTP |
| F13.4 | Jam Operasional | P0 | Atur jam operasional fasilitas |
| F13.5 | Konfigurasi Harga | P0 | Atur dan perbarui harga |
| F13.6 | Aturan Pemesanan | P1 | Konfigurasi aturan pemesanan (pembatalan, dll.) |

#### 4.14 Modul F14: Riwayat Pemesanan

| **ID** | **Fitur** | **Prioritas** | **Kriteria Penerimaan** |
|--------|-----------|---------------|--------------------------|
| F14.1 | Riwayat Pengguna | P0 | Pengguna dapat melihat riwayat pemesanan |
| F14.2 | Riwayat Admin | P0 | Admin dapat melihat semua pemesanan |
| F14.3 | Filter Riwayat | P1 | Filter berdasarkan tanggal, status, lapangan |
| F14.4 | Ekspor Riwayat | P1 | Ekspor riwayat ke CSV/PDF |
| F14.5 | Cari Riwayat | P1 | Cari pemesanan tertentu |

---

### 5. Persyaratan Non-Fungsional

#### 5.1 Persyaratan Keamanan

| **ID** | **Persyaratan** | **Deskripsi** |
|--------|-----------------|---------------|
| NFR-SEC-01 | Kontrol Akses Berbasis Peran | Peran admin dan pelanggan dengan izin berbeda |
| NFR-SEC-02 | Validasi Form Request | Validasi sisi server untuk semua form |
| NFR-SEC-03 | Perlindungan CSRF | Semua form harus memiliki token CSRF |
| NFR-SEC-04 | Pencegahan XSS | Sanitasi input dan escaping output |
| NFR-SEC-05 | Pencegahan SQL Injection | Gunakan Eloquent ORM dengan query terparameterisasi |
| NFR-SEC-06 | HTTPS | Wajibkan HTTPS untuk semua koneksi |
| NFR-SEC-07 | Hashing Kata Sandi | Gunakan bcrypt untuk hashing kata sandi |

#### 5.2 Persyaratan Kinerja

| **ID** | **Persyaratan** | **Metrik** |
|--------|-----------------|------------|
| NFR-PERF-01 | Waktu Respons Halaman | < 2 detik untuk semua halaman |
| NFR-PERF-02 | Respons Webhook | < 5 detik untuk pemrosesan webhook |
| NFR-PERF-03 | Pengguna Bersamaan | Dukung hingga 100 pengguna bersamaan |
| NFR-PERF-04 | Waktu Muat Halaman | < 3 detik pada jaringan 3G |
| NFR-PERF-05 | Waktu Query Database | < 500ms untuk query kompleks |

#### 5.3 Persyaratan Keandalan

| **ID** | **Persyaratan** | **Deskripsi** |
|--------|-----------------|---------------|
| NFR-REL-01 | Sistem Antrian Email | Mencegah keterlambatan pengiriman email |
| NFR-REL-02 | Penguncian Database | Mencegah double booking dengan penguncian |
| NFR-REL-03 | Pattern Service | Pemisahan logika bisnis yang bersih |
| NFR-REL-04 | Action Class Pattern | Logika bisnis yang dapat digunakan ulang dan diuji |
| NFR-REL-05 | Penanganan Error | Penanganan error dan logging yang tepat |
| NFR-REL-06 | Mekanisme Coba Ulang Webhook | Coba ulang pemrosesan webhook yang gagal |

#### 5.4 Persyaratan Ketersediaan

| **ID** | **Persyaratan** | **Metrik** |
|--------|-----------------|------------|
| NFR-AVA-01 | Uptime Sistem | Ketersediaan 99.5% |
| NFR-AVA-02 | Pemeliharaan Terjadwal | Beri tahu pengguna 24 jam sebelumnya |
| NFR-AVA-03 | Frekuensi Backup | Backup database harian |

#### 5.5 Persyaratan Kegunaan

| **ID** | **Persyaratan** | **Deskripsi** |
|--------|-----------------|---------------|
| NFR-USR-01 | Desain Responsif | Bekerja di desktop, tablet, dan mobile |
| NFR-USR-02 | UI Modern | Gunakan Tailwind CSS untuk tampilan modern |
| NFR-USR-03 | Navigasi Intuitif | Navigasi sederhana dan jelas |
| NFR-USR-04 | Indikator Loading | Tampilkan status loading untuk operasi asinkron |
| NFR-USR-05 | Pesan Error | Pesan error yang jelas dan membantu |

#### 5.6 Persyaratan Kompatibilitas

| **ID** | **Persyaratan** | **Deskripsi** |
|--------|-----------------|---------------|
| NFR-COMP-01 | Dukungan Browser | Chrome, Firefox, Safari, Edge (2 versi terakhir) |
| NFR-COMP-02 | Kompatibilitas Database | MariaDB 10.11 atau kompatibel |
| NFR-COMP-03 | Versi PHP | PHP 8.2 atau lebih tinggi |

---

### 6. Alur Pengguna (User Flow)

#### 6.1 Alur Pemesanan Pelanggan
**Langkah-langkah Detail:**

1. **Lihat Lapangan**: Pelanggan melihat daftar lapangan dengan detail
2. **Cek Slot**: Pelanggan cek ketersediaan real-time
3. **Pilih Slot**: Pelanggan pilih slot waktu dan durasi
4. **Review Booking**: Pelanggan review detail dan total harga
5. **Buat Booking**: Sistem buat booking pending (kunci slot)
6. **Bayar Midtrans**: Pelanggan diarahkan ke Midtrans
7. **Webhook Proses**: Midtrans kirim konfirmasi pembayaran
8. **Dapat Invoice**: Sistem buat invoice PDF
9. **Email Confirm**: Sistem kirim email dengan invoice

#### 6.2 Alur Admin
┌─────────────────────────────────────────────────────────────────┐
│ Alur Admin │
├─────────────────────────────────────────────────────────────────┤
│ │
│ ┌────────┐ ┌────────┐ ┌────────┐ ┌────────┐ │
│ │ Login │───▶│Dashboard│───▶│ Kelola │───▶│Monitor │ │
│ │ │ │Overview │ │Fasilitas│ │Booking │ │
│ └────────┘ └────────┘ └────────┘ └────────┘ │
│ │
│ ┌────────┐ ┌────────┐ ┌────────┐ ┌────────┐ │
│ │ Lihat │───▶│ Kelola │───▶│Konfig │───▶│Generate│ │
│ │Laporan │ │Pengguna│ │Sistem │ │Laporan │ │
│ └────────┘ └────────┘ └────────┘ └────────┘ │
└─────────────────────────────────────────────────────────────────┘
### 7. Kriteria Penerimaan (Acceptance Criteria)

#### 7.1 Kriteria Penerimaan Umum

| **No.** | **Kriteria** | **Status** |
|---------|--------------|------------|
| 1 | Semua modul berfungsi sesuai spesifikasi | ☐ |
| 2 | Integrasi Midtrans berhasil dan pembayaran dapat diproses | ☐ |
| 3 | Webhook otomatis berjalan dan mengkonfirmasi pembayaran | ☐ |
| 4 | Invoice PDF terbentuk dengan benar | ☐ |
| 5 | Email terkirim otomatis ke pengguna | ☐ |
| 6 | Admin dapat mengelola data (CRUD) | ☐ |
| 7 | UAT sesuai kebutuhan pengguna | ☐ |

#### 7.2 Kriteria Penerimaan Berdasarkan Modul

| **Modul** | **Kriteria Penerimaan** |
|-----------|-------------------------|
| **Autentikasi** | • Registrasi berhasil<br>• Login/logout berfungsi<br>• Reset password berjalan |
| **Manajemen Lapangan** | • CRUD lapangan berfungsi penuh<br>• Gambar dapat diunggah<br>• Harga dan tipe tersimpan |
| **Pemesanan** | • Booking berhasil dibuat<br>• Slot terkunci selama proses<br>• Tidak ada double booking |
| **Pembayaran** | • Redirect ke Midtrans berhasil<br>• Status pembayaran terupdate<br>• Webhook diterima dan diproses |
| **Invoice** | • PDF terbuat otomatis<br>• Format dan konten sesuai<br>• Dapat diunduh |
| **Email** | • Email terkirim ke penerima<br>• Lampiran invoice terlampir<br>• Template sesuai |
| **Dashboard Admin** | • Semua data tampil<br>• CRUD berfungsi<br>• Laporan dapat diekspor |

#### 7.3 Kriteria Penerimaan Fungsional

| **ID** | **Skenario** | **Hasil Diharapkan** |
|--------|--------------|-----------------------|
| AC-01 | Pengguna mendaftar dengan email baru | Akun terbuat, email verifikasi terkirim |
| AC-02 | Pengguna login dengan kredensial benar | Redirect ke dashboard sesuai peran |
| AC-03 | Pengguna login dengan kredensial salah | Muncul pesan error |
| AC-04 | Admin menambahkan lapangan baru | Lapangan muncul di daftar |
| AC-05 | Pelanggan memilih slot tersedia | Booking dibuat, status pending |
| AC-06 | Pelanggan memilih slot sudah dibooking | Muncul notifikasi tidak tersedia |
| AC-07 | Pelanggan melakukan pembayaran | Status berubah menjadi confirmed |
| AC-08 | Pembayaran gagal | Status tetap pending, slot dilepas |
| AC-09 | Webhook diterima | Status booking terupdate otomatis |
| AC-10 | Invoice diunduh | File PDF terunduh dengan benar |

---

### 8. Batasan dan Asumsi

#### 8.1 Asumsi

| **No.** | **Asumsi** | **Deskripsi** |
|---------|------------|---------------|
| 1 | Koneksi Internet | Pengguna dan sistem memiliki akses internet stabil |
| 2 | Midtrans Aktif | Layanan Midtrans Snap berjalan normal |
| 3 | SMTP Aktif | Layanan Gmail SMTP dapat diakses |
| 4 | Docker Berjalan | Lingkungan Docker berfungsi normal |
| 5 | Browser Modern | Pengguna menggunakan browser terbaru |
| 6 | Database Tersedia | MariaDB berjalan dan dapat diakses |

#### 8.2 Batasan

| **No.** | **Batasan** | **Deskripsi** |
|---------|-------------|---------------|
| 1 | Single Branch | Sistem hanya untuk satu cabang Hans Padel |
| 2 | No Mobile Native | Tidak ada aplikasi mobile native |
| 3 | No Refund Otomatis | Refund diproses secara manual oleh admin |
| 4 | No Membership | Fitur keanggotaan belum tersedia |
| 5 | No Live Chat | Tidak ada fitur chat real-time |
| 6 | No Multi Language | Bahasa Indonesia hanya |
| 7 | Payment Gateway | Hanya Midtrans yang terintegrasi |

#### 8.3 Risiko dan Mitigasi

| **No.** | **Risiko** | **Dampak** | **Mitigasi** |
|---------|------------|------------|--------------|
| 1 | Double Booking | Kehilangan pendapatan | Penguncian database, kontrol konkurensi |
| 2 | Webhook Gagal | Booking tidak terkonfirmasi | Retry mechanism, logging manual |
| 3 | Email Gagal | Pelanggan tidak dapat notifikasi | Antrian email, fallback SMTP |
| 4 | Konfigurasi Salah | Sistem tidak berfungsi | Dokumentasi, staging environment |
| 5 | Perubahan API Midtrans | Pembayaran gagal | Monitoring, pembaruan rutin |

---

### 9. Garis Waktu (Timeline)

#### 9.1 Tahapan Pengembangan

| **Fase** | **Aktivitas** | **Durasi** | **Hasil** |
|----------|---------------|------------|-----------|
| **Fase 1** | Analisis dan Perencanaan | 1 Minggu | • Dokumen spesifikasi<br>• ERD database<br>• Wireframe |
| **Fase 2** | Pengembangan Backend | 2 Minggu | • Autentikasi<br>• CRUD Lapangan<br>• Sistem Booking<br>• Database |
| **Fase 3** | Pengembangan Frontend | 2 Minggu | • Tampilan pelanggan<br>• Dashboard admin<br>• UI/UX |
| **Fase 4** | Integrasi | 1 Minggu | • Midtrans Snap<br>• Webhook<br>• SMTP<br>• DomPDF |
| **Fase 5** | Pengujian | 1 Minggu | • Unit test<br>• Integration test<br>• UAT |
| **Fase 6** | Deployment | 3 Hari | • Server setup<br>• Docker deployment<br>• Go-live |

#### 9.2 Jadwal Detail
┌─────────────────────────────────────────────────────────────────────┐
│ Timeline Proyek │
├─────────────────────────────────────────────────────────────────────┤
│ │
│ Fase 1: Analisis & Perencanaan ████████ │
│ (Minggu 1) │
│ │
│ Fase 2: Backend Development ████████████ │
│ (Minggu 2-3) │
│ │
│ Fase 3: Frontend Development ████████████ │
│ (Minggu 4-5) │
│ │
│ Fase 4: Integrasi ████████ │
│ (Minggu 6) │
│ │
│ Fase 5: Pengujian ████████ │
│ (Minggu 7) │
│ │
│ Fase 6: Deployment ████ │
│ (Minggu 8) │
│ │
│ Total: 8 Minggu │
└─────────────────────────────────────────────────────────────────────┘


#### 9.3 Milestone

| **Milestone** | **Tanggal Target** | **Deskripsi** |
|---------------|-------------------|---------------|
| M1 | Akhir Minggu 1 | Dokumen PRD dan desain disetujui |
| M2 | Akhir Minggu 3 | Backend selesai (API, database) |
| M3 | Akhir Minggu 5 | Frontend selesai (UI/UX) |
| M4 | Akhir Minggu 6 | Integrasi selesai |
| M5 | Akhir Minggu 7 | Pengujian selesai, bug fixed |
| M6 | Akhir Minggu 8 | Deployment dan Go-live |

---

