# MANUAL BOOK
## Sistem Informasi Presensi Santri
### Madrasah Diniyah Al-Asy'ariyyah

**Versi:** 1.0  
**Tanggal:** Oktober 2026  

---

## DAFTAR ISI

| No | Bab | Halaman |
|----|-----|---------|
| I | Pendahuluan | 3 |
| II | Arsitektur dan Instalasi Sistem | 6 |
| III | Panduan Penggunaan Sistem | 14 |
| IV | Penjelasan Fitur dan Aturan Sistem | 42 |
| Lampiran A: Diagram E-R | 58 |
| Lampiran B: Diagram Alur | 60 |
| Lampiran C: Daftar Route | 62 |

---

# BAB I
## PENDAHULUAN

### 1.1 Latar Belakang

Madrasah Diniyah Al-Asy'ariyyah sebagai lembaga pendidikan keagamaan sekolah berbasiskan **Khalaqoh** (Sanadiyyah dan Syahbah) membutuhkan sistem untuk mencatat kehadiran santri secara akurat dan efisien. Sebelumnya, pencatatan presensi dilakukan secara manual dengan buku harian, yang rentan terhadap kesalahan pencatatan, kesulitan dalam mengolah laporan secara real-time, dan tidak memberikan gambaran visual yang jelas tentang pola kehadiran santri.

Berdasarkan kondisi tersebut, sistem informasi presensi berbasis web ini dikembangkan untuk mendigitalisasi seluruh proses pencatatan kehadiran santri, menghitung denda secara otomatis, memberikan laporan dan statistik kehadiran, serta memungkinkan setiap peran pengguna (Admin, Petugas, Santri) mengakses informasi yang relevan sesuai dengan hak aksesnya.

### 1.2 Tujuan

Sistem Informasi Presensi Santri ini dirancang untuk:

1. **Mencatat kehadiran santri** secara digital berdasarkan jadwal pelajaran (Jam Pelajaran) yang telah ditentukan.
2. **Menghitung denda** secara otomatis berdasarkan status kehadiran (Hadir, Izin, Sakit, Alpha).
3. **Menampilkan rekap dan statistik kehadiran** dalam bentuk tabel, grafik, dan laporan PDF.
4. **Meningkatkan akurasi dan kecepatan** pencatatan presensi dibanding metode manual.
5. **Memberikan akses berbeda** berdasarkan peran pengguna: Admin (akses penuh), Petugas (pencatatan presensi), dan Santri (melihat riwayat dan statistik pribadi).
6. **Meningkatkan motivasi kehadiran** melalui sistem ranking kehadiran yang kompetitif.

### 1.3 Ruang Lingkup

Sistem ini mencakup modul-modul berikut:

**Modul Pengguna dan Autentikasi**
- Sistem login dengan username/password (Admin/Petugas) atau NIS (Santri).
- Manajemen peran pengguna (Admin, Petugas, Santri).
- Fitur ganti kata sandi dan reset kata sandi.
- Fitur verifikasi email untuk akun Admin dan Petugas.

**Modul Data Master**
- Manajemen data Santri (tambah, edit, hapus, reset password).
- Manajemen data Jam Pelajaran (jadwal mengajar berdasarkan hari, kelas/jenjang, dan urutan).
- Manajemen data Pengguna (kelola akun Admin, Petugas, dan Santri).

**Modul Presensi**
- Pencatatan presensi harian berdasarkan jadwal pelajaran.
- Dukungan pencatatan otomatis saat membuka halaman presensi (autosave).
- Pengeditan presensi berdasarkan tanggal.
- Pemisahan kelas Santinatunnajah dan Muqodimah.

**Modul Rekap dan Laporan**
- Rekap presensi per santri per bulan.
- Rekap denda per santri per bulan.
- Ranking kehadiran santri.
- Cetak laporan presensi (browser print).
- Ekspor laporan ke format Excel (.xlsx).
- Cetak laporan dalam format PDF (Rekap, Denda, Ranking, Laporan Lengkap).

**Modul Statistik**
- Grafik distribusi kehadiran (pie chart).
- Grafik kehadiran harian (bar chart).
- Statistik kehadiran per santri (chart area + donut).

**Modul Profil**
- Lihat dan edit profil pengguna.
- Ganti kata sandi pribadi.

**Modul Pengaturan**
- Reset data absensi.
- Reset data santri (operasi berbahaya).
- Unduh template santri (format Excel untuk impor massal).

### 1.4 Definisi, Istilah, dan Abkresi

| Istilah | Pengertian |
|---------|------------|
| **Admin** | Peran pengguna dengan akses penuh ke seluruh fitur sistem, termasuk manajemen santri, pengguna, pengaturan, dan laporan. |
| **Petugas** | Peran pengguna yang bertugas mencatat presensi harian, mengedit presensi, dan melihat profil. |
| **Santri** | Peran pengguna yang merupakan santri Madrasah; dapat melihat riwayat kehadiran, denda, ranking, statistik, dan profil pribadi. |
| **NIS** | Nomor Induk Santri — pengidentifikasi unik setiap santri; juga digunakan sebagai kata sandi default saat akun pertama kali dibuat. |
| **Khalaqoh** | Kategori jenjang pendidikan Santri: **Safinatunnajah** (Kelas 1) atau **Muqodimah** (Kelas 2). |
| **Jam Pelajaran** | Jadwal mengajar yang mencakup nama mata pelajaran, ustadz, hari, jam mulai/selesai, urutan, kelas, dan status (aktif/non-aktif). |
| **Absensi** | Catatan kehadiran santri pada suatu jam pelajaran dengan status: Hadir, Izin, Sakit, atau Alpha. |
| **Denda** | Konsekuensi finansial otomatis berdasarkan status kehadiran santri. |
| **Status Pembayaran** | Menandai apakah denda sudah lunas (`sudah_bayar`) atau belum (`belum_bayar`). |
| **Autosave** | Fitur yang secara otomatis menyimpan status kehadiran santri ketika checkbox pada halaman presensi diubah. |

### 1.5 Aturan Denda

Berikut adalah aturan denda yang diterapkan secara otomatis sistem berdasarkan status kehadiran:

| Status | Deskripsi | Denda (Rp) |
|--------|-----------|-----------|
| **Hadir** | Santri hadir pada jam pelajaran | 0 |
| **Izin** | Santri izin tidak hadir (dengan alasan sakit, keperluan keluarga, dll.) | 2.000 |
| **Sakit** | Santri sakit (wajib ada bukti/keterangan dari orang tua) | 2.000 |
| **Alpha** | Santri tidak hadir tanpa memberi tahu sebelumnya | 5.000 |

Aturan ini dienkapsulasi dalam kelas `Absensi` (`app/Models/Absensi.php`) melalui konstanta `DENDA_HADIR`, `DENDA_IZIN`, `DENDA_SAKIT`, dan `DENDA_ALPHA`. Nilai denda dihitung otomatis saat pembuatan atau pembaruan catatan absensi.

### 1.6 Struktur Peran Pengguna

Sistem ini mendukung tiga peran pengguna yang dikelola melalui `RoleMiddleware`:

| Peran | Akses Dashboard | Fitur Utama |
|-------|----------------|-------------|
| **Admin** | Admin Dashboard | Semua fitur: Santri, Presensi, Rekap, Laporan, Statistik, Jam Pelajaran, Pengguna, Pengaturan, Profil |
| **Petugas** | Petugas Dashboard | Presensi (lihat & input), Profil (lihat & edit) |
| **Santri** | Santri Dashboard | Profil, Riwayat Presensi, Denda, Ranking, Statistik |

---

# BAB II
## ARSITEKTUR DAN INSTALASI SISTEM

### 2.1 Arsitektur Sistem

Sistem Informasi Presensi Santri menggunakan arsitektur berikut:

