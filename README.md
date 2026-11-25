# Galeri Spektra Polimedia — *The Digital Curator*

Platform web **Kurasi Digital & Manajemen Pameran Hibrida (Digital dan Fisik)** untuk mewadahi publikasi serta seleksi karya kreatif mahasiswa **Politeknik Negeri Media Kreatif (Polimedia)**.

Dibangun menggunakan arsitektur **MVC CodeIgniter 4**, **MySQL (`InnoDB`)**, **Tailwind CSS**, dan **Vanilla JavaScript (ES6+)** dengan pendekatan **Hybrid Storage Architecture**.

---

## Fitur Utama

### 1. Pengajuan Karya Dua Jalur (*Dual-Track Submission & Hybrid Storage*)
- **Jalur Karya Digital:** Menyimpan poster/cuplikan visual teroptimasi di penyimpanan lokal server sembari menghubungkan berkas utama berkapasitas besar (video, animasi 3D, *game build*, prototipe Figma) melalui tautan *cloud* eksternal yang tervalidasi.
- **Jalur Karya Fisik & Proposal Logistik Pameran:** Mengelola pengajuan instalasi ruang fisik di Gedung A Polimedia lengkap dengan spesifikasi dimensi (`P x L x T`), material/media, kebutuhan ruang pamer & daya listrik, estimasi anggaran, serta unggahan dokumen **Rencana Anggaran Biaya (RAB)** (`.pdf` / `.xlsx`) beserta templat acuan standar.
- **Kepatuhan Akademik & HKI:** Validasi persetujuan Pakta Integritas orisinalitas karya dan izin publikasi dokumentasi non-komersial.

### 2. Alur Kurasi Multi-Peran (*Role-Based Curation Workflow*)
- **Portal Mahasiswa (Kreator):** Dasbor analitik status pengajuan (*Total*, *Disetujui*, *Dalam Review*, *Ditolak*), pemantauan evaluasi/umpan balik kurator, pembatalan pengajuan berstatus `PENDING` (beserta pembersihan berkas otomatis), dan manajemen profil portofolio.
- **Portal Kurator / Dosen Pengelola:** Antrean peninjauan karya lintas program studi, inspeksi dokumen RAB & tautan digital, persetujuan (`ACCEPTED`) atau penolakan (`REJECTED`) dengan kewajiban menyertakan umpan balik kuratorial, penambahan akun kurator internal, visualisasi grafik SVG distribusi pengajuan per program studi, serta ekspor laporan **CSV (`UTF-8 with BOM`)** yang langsung rapi dibuka di Microsoft Excel.

### 3. Katalog & Eksplorasi Publik Interaktif
- *Landing page* responsif dengan animasi *scroll-reveal* berbasis `IntersectionObserver` dan *horizontal snap carousel*.
- Halaman **Eksplorasi Karya (`/galeri`)** dengan pencarian multi-kolom (judul, deskripsi, kreator), pemfilteran sub-kategori *Digital* & *Fisik*, pengurutan waktu maupun popularitas kunjungan (*view counter* berbasis sesi), serta paginasi dinamis.

---

## Aspek Keamanan Rekayasa (*Security Highlights*)
- **Role-Based Access Control (RBAC):** Middleware terpusat (`AuthFilter`) yang memisahkan hak akses rute Mahasiswa dan Kurator/Admin, serta meniadakan registrasi admin publik.
- **Autentikasi & Sesi Aman:** Enkripsi kata sandi `PASSWORD_BCRYPT`, regenerasi ID sesi saat autentikasi (`session()->regenerate()`), dan verifikasi sandi lama saat pembaruan kredensial.
- **Perlindungan CSRF & HTTP Security Headers:** Token CSRF berbasis sesi pada seluruh formulir `POST` dan permintaan AJAX, metode `POST` untuk proses *logout*, serta header keamanan OWASP (`X-Frame-Options`, `X-Content-Type-Options: nosniff`, `Referrer-Policy`).
- **Validasi Unggahan & Sanitasi Output:** Validasi sisi server untuk tipe MIME, ekstensi, dan ukuran berkas; penonaktifan eksekusi skrip di direktori `public/uploads/.htaccess`; validasi skema URL ketat (`http`/`https`); *context-aware output escaping* (`esc(..., 'js')`); serta proteksi *CSV Formula Injection*.

---

## Teknologi yang Digunakan
- **Backend:** PHP 8.1+, CodeIgniter 4.6
- **Database:** MySQL / MariaDB (`InnoDB`, `utf8mb4_unicode_ci`, Foreign Key Constraints, Migrations & Seeders)
- **Frontend:** HTML5, Tailwind CSS, Google Fonts (`Inter`), Vanilla JavaScript ES6+ (`IntersectionObserver`, HTML5 Drag-and-Drop API, Fetch API)

---

## Panduan Instalasi Lokal (XAMPP / PHP Built-in Server)

1. **Clone repositori & instal dependensi Composer**
   ```bash
   git clone <url-repositori-anda> galeri_spektra
   cd galeri_spektra
   composer install
   ```

2. **Konfigurasi file lingkungan (`.env`)**
   ```bash
   cp env .env
   ```
   Sesuaikan kredensial database (`database.default.*`) dan `app.baseURL` pada berkas `.env`. Buat database kosong bernama `galeri_spektra` di MySQL/phpMyAdmin.

3. **Jalankan Migrasi & Seeder Basis Data**
   ```bash
   php spark migrate
   php spark db:seed DatabaseSeeder
   ```
   Perintah di atas otomatis membangun tabel `program_studi`, `mahasiswa`, `kurator`, dan `karya`, mengisi daftar Program Studi Polimedia, serta membuat akun Kurator awal apabila tabel kurator masih kosong:
   - **Email Kurator Default:** `kurator@polimedia.ac.id`
   - **Kata Sandi Default:** `SpektraPolimedia2026!` *(Segera ubah melalui menu Profil Akun setelah login pertama)*

4. **Jalankan Server Pengembangan**
   - Melalui XAMPP Apache: Akses `http://localhost/galeri_spektra/public/`
   - Atau melalui CLI CodeIgniter:
     ```bash
     php spark serve
     ```
     Lalu buka `http://localhost:8080` (sesuaikan `app.baseURL` di `.env` jika menggunakan `spark serve`).

---

## Struktur Direktori Inti
```text
galeri_spektra/
├── app/
│   ├── Common.php                 # Helper global (media_url & sanitasi CSV)
│   ├── Config/                    # Konfigurasi Rute, Filter, Keamanan, & Aplikasi
│   ├── Controllers/               # Auth, Beranda, Galeri, & Dashboard
│   ├── Database/
│   │   ├── Migrations/            # Skema terversi untuk 4 tabel relasional
│   │   └── Seeds/                 # Seeder Program Studi & Kurator awal
│   ├── Filters/AuthFilter.php     # Middleware autentikasi & otorisasi RBAC
│   ├── Models/                    # KaryaModel, MahasiswaModel, KuratorModel, ProgramStudiModel
│   └── Views/                     # Template antarmuka responsif (Publik, Mahasiswa, Kurator)
└── public/
    ├── assets/                    # Gambar statis & templat dokumen RAB (.xlsx)
    └── uploads/                   # Penyimpanan lokal poster & dokumen RAB (terproteksi .htaccess)
```

---

## Lisensi
Proyek ini dikembangkan untuk tujuan akademik dan pengelolaan pameran kreatif di lingkungan **Politeknik Negeri Media Kreatif (Polimedia)**.