```
┌─────────────────────────────────────────────────────────┐
│                    Web Browser client                    │
│  (Chrome, Firefox, Edge — akses via http/https)          │
└──────────────┬──────────────────────────────────────────┘
               │ HTTP/HTTPS Request/Response
┌──────────────┴──────────────────────────────────────────┐
│              Web Server (Apache/Nginx)                   │
└──────────────┬──────────────────────────────────────────┘
               │
┌──────────────┴──────────────────────────────────────────┐
│              Laravel Application Server                 │
│  ┌───────────────────────────────────────────────────┐  │
│  │  Routes/web.php — Definisi semua URL endpoint      │  │
│  │                                                   │  │
│  │  Controllers:                                      │  │
│  │  • SimpleLoginController          (Autentikasi)   │  │
│  │  • AdminForgotPasswordController   (Reset pass)   │  │
│  │  • DashboardController             (Admin dash)   │  │
│  │  • Santri\DashboardController      (Santri dash)  │  │
│  │  • PresensiController              (Presensi)     │  │
│  │  • SantriController                (Manajemen SD) │  │
│  │  • JamPelajaranController          (Jadwal)       │  │
│  │  • RekapController                 (Rekap)        │  │
│  │  • LaporanController               (Laporan PDF)  │  │
│  │  • StatistikController             (Statistik)    │  │
│  │  • Santri\AttendanceController     (Riwayat SD)   │  │
│  │  • Santri\FineController           (Denda SD)     │  │
│  │  • Santri\RankingController        (Ranking SD)   │  │
│  │  • Santri\StatisticsController     (Statistik SD) │  │
│  │  • ProfileController               (Profil)       │  │
│  │  • UserManagementController        (Kelola user)  │  │
│  │  • PengaturanController            (Pengaturan)   │  │
│  │                                                   │  │
│  │  Middleware:                                       │  │
│  │  • RoleMiddleware — otorisasi per peran           │  │
│  │                                                   │  │
│  │  Models (Eloquent ORM):                           │  │
│  │  • User — Admin, Petugas, Santri                  │  │
│  │  • Santri — Data master santri                    │  │
│  │  • JamPelajaran — Jadwal mengajar                 │  │
│  │  • Absensi — Catatan kehadiran                    │  │
│  └───────────────────────────────────────────────────┘  │
└──────────────┬──────────────────────────────────────────┘
               │
┌──────────────┴──────────────────────────────────────────┐
│         Database (MySQL)                                  │
│  Tables: users, santri, jam_pelajaran, absensi,           │
│          password_reset_tokens, sessions                   │
└──────────────────────────────────────────────────────────┘
```

### 2.2 Teknologi yang Digunakan

| Komponen | Teknologi |
|----------|-----------|
| **Framework Backend** | Laravel 12 (PHP) |
| **Database** | MySQL |
| **Frontend** | Blade Template + Tailwind CSS + Vite |
| **Charting** | Chart.js (Statistik halaman), ApexCharts (Dashboard & Santri) |
| **Export** | Laravel Excel (Maatwebsite) — ekspor Excel |
| **PDF** | Barryvdh DomPDF — pembuatan laporan PDF |
| **Icons** | Font Awesome 6.5.0 |
| **Authentication** | Laravel Authentication (custom SimpleLoginController) |

### 2.3 Persyaratan Sistem

#### Server
- PHP 8.2 atau lebih baru
- Composer 2.x
- MySQL 8.0+ atau MariaDB 10.5+
- Extension PHP: `pdo_mysql`, `mbstring`, `openssl`, `ctype`, `json`, `bcmath`, `fileinfo`, `dom`, `gd` (untuk DomPDF)

#### Lokasi Penyimpanan
- Ruang penyimpanan minimal 500MB (untuk sistem + log + export)

### 2.4 Instalasi Sistem

#### Langkah 1: Clone / Deploy Kode Sumber
```bash
cd /path/to/webroot
git clone <repository-url> sistem-presensi
cd sistem-presensi
```

#### Langkah 2: Install Dependensi Composer
```bash
composer install --optimize-autoloader
```

#### Langkah 3: Install Dependensi NPM
```bash
npm install
npm run build
```

#### Langkah 4: Konfigurasi Lingkungan
Salin file `.env.example` menjadi `.env` dan sesuaikan:
```bash
cp .env.example .env
php artisan key:generate
```

Edit file `.env` dan atur koneksi database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database
DB_USERNAME=user_database
DB_PASSWORD=password_database

# Konfigurasi email (untuk fitur reset password admin)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=email@domain.com
MAIL_PASSWORD=password_email
MAIL_ENCRYPTION=tls
```

#### Langkah 5: Migrasi Database
```bash
php artisan migrate --force
```

#### Langkah 6: (Opsional) Seeding Data
Jika tersedia seeder untuk data awal:
```bash
php artisan db:seed
```

#### Langkah 7: Akses Sistem
Buka browser dan akses:
```
http://localhost/sistem-presensi
```
Sistem akan otomatis mengarahkan ke halaman login.

### 2.5 Struktur Direktori Proyek

```
sistem-presensi/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Controller.php
│   │   │   ├── SimpleLoginController.php
│   │   │   ├── AdminForgotPasswordController.php
│   │   │   ├── DashboardController.php
│   │   │   ├── SantriController.php
│   │   │   ├── PresensiController.php
│   │   │   ├── RekapController.php
│   │   │   ├── LaporanController.php
│   │   │   ├── StatistikController.php
│   │   │   ├── JamPelajaranController.php
│   │   │   ├── ProfileController.php
│   │   │   ├── PengaturanController.php
│   │   │   ├── UserManagementController.php
│   │   │   ├── SantriPasswordController.php
│   │   │   └── Santri/
│   │   │       ├── DashboardController.php
│   │   │       ├── AttendanceController.php
│   │   │       ├── FineController.php
│   │   │       ├── RankingController.php
│   │   │       └── StatisticsController.php
│   │   ├── Middleware/
│   │   │   └── RoleMiddleware.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Santri.php
│   │   ├── JamPelajaran.php
│   │   └── Absensi.php
│   ├── Exports/
│   │   └── RekapPresensiExport.php
│   ├── Http/
│   │   ├── Requests/
│   │   │   └── ProfileUpdateRequest.php
│   └── Providers/
│       └── AppServiceProvider.php
├── bootstrap/
├── config/
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
│       ├── layouts/
│       │   ├── app.blade.php
│       │   ├── guest.blade.php
│       │   └── navigation.blade.php
│       ├── auth/
│       ├── admin/
│       ├── petugas/
│       ├── santri/
│       ├── presensi/
│       ├── rekap/
│       ├── laporan/
│       ├── statistik/
│       ├── jam-pelajaran/
│       ├── profile/
│       └── components/
├── routes/
│   └── web.php
├── public/
├── storage/
├── vendor/
├── .env
├── composer.json
├── package.json
└── artisan
```

### 2.6 Aturan Akses dan Middleware

Sistem menggunakan `RoleMiddleware` untuk menentukan akses setiap peran pengguna. Berikut adalah petaan route dan middleware:

| Route Prefix | Route Name | Controller | Middleware | Peran yang Diizinkan |
|-------------|------------|------------|------------|---------------------|
| `/login` | login | SimpleLoginController | `guest` | Semua (belum login) |
| `/admin/forgot-password` | admin.password.request | AdminForgotPasswordController | guest | Admin |
| `/reset-password/{token}` | password.reset | NewPasswordController | - | Admin/Petugas |
| `/admin/dashboard` | admin.dashboard | DashboardController | `auth`, `role:admin` | Admin |
| `/santri` | santri.* | SantriController | `auth`, `role:admin` | Admin |
| `/presensi` | presensi.* | PresensiController | `auth`, `role:admin` | Admin |
| `/petugas/presensi` | petugas.presensi.* | PresensiController | `auth`, `role:petugas` | Petugas |
| `/rekap` | rekap.* | RekapController | `auth`, `role:admin` | Admin |
| `/laporan` | laporan.* | LaporanController | `auth`, `role:admin` | Admin |
| `/statistik` | statistik.index | StatistikController | `auth`, `role:admin` | Admin |
| `/jam-pelajaran` | jam-pelajaran.* | JamPelajaranController | `auth`, `role:admin` | Admin |
| `/users` | users.* | UserManagementController | `auth`, `role:admin` | Admin |
| `/pengaturan` | pengaturan.* | PengaturanController | `auth`, `role:admin` | Admin |
| `/profile` | profile.* | ProfileController | `auth`, `role:admin` | Admin |
| `/petugas/profile` | petugas.profile.* | ProfileController | `auth`, `role:petugas` | Petugas |
| `/santri/profile` | santri.profile.* | ProfileController | `auth`, `role:santri` | Santri |
| `/santri/attendance` | santri.attendance | Santri\AttendanceController | `auth`, `role:santri` | Santri |
| `/santri/fine` | santri.fine | Santri\FineController | `auth`, `role:santri` | Santri |
| `/santri/ranking` | santri.ranking | Santri\RankingController | `auth`, `role:santri` | Santri |
| `/santri/statistics` | santri.statistics | Santri\StatisticsController | `auth`, `role:santri` | Santri |

---

# BAB III
## PANUASAN PENGGUNAAN SISTEM

### 3.1 Halaman Login

Setelah mengakses sistem, pengguna akan diarahkan ke halaman login. Sistem mendukung dua mekanisme login:

1. **Login sebagai Admin atau Petugas:**
   - Gunakan **Username** dan **Password** yang telah didaftarkan.
   - Klik tombol "Login".

2. **Login sebagai Santri:**
   - Gunakan **NIS** sebagai identitas login.
   - Pada login pertama, password default adalah **NIS itu sendiri**.
   - Setelah berhasil login, sistem akan otomatis mengarahkan ke halaman **ganti kata sandi** jika flag `must_change_password` masih `true`.
   - Pada halaman ganti kata sandi, masukkan password lama (NIS), password baru, dan konfirmasi password baru.

> **Catatan:** Jika lupa kata sandi, Admin dapat menggunakan fitur "Lupa Kata Sandi" untuk menerima link reset melalui email.

### 3.2 Dashboard Admin

#### 3.2.1 Akses Dashboard
Setelah login sebagai Admin, sistem otomatis mengarahkan ke dashboard admin (`/admin/dashboard` atau melalui redirect dari `/dashboard`).

#### 3.2.2 Komponen Dashboard Admin

Dashboard admin menampilkan ikhtisar penuh tentang sistem presensi:

1. **Header Selamat Datang**
   - Nama pengguna yang login.
   - Tanggal dan waktu saat ini (dengan update real-time setiap detik).
   - Hari ini (nama hari dalam bahasa Indonesia, format `d F Y`).

2. **Kartu Statistik Ringkas (6 kartu)**
   | Kartu | Deskripsi | Ikon | Warna |
   |-------|-----------|------|-------|
   | Total Santri Aktif | Jumlah total santri dengan status aktif | `fa-user-graduate` | Hijau |
   | Hadir Hari Ini | Jumlah santri hadir pada hari ini | `fa-check-circle` | Hijau |
   | Alpha Hari Ini | Jumlah santri tidak hadir tanpa keterangan | `fa-user-times` | Merah |
   | Izin Hari Ini | Jumlah santri yang izin | `fa-clipboard-check` | Kuning |
   | Sakit Hari Ini | Jumlah santri yang sakit | `fa-notes-medical` | Biru |
   | Total Denda Hari Ini | Jumlah denda yang tercatat hari ini | `fa-money-bill-wave` | Kuning |
   | Persentase Kehadiran | Persentase kehadiran hari ini | `fa-percentage` | Hijau |

3. **Ringkasan Bulan Ini**
   - Total Hadir, Total Alpha, Total Izin, Total Sakit (per bulan).
   - Total Denda bulan ini.
   - Rata-rata kehadiran bulan ini.
   - Santri terajin (jumlah hadir).

4. **Jadwal Hari Ini**
   - Menampilkan daftar jadwal pelajaran untuk hari ini, dipisahkan berdasarkan jenjang:
     - **Safinatunnajah (Kelas 1)** — daftar jadwal dengan nama, ustadz, dan jam.
     - **Muqodimah (Kelas 2)** — daftar jadwal dengan nama, ustadz, dan jam.
   - Jadwal yang sedang berlangsung (berdasarkan waktu aktual) akan ditandai dengan border hijau dan label "Sedang Berlangsung".
   - Garis waktu (timeline) visual pada paling atas yang menampilkan peradegan waktu dari pagi hingga malam.

5. **Aktivitas Terbaru**
   - Daftar 10 kegiatan kehadiran terbaru pada hari ini.
   - Setiap item menampilkan: nama santri, status (Hadir/Izin/Sakit/Alpha), dan waktu relatif (misal: "2 menit yang lalu").

6. **Grafik Batang (Bar Chart)**
   - Menampilkan tren kehadiran per bulan dalam setahun.
   - Empat dataset: Hadir (hijau), Alpha (merah), Izin (kuning), Sakit (biru).
   - Label sumbu X: Januari–Desember.

#### 3.2.3 Navigasi Menu Admin

| Menu | URL | Deskripsi |
|------|-----|-----------|
| **Dashboard** | `/admin/dashboard` | Ringkasan statistik kehadiran dan jadwal |
| **Santri** | `/santri` | Kelola data santri |
| **Presensi** | `/presensi` | Input dan edit presensi harian |
| **Rekap Presensi** | `/rekap/presensi` | Tabel rekap kehadiran per santri |
| **Rekap Denda** | `/rekap/denda` | Tabel rekap denda per santri |
| **Ranking** | `/rekap/ranking` | Ranking kehadiran santri |
| **Statistik** | `/statistik` | Grafik statistik kehadiran |
| **Laporan** | `/laporan` | Laporan presensi (HTML) + export PDF/Excel |
| **Jam Pelajaran** | `/jam-pelajaran` | Kelola jadwal pelajaran |
| **Kelola Pengguna** | `/users` | Kelola akun admin & petugas |
| **Pengaturan** | `/pengaturan` | Reset data dan template |
| **Profil** | `/profile` | Edit profil dan password |

### 3.3 Modul Data Santri (Admin)

#### 3.3.1 Menampilkan Daftar Santri
Halaman daftar santri (`/santri`) menampilkan tabel dengan kolom berikut:
- No, NIS, Nama, Jenjang (badge), Kelas, No. HP, Status (Aktif/Nonaktif)
- Tombol aksi: **Detail**, **Edit**, **Reset Password**, **Hapus**

**Filter:**
- **Pencarian** — berdasarkan Nama atau NIS
- **Jenjang** — pilih "Safinatunnajah" atau "Muqodimah"
- Data di paginasi 15 baris per halaman.

#### 3.3.2 Menambah Santri Baru
1. Klik tombol **"Tambah Santri"** pada halaman daftar.
2. Isi formulir:
   - **NIS** — wajib, unik.
   - **Nama** — wajib.
   - **Alamat** — opsional.
   - **No. HP** — opsional.
   - **Tanggal Lahir** — opsional (format date picker).
   - **Nama Orang Tua** — opsional.
   - **Khalaqoh** — wajib pilih antara "Safinatunnajah" atau "Muqodimah".
   - **Kelas** — opsional, pilih "Kelas 1" atau "Kelas 2".
3. Klik **"Simpan"**.
4. Sistem otomatis membuat akun User terkait dengan:
   - Password default = NIS
   - Role = `santri`
   - `must_change_password = true`
   - Santri diarahkan untuk ganti password pada login pertama.

#### 3.3.3 Melihat Detail Santri
Klik tombol **Detail** pada baris santri untuk melihat:
- Informasi lengkap: Nama, NIS, Khalaqoh, Kelas, Status, Alamat, No. HP, Nama Orang Tua.
- **Riwayat Absensi** — tabel dengan kolom:
  - Tanggal (format `d M Y`), Hari, Urutan (Jam ke-N), Status (badge), Denda.
- Data absensi di paginasi 30 baris per halaman.

#### 3.3.4 Mengedit Santri
1. Klik tombol **Edit** pada baris santri.
2. Ubah data sesuai kebutuhan.
3. Klik **"Simpan"**.
4. Sistem akan memperbarui data santri dan akun user terkait (nama dan NIS).

#### 3.3.5 Reset Password Santri
1. Klik tombol **"Reset Password"** pada baris santri.
2. Sistem akan mereset password ke NIS santri.
3. Santri dapat login kembali menggunakan NIS sebagai password.

#### 3.3.6 Menghapus Santri
1. Klik tombol **Hapus** pada baris santri.
2. Konfirmasi penghapusan.
3. Sistem akan menghapus akun User dan data Santri secara permanen.

### 3.4 Modul Presensi (Admin & Petugas)

#### 3.4.1 Halaman Input Presensi
Halaman presensi tersedia di:
- **Admin:** `/presensi`
- **Petugas:** `/petugas/presensi`

Halaman ini menampilkan:

1. **Header Presensi** — tanggal yang dipilih, nama hari, dan nama petugas yang login.

2. **Selector Tanggal** — date picker untuk memilih tanggal presensi. Kolom ini tidak dapat memilih tanggal di masa depan (maksimal hari ini). Perubahan tanggal otomatis merefresh halaman.

3. **Selector Jenjang** — dua kartu dapat diklik untuk memilih kelas:
   - **SAFINATUNNAJAH** (Kelas 1)
   - **MUQODIMAH** (Kelas 2)
   Klik kartu untuk beralih tampilan santri dan jadwal ke jenjang yang dipilih.

4. **Selector Jam Pelajaran** — dropdown untuk memilih sesi jam pelajaran yang sedang diajarkan. Daftar otomatis terisi berdasarkan hari yang sesuai dengan tanggal yang dipilih dan jenjang yang dipilih.

5. **Quick Actions** — dua tombol pintas:
   - **"Semua Hadir"** — mengatur semua status menjadi Hadir sekaligus.
   - **"Semua Alpha"** — mengatur semua status menjadi Alpha sekaligus.

6. **Tabel Presensi Santri** — kolom:
   - **Nama Santri** — nama lengkap santri.
   - **Jenjang** — badge warna (hijau untuk Muqodimah, biru untuk Safinatunnajah).
   - **Status Presensi** — grup radio button empat opsi:
     - ✓ Hadir (hijau)
     - ⚠ Izin (kuning)
     - ⚕ Sakit (ungu)
     - ✗ Alpha (merah)
   - **Keterangan** — kolom teks opsional untuk menambahkan catatan (misal: alasan izin/sakit/alpha).

7. **Tombol Simpan** — tombol dalam form untuk menyimpan semua perubahan sekaligus (berguna jika autosave dinonaktifkan atau sebagai backup).

#### 3.4.2 Mekanisme Input Presensi
1. Pilih tanggal pada date picker (halaman akan refresh).
2. Klik kartu jenjang yang diinginkan (Safinatunnajah atau Muqodimah).
3. Pilih sesi jam pelajaran dari dropdown.
4. Untuk setiap santri, klik radio button status kehadiran yang sesuai.
5. Jika diperlukan, isi kolom keterangan untuk status Izin/Sakit/Alpha.
6. Klik **"Simpan"** untuk menyimpan, atau biarkan autosave yang menangani penyimpanan otomatis.

Dukungan **Deselect:** Jika santri sudah memiliki status dan ingin menghapusnya, klik sekali lagi pada radio yang sudah terpilih — status akan dihapus dan denda yang terkait akan hilang.

#### 3.4.3 Fitur Autosave
- Ketika status kehadiran santri diubah (radio button diklik), sistem secara otomatis menyimpan perubahan melalui AJAX tanpa perlu menekan tombol Simpan.
- Endpoint: `POST /presensi/autosave` (admin) atau `POST /petugas/presensi/autosave` (petugas).
- Request dikirimkan berupa AJAX (XMLHttpRequest) dengan parameter: `jam_pelajaran_id`, `santri_id`, `status`, `keterangan`, `jenjang`, `tanggal`, dan `action` (`save` atau `deselect`).
- Respons berupa JSON: `{ "success": true }` atau `{ "success": false, "error": "..." }`.

#### 3.4.4 Pengeditan Presensi
- Halaman presensi yang sama digunakan untuk edit — cukup pilih tanggal yang sudah ada datanya pada date picker.
- Status yang sudah tersimpan akan otomatis terpilih (radio button ter-check) dan dapat langsung diubah.
- Penggunaan deselect (klik ulang radio yang sudah terpilih) akan menghapus entri absensi untuk santri-jam pelajaran-tanggal yang bersangkutan.

### 3.5 Modul Rekap (Admin)

#### 3.5.1 Rekap Presensi
Halaman: `/rekap/presensi`

Menampilkan tabel rekap kehadiran per santri untuk bulan yang dipilih, dengan kolom:
- **Ranking** — urutan berdasarkan jumlah hadir (terurut menurun).
- **Nama Santri**
- **NIS**
- **Jenjang**
- **Hadir** — jumlah kehadiran
- **Izin** — jumlah izin
- **Sakit** — jumlah sakit
- **Alpha** — jumlah alpha
- **Total** — total absensi
- **Persentase** — persentase kehadiran

**Filter:**
- Bulan (dropdown Januari–Desember)
- Tahun (dropdown)
- Kelas (dropdown: Safinatunnajah, Muqodimah)
- Pencarian berdasarkan nama

**Fitur Tambahan:**
- **Ekspor ke Excel** — tombol "Export Excel" untuk mengunduh file `.xlsx`.
- **Cetak** — tombol "Print" untuk mencetak halaman melalui browser.
- **Grafik Batang** — menampilkan 10 santai teratas berdasarkan jumlah hadir.

#### 3.5.2 Rekap Denda
Halaman: `/rekap/denda`

Menampilkan tabel denda per santri untuk bulan yang dipilih, dengan kolom:
- Tanggal
- Santri (Nama + NIS)
- Jenjang
- Status (Hadir/Izin/Sakit/Alpha)
- Denda (Rp)
- Status Pembayaran — tombol toggle untuk mengubah status `sudah_bayar` ↔ `belum_bayar`

**Filter:**
- Bulan dan tahun (dropdown)

**Interaksi:**
- Klik tombol status pembayaran untuk mengubah status secara real-time (AJAX).

#### 3.5.2.1 Panduan Merubah Status Pembayaran Denda

Untuk mengubah status pembayaran denda santri, ikuti langkah-langkah berikut:

**Langkah 1:** Login sebagai Admin, lalu buka halaman Rekap Denda melalui menu **Rekap → Denda** pada sidebar, atau akses langsung di `/rekap/denda`.

**Langkah 2:** Pada panel filter di bagian atas, pilih **Bulan** dan **Tahun** yang ingin diketahui rekap dendanya, lalu klik tombol **"Filter"**.

**Langkah 3:** Pada tabel hasil, temukan baris santri yang status pembayarannya ingin diubah. Setiap baris menampilkan kolom **Status Pembayaran** berupa badge:
- `Belum bayar` (warna merah/merah muda)
- `Sudah bayar` (warna hijau)

**Langkah 4:** Klik tombol/badge **Status Pembayaran** pada baris yang diinginkan. Sistem akan melakukan permintaan AJAX (XMLHttpRequest) ke endpoint `POST /rekap/denda/toggle-pembayaran` dengan body parameter `absensi_id`.

**Langkah 5:** Sistem memproses perubahan dan mengembalikan respons JSON:
```json
{
    "success": true,
    "status_pembayaran": "sudah_bayar",
    "message": "Denda sudah ditandai lunas"
}
```
atau
```json
{
    "success": true,
    "status_pembayaran": "belum_bayar",
    "message": "Denda dikembalikan ke belum bayar"
}
```

**Langkah 6:** Badge status pada tabel akan langsung diperbarui untuk mencerminkan perubahan — berubah dari "Belum bayar" menjadi "Sudah bayar" (atau sebaliknya) secara real-time tanpa perlu memuat ulang halaman.

> **Catatan penting:**
> - Perubahan status pembayaran tidak memengaruhi nilai denda itu sendiri; hanya menandai apakah denda sudah lunas dibayar atau belum.
> - Fitur ini hanya tersedia untuk peran **Admin**.
> - Total denda keseluruhan yang ditampilkan di bagian atas halaman akan otomatis terupdate saat status pembayaran berubah.

#### 3.5.3 Ranking
Halaman: `/rekap/ranking`

Route ini akan **mengarahkan redirect ke halaman `/rekap/presensi`** (fitur ranking sudah diintegrasikan dalam rekap presensi).

### 3.6 Modul Laporan (Admin)

Halaman: `/laporan`

#### 3.6.1 Laporan Presensi (HTML)
Halaman ini menampilkan tabel rekap presensi semua santri untuk bulan dan tahun yang dipilih, mirip dengan rekap presensi namun dengan tampilan berbeda.

**Kolom Tabel:**
- Nama Santri, NIS, Jenjang, Hadir, Izin, Sakit, Alpha, Total

**Filter:**
- Bulan (dropdown)
- Tahun (dropdown)

#### 3.6.2 Ekspor Laporan PDF

Terdapat empat jenis laporan PDF yang dapat diekspor:

| Fitur | URL | File PDF | Deskripsi |
|-------|-----|---------|-----------|
| **Laporan Rekap** | `/laporan/pdf-rekap` | `rekap-absensi-{bulan}-{tahun}.pdf` | Rekap kehadiran semua santri per bulan |
| **Laporan Denda** | `/laporan/pdf-denda` | `laporan-denda-{bulan}-{tahun}.pdf` | Rekap denda santri yang memiliki denda > 0 |
| **Laporan Ranking** | `/laporan/pdf-ranking` | `ranking-kehadiran.pdf` | Ranking 10 santri terbaik berdasarkan kehadiran |
| **Laporan Lengkap** | `/laporan/pdf-complete` | `laporan-selesai-{bulan}-{tahun}.pdf` | Gabungan: rekap presensi, denda, dan ranking |

**Parameter Filter PDF:**
- `bulan` (angka 1–12)
- `tahun` (angka, contoh: 2026)

### 3.7 Modul Statistik (Admin)

Halaman: `/statistik`

#### 3.7.1 Komponen Statistik

1. **Kartu Statistik Ringkas (4 kartu)**
   - Total Absensi (jumlah semua catatan hadir tidak-hadir)
   - Hadir (jumlah)
   - Tidak Hadir (izin + sakit + alpha)
   - Total Denda (Rp)

2. **Diagram Donat (Pie Chart)**
   - Menampilkan distribusi kehadiran: Hadir (hijau), Izin (kuning), Sakit (biru), Alpha (merah).
   - Setiap segmen menampilkan persentase.

3. **Diagram Batang (Bar Chart)**
   - Menampilkan kehadiran harian (Hadir, Izin, Sakit, Alpha) untuk setiap hari dalam bulan yang dipilih.

**Filter:**
- Bulan (dropdown)
- Tahun (dropdown)
- Tombol "Filter" untuk menerapkan perubahan.

### 3.8 Modul Jam Pelajaran (Admin)

Halaman: `/jam-pelajaran`

#### 3.8.1 Daftar Jadwal
Halaman ini menampilkan tabel semua jadwal pelajaran yang terdaftar, diurutkan berdasarkan hari, kelas, dan urutan.

**Kolom Tabel:**
- Hari, Kelas/Jenjang, Urutan, Nama Mata Pelajaran, Ustadz, Jam Mulai, Jam Selesai, Status (Aktif/Tidak Aktif)
- Tombol aksi: **Edit**, **Hapus**

#### 3.8.2 Menambah Jadwal Baru
1. Klik tombol **"Tambah Jam Pelajaran"**.
2. Isi formulir:
   - **Nama Mata Pelajaran** — contoh: Fiqh, Tafsir, dll.
   - **Ustadz** — nama ustadz pengajar.
   - **Jam Mulai** — format `HH:MM`.
   - **Jam Selesai** — format `HH:MM` (harus setelah jam mulai).
   - **Hari** — dropdown Senin–Minggu.
   - **Urutan** — nomor urut sesi (harus unik untuk kombinasi hari + kelas).
   - **Kelas (Jenjang)** — Safinatunnajah atau Muqodimah.
   - **Aktif** — checkbox (dicentang secara default).
3. Klik **"Simpan"**.

#### 3.8.3 Mengedit Jadwal
1. Klik tombol **Edit** pada baris jadwal.
2. Ubah data sesuai kebutuhan.
3. Klik **"Update"**.

#### 3.8.4 Menghapus Jadwal
1. Klik tombol **Hapus** pada baris jadwal.
2. Konfirmasi penghapusan.

### 3.9 Modul Kelola Pengguna (Admin)

Halaman: `/users`

#### 3.9.1 Daftar Pengguna
Menampilkan tabel semua pengguna sistem, dengan kolom:
- Nama, Peran (role), NIS/Username, Email, Status Verifikasi Email, Aksi

**Filter:**
- Pencarian berdasarkan nama, NIS, atau username.
- Filter berdasarkan peran (role).

#### 3.9.2 Reset Password Pengguna
1. Klik tombol **"Reset Password"** pada baris pengguna.
2. Sistem akan mereset password:
   - Untuk Petugas: password di-reset ke `password123`.
   - Untuk Santri: password di-reset ke NIS.
   - Untuk Admin: tidak dapat mereset password sendiri.
3. Password baru akan ditampilkan dalam notifikasi.

### 3.10 Modul Pengaturan (Admin)

Halaman: `/pengaturan`

#### 3.10.1 Fitur Reset Data Absensi
- **Reset Presensi** — menghapus seluruh data absensi dari database.
- Wajib ketik `"YA"` pada field konfirmasi untuk melanjutkan.
- ⚠️ **Peringatan:** Operasi ini tidak dapat dibatalkan!

#### 3.10.2 Fitur Reset Data Santri
- **Reset Santri** — menghapus seluruh data santri dari database.
- Wajib ketik `"YA"` pada field konfirmasi untuk melanjutkan.
- ⚠️ **Peringatan:** Operasi ini tidak dapat dibatalkan! Semua akun santri akan hilang.

#### 3.10.3 Unduh Template Santri
- Tombol **"Unduh Template"** (route `/pengaturan/template-santri`) untuk mengunduh file template Excel yang dapat digunakan untuk impor massal data santri.

### 3.11 Modul Profil

#### 3.11.1 Profil Admin/Petugas
Halaman: `/profile` (Admin) atau `/petugas/profile` (Petugas)

Fitur:
- Edit nama, email, dan informasi akun.
- Ganti kata sandi (jika diperlukan).
- Hapus akun (konfirmasi password diperlukan).

Formulir ini menggunakan komponen Laravel Breeze (partial view) dengan struktur:
- `update-profile-information-form` — update nama dan email.
- `update-password-form` — ganti kata sandi.
- `delete-user-form` — hapus akun.

#### 3.11.2 Profil Santri
Halaman: `/santri/profile`

Menampilkan:
- **Avatar** — inisial nama pengguna (lingkaran berwarna hijau).
- **Nama Lengkap**, **NIS**, **Kelas**, **Jenjang/Khalaqoh**, **Status** (Aktif/Nonaktif).
- **No. HP**, **Alamat**, **Nama Orang Tua** (jika tersedia).
- **Formulir Ganti Password** — tiga field: Password Saat Ini, Password Baru, Konfirmasi Password Baru.

### 3.12 Dashboard Santri

#### 3.12.1 Akses
- URL: `/santri/dashboard`
- Dapat diakses setelah login sebagai Santri.

#### 3.12.2 Komponen Dashboard Santri

Dashboard Santri dirancang dengan tema hijau (warna Madrasah Al-Asy'ariyyah) dan menampilkan:

1. **Header Selamat Datang**
   - Nama santri (tersambung dengan data User).
   - Sapaan: "Semoga hari ini menjadi hari yang produktik untuk belajar dan beribadah."
   - Tanggal dan waktu real-time (clock digital update setiap detik via JavaScript `setInterval`).

2. **Ringkasan Statistik Saya (6 kartu)**
   Semua karti ini menampilkan data statistik untuk **bulan berjalan**:

   | Kartu | Deskripsi | Warna Ikon | Variabel pada View |
   |-------|-----------|------------|---------------------|
   | Total Hadir | Jumlah kehadiran bulan ini (`$totalHadirBulan`) | Hijau | `fa-check-circle` |
   | Total Alpha | Jumlah alpha bulan ini (`$totalAlphaBulan`) | Merah | `fa-user-times` |
   | Total Izin | Jumlah izin bulan ini (`$totalIzinBulan`) | Kuning | `fa-clipboard-check` |
   | Total Sakit | Jumlah sakit bulan ini (`$totalSakitBulan`) | Biru | `fa-notes-medical` |
   | Total Denda Bulan Ini | Total denda bulan ini (`$totalDendaBulan`) | Kuning | `fa-money-bill-wave` |
   | Persentase Kehadiran | Persentase kehadiran bulan ini (`$persentaseKehadiranBulan`) | Hijau | `fa-percentage` |

3. **Status Kehadiran Terbaru**
   - Menampilkan status kehadiran **hari ini** jika ada data absensi untuk tanggal yang sama (`$todayAttendance`).
   - Badge status berwarna: Hijau (Hadir), Kuning (Izin), Biru (Sakit), Merah (Alpha).
   - Jika status bukan "Hadir" dan ada denda, nilai denda akan ditampilkan di sebelah badge.
   - Jika belum ada data kehadiran hari ini, akan menampilkan empty state dengan ilustrasi kalender.

4. **Posisi Ranking Kehadiran**
   - Kartu dengan latar belakang gradien hijau–biru (`linear-gradient(135deg, #059669, #0d9488)`).
   - Menampilkan **nomor posisi ranking** santri bulan ini (`{{ $santriRanking['position'] }}`).
   - Di bawahnya: jumlah kehadiran dan persentase (`{{ $santriRanking['total_hadir'] }} kehadiran • {{ $santriRanking['persentase'] }}% persentase`).
   - Jika belum ada data ranking, posisi akan menampilkan "-".

5. **Distribusi Kehadiran Bulan Ini (Diagram Donat)**
   - ApexCharts donut chart dengan 4 warna: Hijau (Hadir), Merah (Alpha), Kuning (Izin), Biru (Sakit).
   - Data dari variabel `$totalHadirBulan`, `$totalAlphaBulan`, `$totalIzinBulan`, `$totalSakitBulan`.

6. **Aktivitas Kehadiran Terbaru (max 5)**
   - Daftar 5 aktivitas kehadiran terbaru (diambil dari query `Absensi` yang diurutkan berdasarkan `tanggal desc, updated_at desc`).
   - Setiap item menampilkan:
     - Badge status berwarna (lingkaran dengan ikon).
     - Nama status (Hadir/Izin/Sakit/Alpha).
     - Tanggal (format `d M Y`).
     - Denda (jika > 0, ditampilkan dengan format `Rp number_format`).
   - Jika tidak ada aktivitas, menampilkan empty state dengan ilustrasi kalender.

### 3.13 Fitur Santri Lainnya

#### 3.13.1 Riwayat Presensi Saya
- URL: `/santri/attendance`
- Menampilkan tabel riwayat kehadiran pribadi.
- **Filter:** Bulan, Tahun, Status (Hadir/Izin/Sakit/Alpha).
- **Kolom:** Tanggal, Jam Pelajaran, Status, Keterangan.

#### 3.13.2 Rekap Denda Saya
- URL: `/santri/fine`
- Menampilkan:
  - **Total Denda Keseluruhan** (kartu dengan gradien hijau–kuning).
  - **Statistik Bulan Ini:** Denda bulan ini, jumlah alpha, izin, sakit.
  - **Riwayat Denda** — tabel dengan kolom: Tanggal, Status, Nominal Denda, Status Pembayaran.

#### 3.13.3 Ranking Kehadiran
- URL: `/santri/ranking`
- Menampilkan:
  - **Posisi Saya** — kartu dengan nomor posisi dan label.
  - **Tabel Ranking** — 10 santri teratas dengan kolom: Ranking, Nama, NIS, Kelas, Hadir, Persentase.
  - Santri yang sedang login akan ditandai dengan highlight hijau dan label "Anda".

#### 3.13.4 Statistik Kehadiran
- URL: `/santri/statistics`
- Menampilkan:
  - **Grafik Area:** Kehadiran per bulan dalam setahun (4 series: Hadir, Alpha, Izin, Sakit).
  - **Diagram Donat:** Distribusi kehadiran bulan ini.
  - **Persentase Kehadiran Tahun Ini** — progress bar dengan label.

---

# BAB IV
## PENJELASAN FITUR DAN ATURAN SISTEM

### 4.1 Model dan Aturan Denda

Denda dihitung secara otomatis oleh sistem melalui lifecycle event model `Absensi` (`app/Models/Absensi.php`):

```php
// Saat membuat (creating)
static::creating(function ($absensi) {
    $absensi->denda = self::getDendaForStatus($absensi->status);
});

// Saat memperbarui (updating)
static::updating(function ($absensi) {
    $absensi->denda = self::getDendaForStatus($absensi->status);
});
```

**Metode `getDendaForStatus`:**
| Input Status | Output Denda |
|-------------|-------------|
| `hadir` | 0 |
| `izin` | 2.000 |
| `sakit` | 2.000 |
| `alpha` | 5.000 |

### 4.2 Status Pembayaran Denda

Setiap catatan absensi memiliki kolom `status_pembayaran` yang dapat bernilai:
- `belum_bayar` — denda belum lunas (default)
- `sudah_bayar` — denda sudah dibayar/lunas

**Pengelolaan:**
- Di halaman Rekap Denda (`/rekap/denda`), Admin dapat mengklik tombol status pembayaran untuk mengganti status secara real-time melalui AJAX.
- Endpoint: `POST /rekap/denda/toggle-pembayaran` dengan parameter `absensi_id`.

### 4.3 Aturan Login Santri

Aturan login khusus untuk Santri:
1. Santri login menggunakan **NIS** (bukan email/username).
2. Pada pembuatan akun pertama, password di-hash dengan nilai NIS (`Hash::make($santri->nis)`).
3. Flag `must_change_password` di-set ke `true`.
4. Setelah berhasil login, jika `must_change_password` masih `true`, sistem akan otomatis mengarahkan ke halaman ganti password (`/santri/password/change`).
5. Pada halaman ganti password, santri wajib memasukkan:
   - Password lama (NIS)
   - Password baru (min 8 karakter)
   - Konfirmasi password baru
6. Setelah berhasil ganti password, `must_change_password` di-set ke `false` dan santri dapat mengakses dashboard penuh.

### 4.4 Perhitungan Jumlah Pertemuan

Sistem menghitung jumlah pertemuan potensial per bulan berdasarkan aturan berikut (`RekapController::calculateTotalPertemuan()`):

| Hari | Jumlah Sesi per Hari |
|------|---------------------|
| Senin | 3 |
| Selasa | 3 |
| Rabu | 3 |
| Kamis | 3 |
| Jumat | 1 |
| Sabtu | 3 |
| Minggu | 0 |

**Total pertemuan per bulan** = Jumlah sesi semua hari dalam bulan tersebut.

Rumus ini digunakan untuk menghitung **persentase kehadiran**:
```
Persentase = (Total Hadir / Total Pertemuan) × 100
```

### 4.5 Fitur Autosave Presensi

Fitur ini memungkinkan Petugas/Admin untuk mengubah status kehadiran santri secara real-time tanpa perlu klik tombol simpan eksternal.

**Endpoint:**
- Admin: `POST /presensi/autosave`
- Petugas: `POST /petugas/presensi/autosave`

**Request:**
```json
{
    "tanggal": "2026-10-14",
    "santri_id": 5,
    "jam_pelajaran_id": 12,
    "status": "hadir"
}
```

**Respons:**
```json
{
    "success": true,
    "message": "Presensi berhasil disimpan"
}
```

### 4.6 Fitur Reset Password Santri

Admin dapat mereset password Santri kapan saja:
- Password akan dikembalikan ke NIS asli Santri.
- Santri dapat login langsung dengan NIS sebagai password.
- Flag `must_change_password` tidak diubah (tetap `true` atau `false` tergantung sebelumnya).

Endpoint: `POST /santri/{santri}/reset-password`

### 4.7 Fitur Lupa Password Admin

Admin dapat mereset password melalui email:
1. Buka halaman `/admin/forgot-password`.
2. Masukkan **username** dan **email verifikasi** (wajib cocok dengan email terdaftar di akun admin).
3. Sistem mengirimkan link reset ke email terdaftar.
4. Buka link reset, masukkan password baru dan konfirmasi.

> **Catatan:** Fitur ini hanya tersedia untuk akun dengan role `admin`. Email harus telah dikonfigurasi di `.env`.

### 4.8 Navigasi Sidebar

Setiap halaman menggunakan layout yang sama dengan sidebar (navigation) yang menampilkan menu sesuai peran pengguna. Menu dinamis akan menjadi aktif (highlight) ketika pengguna berada pada halaman terkait.

### 4.9 Respons Error dan Validasi

| Skenario | Respons Sistem |
|----------|---------------|
| NIS duplikat saat tambah/edit santri | Error: `"NIS sudah terdaftar"` |
| NIS tidak diisi | Error: `"NIS wajib diisi"` |
| Nama tidak diisi | Error: `"Nama wajib diisi"` |
| Jenjang tidak dipilih | Error: `"Jenjang wajib dipilih"` |
| Jam selesai sebelum jam mulai | Error: `"Jam selesai harus setelah jam mulai"` |
| Urutan duplikat untuk hari + kelas yang sama | Error: `"Urutan untuk hari dan kelas ini sudah digunakan"` |
| Password salah saat ganti | Error: `"Password saat ini salah."` |

### 4.10 Fitur Pencarian dan Filter

Sistem menyediakan mekanisme pencarian dan filter di beberapa modul:

| Modul | Fitur Pencarian | Fitur Filter |
|-------|-----------------|-------------|
| Santri | Nama, NIS | Jenjang |
| Presensi | - | Tanggal, Jenjang |
| Rekap Presensi | Nama santri | Bulan, Tahun, Kelas |
| Rekap Denda | - | Bulan, Tahun |
| Statistik | - | Bulan, Tahun |
| Laporan | - | Bulan, Tahun |
| Kelola Pengguna | Nama, NIS, Username | Role |
| Santri: Riwayat | - | Bulan, Tahun, Status |
| Santri: Denda | - | Bulan, Tahun |

### 4.11 Paginasi

Sistem menerapkan paginasi untuk tabel yang menampilkan banyak data:

| Modul | Item per Halaman |
|-------|-----------------|
| Daftar Santri | 15 |
| Detail Santri (Riwayat Absensi) | 30 |
| Santri (attendance) | 15 |
| Santri (fine/rekap denda pribadi) | 15 |
| Kelola Pengguna | 20 |

### 4.12 Export dan Download

| Fitur | Ekstensi | Route | Controller |
|-------|---------|-------|------------|
| Export Rekap Presensi | `.xlsx` | `/rekap/presensi/export` | RekapController@exportExcel |
| Print Rekap Presensi | HTML Print | `/rekap/presensi/print` | RekapController@print |
| PDF Rekap | `.pdf` | `/laporan/pdf-rekap` | LaporanController@pdfRekap |
| PDF Denda | `.pdf` | `/laporan/pdf-denda` | LaporanController@pdfDenda |
| PDF Ranking | `.pdf` | `/laporan/pdf-ranking` | LaporanController@pdfRanking |
| PDF Laporan Lengkap | `.pdf` | `/laporan/pdf-complete` | LaporanController@pdfComplete |
| Template Santri | `.xlsx` | `/pengaturan/template-santri` | PengaturanController@exportTemplateSantri |

---

## LAMPIRAN A: DIAGRAM ENTITY-RELATIONSHIP

```
┌─────────────────────────────────────────────────────────────┐
│                          users                              │
├─────────────────────────────────────────────────────────────┤
│ PK  id                          BIGINT(20)  AUTO_INCREMENT  │
│     name                        VARCHAR(255)                │
│     email                       VARCHAR(255)  NULL          │
│     email_verified_at           TIMESTAMP  NULL             │
│     password                    VARCHAR(255)                │
│     role                        ENUM        DEFAULT 'santri'│
│     nis                         VARCHAR(255)  NULL          │
│     must_change_password        BOOLEAN    DEFAULT false    │
│     username                    VARCHAR(255)  NULL          │
│     remember_token              VARCHAR(100)  NULL          │
│     timestamps                                                    │
└─────────────────────────────────────────────────────────────┘
         │ 1:1 (hasOne)
         │
┌─────────────────────────────────────────────────────────────┐
│                          santri                              │
├─────────────────────────────────────────────────────────────┤
│ PK  id                          BIGINT(20)  AUTO_INCREMENT  │
│     nis                         VARCHAR(255) UNIQUE         │
│     nama                        VARCHAR(255)                │
│     alamat                      TEXT          NULL          │
│     no_hp                       VARCHAR(20)   NULL          │
│     tanggal_lahir               DATE          NULL          │
│     nama_orang_tua              VARCHAR(255)  NULL          │
│     jenjang                    ENUM('Safinatunnajah','Muqodimah')│
│     kelas                       VARCHAR(50)   NULL          │
│     status                      BOOLEAN    DEFAULT true     │
│     timestamps                                                    │
└─────────────────────────────────────────────────────────────┘
         │ 1:M (hasMany)
         │
┌─────────────────────────────────────────────────────────────┐
│                         absensi                             │
├─────────────────────────────────────────────────────────────┤
│ PK  id                          BIGINT(20)  AUTO_INCREMENT  │
│ FK  santri_id                   BIGINT(20)                │
│ FK  jam_pelajaran_id            BIGINT(20)  NULL          │
│ FK  user_id                     BIGINT(20)                │
│     tanggal                     DATE                        │
│     hari                        VARCHAR(20)                 │
│     status                     ENUM('hadir','izin','sakit','alpha')│
│     denda                       INTEGER    DEFAULT 0       │
│     keterangan                  TEXT  NULL                  │
│     status_pembayaran          VARCHAR(20) DEFAULT 'belum_bayar'│
│     timestamps                                                    │
└─────────────────────────────────────────────────────────────┘
         │ M:1 (belongsTo)
         │
┌─────────────────────────────────────────────────────────────┐
│                     jam_pelajaran                           │
├─────────────────────────────────────────────────────────────┤
│ PK  id                          BIGINT(20)  AUTO_INCREMENT  │
│     nama                        VARCHAR(255)                │
│     ustadz                      VARCHAR(255)                │
│     jam_mulai                   TIME                        │
│     jam_selesai                 TIME                        │
│     hari                        VARCHAR(20)                 │
│     urutan                      INTEGER                     │
│     status                      BOOLEAN  DEFAULT true      │
│     kelas                      ENUM('Safinatunnajah','Muqodimah')│
│     timestamps                                                    │
└─────────────────────────────────────────────────────────────┘
         │ 1:M (hasMany)
         │ (ke absensi)
```

**Relasi:**
- `User` → `Santri` (HasOne melalui `santri_id`)
- `Santri` → `Absensi` (HasMany)
- `JamPelajaran` → `Absensi` (HasMany)
- `User` → `Absensi` (HasMany melalui `user_id`)

### Tabel Pendukung
- `password_reset_tokens` — token reset password (email, token, created_at)
- `sessions` — session pengguna

## LAMPIRAN B: DIAGRAM ALUR

### B.1 Alur Login
```
[Pengguna membuka /login]
        │
        ▼
[Memasukkan NIS/Username + Password]
        │
        ├──[Validation gagal]──→ [Kembali ke form, error message]
        │
        ▼
[Auth::attempt()]
        │
        ├──[Auth gagal]──→ [Kembali ke form, "NIS/Username atau Password salah"]
        │
        ▼
[Auth berhasil]
        │
        ├──[Role = santri AND must_change_password = true]
        │       └──→ [Redirect ke /santri/password/change]
        │               └── [Setelah ganti password berhasil]
        │                     └──→ [Ke Dashboard Santri]
        │
        ├──[Role = admin]
        │       └──→ [Redirect ke /admin/dashboard]
        │
        └──[Role = petugas]
                └──→ [Redirect ke /petugas/dashboard]
```

### B.2 Alur Presensi (Admin/Petugas)
```
[Buka /presensi]
        │
        ▼
[Pilih tanggal pada date picker]
        │
        ▼
[Pilih jenjang: Semua/Safinatunnajah/Muqodimah]
        │
        ▼
[Lihat tabel santri dengan kolom jam pelajaran]
        │
        ├──[Centang/ubah checkbox status kehadiran]
        │       └──→ [Autosave: POST /presensi/autosave]
        │               └── [Response JSON: success/error]
        │
        ▼
[Klik "Simpan"]
        │
        ▼
[POST /presensi (store)]
        │
        ▼
[Seluruh data absensi disimpan ke database]
        │
        ▼
[Redirect ke /presensi dengan notifikasi sukses]
```

### B.3 Alur Edit Presensi
```
[Klik "Edit Presensi" pada halaman /presensi]
        │
        ▼
[Buka /presensi/edit]
        │
        ▼
[Pilih tanggal]
        │
        ▼
[Tampilkan form edit dengan data absensi yang ada]
        │
        ▼
[Ubah status kehadiran]
        │
        ▼
[Klik "Simpan Perubahan"]
        │
        ▼
[PUT /presensi/{tanggal}]
        │
        ▼
[Data absensi diperbarui di database]
        │
        ▼
[Redirect ke /presensi dengan notifikasi sukses]
```

### B.4 Alur Reset Denda
```
[Buka /rekap/denda]
        │
        ▼
[Lihat tabel denda santri]
        │
        ▼
[Klik tombol status pembayaran]
        │
        ▼
[POST /rekap/denda/toggle-pembayaran]
        │
        ▼
[Status berubah: sudah_bayar ↔ belum_bayar]
        │
        ▼
[Response JSON: success + status baru]
```

### B.5 Alur Export / PDF
```
[Buka halaman terkait (rekap/laporan/statistik)]
        │
        ▼
[Pilih filter: bulan, tahun, kelas]
        │
        ▼
[Klik tombol "Export Excel" / "Export PDF"]
        │
        ▼
[System menghasilkan file]
        │
        ▼
[File diunduh otomatis]
```

## LAMPIRAN C: DAFTAR ROUTE LENGKAP

### Akses Umum (Tanpa Auth)
| Method | URL | Route Name | Keterangan |
|--------|-----|------------|-----------|
| GET | `/` | - | Redirect ke `/login` |
| GET | `/login` | `login` | Halaman login |
| POST | `/login` | - | Proses login |
| POST | `/logout` | `logout` | Logout |
| GET | `/admin/forgot-password` | `admin.password.request` | Form lupa password admin |
| POST | `/admin/forgot-password` | `admin.password.email` | Kirim link reset |
| GET | `/reset-password/{token}` | `password.reset` | Form reset password |
| POST | `/reset-password` | `password.store` | Simpan password baru |
| PUT | `/password` | `password.update` | Update password (admin/petugas) |
| POST | `/login-test` | - | Dev helper login |
| GET | `/dev-santri` | - | Dev helper login santri NIS 0001 |

### Dashboard
| Method | URL | Route Name | Middleware | Role |
|--------|-----|------------|------------|------|
| GET | `/dashboard` | `dashboard` | auth | Semua |
| GET | `/admin/dashboard` | `admin.dashboard` | auth, role:admin | Admin |
| GET | `/petugas/dashboard` | `petugas.dashboard` | auth, role:petugas | Petugas |
| GET | `/santri/dashboard` | `santri.dashboard` | auth, role:santri | Santri |

### Data Santri
| Method | URL | Route Name | Middleware | Action |
|--------|-----|------------|------------|--------|
| GET | `/santri` | `santri.index` | auth, role:admin | Daftar santri |
| GET | `/santri/create` | `santri.create` | auth, role:admin | Form tambah |
| POST | `/santri` | `santri.store` | auth, role:admin | Simpan santri |
| GET | `/santri/{santri}` | `santri.show` | auth, role:admin | Detail santri |
| GET | `/santri/{santri}/edit` | `santri.edit` | auth, role:admin | Form edit |
| PUT | `/santri/{santri}` | `santri.update` | auth, role:admin | Update santri |
| DELETE | `/santri/{santri}` | `santri.destroy` | auth, role:admin | Hapus santri |
| POST | `/santri/{santri}/reset-password` | `santri.reset-password` | auth, role:admin | Reset password |

### Presensi
| Method | URL | Route Name | Middleware | Role | Action |
|--------|-----|------------|------------|------|--------|
| GET | `/presensi` | `presensi.index` | auth, role:admin | Admin | Input presensi |
| GET | `/presensi/safinatunnajah` | `presensi.safinatunnajah` | auth, role:admin | Admin | Presensi Kelas 1 |
| GET | `/presensi/muqodimah` | `presensi.muqodimah` | auth, role:admin | Admin | Presensi Kelas 2 |
| POST | `/presensi` | `presensi.store` | auth, role:admin | Admin | Simpan presensi |
| POST | `/presensi/autosave` | `presensi.autosave` | auth, role:admin | Admin | Autosave |
| GET | `/presensi/edit` | `presensi.edit` | auth, role:admin | Admin | Form edit |
| PUT | `/presensi/{tanggal}` | `presensi.update` | auth, role:admin | Admin | Update presensi |
| GET | `/petugas/presensi` | `petugas.presensi.index` | auth, role:petugas | Petugas | Input presensi |
| GET | `/petugas/presensi/safinatunnajah` | `petugas.presensi.safinatunnajah` | auth, role:petugas | Petugas | Presensi Kelas 1 |
| GET | `/petugas/presensi/muqodimah` | `petugas.presensi.muqodimah` | auth, role:petugas | Petugas | Presensi Kelas 2 |
| POST | `/petugas/presensi` | `petugas.presensi.store` | auth, role:petugas | Petugas | Simpan presensi |
| POST | `/petugas/presensi/autosave` | `petugas.presensi.autosave` | auth, role:petugas | Petugas | Autosave |
| GET | `/petugas/presensi/edit` | `petugas.presensi.edit` | auth, role:petugas | Petugas | Form edit |
| PUT | `/petugas/presensi/{tanggal}` | `petugas.presensi.update` | auth, role:petugas | Petugas | Update presensi |

### Rekap & Statistik
| Method | URL | Route Name | Middleware | Role |
|--------|-----|------------|------------|------|
| GET | `/rekap/presensi` | `rekap.presensi` | auth, role:admin | Admin |
| GET | `/rekap/presensi/export` | `rekap.presensi.export` | auth, role:admin | Admin |
| GET | `/rekap/presensi/print` | `rekap.presensi.print` | auth, role:admin | Admin |
| GET | `/rekap/denda` | `rekap.denda` | auth, role:admin | Admin |
| POST | `/rekap/denda/toggle-pembayaran` | `rekap.denda.toggle-pembayaran` | auth, role:admin | Admin |
| GET | `/rekap/ranking` | `rekap.ranking` | auth, role:admin | Admin |
| GET | `/statistik` | `statistik.index` | auth, role:admin | Admin |

### Laporan
| Method | URL | Route Name | Middleware | Action |
|--------|-----|------------|------------|--------|
| GET | `/laporan` | `laporan.presensi` | auth, role:admin | Laporan presensi HTML |
| GET | `/laporan/pdf-rekap` | `laporan.pdf-rekap` | auth, role:admin | Export PDF rekap |
| GET | `/laporan/pdf-denda` | `laporan.pdf-denda` | auth, role:admin | Export PDF denda |
| GET | `/laporan/pdf-ranking` | `laporan.pdf-ranking` | auth, role:admin | Export PDF ranking |
| GET | `/laporan/pdf-complete` | `laporan.pdf-complete` | auth, role:admin | Export PDF lengkap |

### Jam Pelajaran
| Method | URL | Route Name | Middleware | Action |
|--------|-----|------------|------------|--------|
| GET | `/jam-pelajaran` | `jam-pelajaran.index` | auth, role:admin | Daftar jadwal |
| GET | `/jam-pelajaran/create` | `jam-pelajaran.create` | auth, role:admin | Form tambah |
| POST | `/jam-pelajaran` | `jam-pelajaran.store` | auth, role:admin | Simpan |
| GET | `/jam-pelajaran/{jamPelajaran}/edit` | `jam-pelajaran.edit` | auth, role:admin | Form edit |
| PUT | `/jam-pelajaran/{jamPelajaran}` | `jam-pelajaran.update` | auth, role:admin | Update |
| DELETE | `/jam-pelajaran/{jamPelajaran}` | `jam-pelajaran.destroy` | auth, role:admin | Hapus |

### Profil & Pengguna
| Method | URL | Route Name | Middleware | Role |
|--------|-----|------------|------------|------|
| GET | `/profile` | `profile.edit` | auth, role:admin | Admin |
| PATCH | `/profile` | `profile.update` | auth, role:admin | Admin |
| DELETE | `/profile` | `profile.destroy` | auth, role:admin | Admin |
| GET | `/users` | `users.index` | auth, role:admin | Admin |
| POST | `/users/{user}/reset-password` | `users.reset-password` | auth, role:admin | Admin |
| GET | `/petugas/profile` | `petugas.profile.edit` | auth, role:petugas | Petugas |
| PATCH | `/petugas/profile` | `petugas.profile.update` | auth, role:petugas | Petugas |
| GET | `/santri/profile` | `santri.profile` | auth, role:santri | Santri |
| PATCH | `/santri/profile/password` | `santri.password.update` | auth, role:santri | Santri |
| GET | `/santri/profile/edit` | `santri.profile.edit` | auth, role:santri | Santri |
| PATCH | `/santri/profile` | `santri.profile.update` | auth, role:santri | Santri |
| DELETE | `/santri/profile` | `santri.profile.destroy` | auth, role:santri | Santri |

### Fitur Santri
| Method | URL | Route Name | Middleware | Controller |
|--------|-----|------------|------------|------------|
| GET | `/santri/attendance` | `santri.attendance` | auth, role:santri | Santri\AttendanceController |
| GET | `/santri/fine` | `santri.fine` | auth, role:santri | Santri\FineController |
| GET | `/santri/ranking` | `santri.ranking` | auth, role:santri | Santri\RankingController |
| GET | `/santri/statistics` | `santri.statistics` | auth, role:santri | Santri\StatisticsController |

### Pengaturan
| Method | URL | Route Name | Middleware | Action |
|--------|-----|------------|------------|--------|
| GET | `/pengaturan` | `pengaturan.index` | auth, role:admin | Halaman pengaturan |
| POST | `/pengaturan/reset-presensi` | `pengaturan.reset-presensi` | auth, role:admin | Reset data absensi |
| GET | `/pengaturan/template-santri` | `pengaturan.template-santri` | auth, role:admin | Unduh template |
| POST | `/pengaturan/reset-santri` | `pengaturan.reset-santri` | auth, role:admin | Reset data santri |

---

*Manual Book ini disusun sebagai dokumentasi resmi Sistem Informasi Presensi Santri Madrasah Diniyah Al-Asy'ariyyah. Untuk pertanyaan lebih lanjut, silakan menghubungi tim pengembang sistem.*