# BAB 3
# TINJAUAN UMUM

---

## 3.1 Gambaran Umum Perusahaan/Instansi

### 3.1.1 Profil Instansi

Pondok Pesantren Tahfidzul Qur'an Al-Asy'ariyyah merupakan lembaga pendidikan Islam yang berlokasi di Desa Kalibeber, Mojotengah, Wonosobo. Pondok pesantren ini berfokus pada pendidikan agama Islam dengan penekanan pada tahfidzul Qur'an (hafalan Al-Qur'an) serta pendidikan umum berbasis salaf (tradisional) dan modern.

### 3.1.2 Visi dan Misi

Visi dan misi institusi belum dapat didokumentasikan secara detail karena batasan akses informasi internal. Namun berdasarkan struktur dan sistem yang berjalan, institusi ini menempatkan pendidikan karakter dan keilmuan agama Islam sebagai prioritas utama.

### 3.1.3 Struktur Organisasi

Struktur organisasi Pondok Pesantren Tahfidzul Qur'an Al-Asy'ariyyah dipimpin oleh seorang **Pembina** yang bertanggung jawab atas pengelolaan seluruh kegiatan pondok.

| Jabatan | Nama | Keterangan |
|---------|------|------------|
| Pembina | Sigit Ferianton | Kepala pengelola pondok pesantren |

### 3.1.4 Data Karyawan dan Peserta Didik

Berdasarkan informasi yang diperoleh selama observasi dan wawancara:

| Kategori | Jumlah | Keterangan |
|----------|--------|------------|
| Santri Salaf Putra | 20 anak | Santri program salaf (tradisional) |
| Total Santri | Ribuan | Keseluruhan santri dari berbagai program |
| Ustadz Salaf | 9 orang | Pengajar program salaf |
| Total Ustadz | Banyak | Keseluruhan pengajar dari berbagai program |

---

## 3.2 Gambaran Umum Sistem yang Berjalan

### 3.2.1 Latar Belakang

Sebelum sistem berbasis website dikembangkan, proses pencatatan kehadiran santri di Pondok Pesantren Tahfidzul Qur'an Al-Asy'ariyyah dilakukan secara manual, diantaranya:

- Pencatatan kehadiran dilakukan di buku absensi fisik oleh petugas
- Proses perhitungan denda dilakukan secara manual dengan menghitung setiap ketidakhadiran
- Pembuatan laporan bulanan memerlukan waktu yang lama karena harus dihitung dan disusun secara manual
- Tidak adanya dashboard statistik yang real-time untuk monitoring kehadiran santri
- Akses informasi presensi terbatas hanya di dalam lingkungan pondok

### 3.2.2 Deskripsi Sistem

Sistem Presensi Madrasah Diniyah Salafiyah Pondok Pesantren Tahfidzul Qur'an Al-Asy'ariyyah adalah aplikasi berbasis website yang dibangun menggunakan framework **Laravel 12** dengan bahasa pemrograman **PHP**. Sistem ini dirancang untuk mengotomatisasi proses pencatatan kehadiran santri, penghitungan denda, dan pembuatan laporan bulanan.

### 3.2.3 Fitur Utama Sistem

Berdasarkan analisis terhadap sistem yang telah berjalan, fitur-fitur utama yang tersedia adalah:

**1. Manajemen Akun Pengguna**
- Login dengan username (untuk admin/petugas) atau NIS (untuk santri)
- Registrasi akun santri secara otomatis saat penambahan data santri
- Verifikasi email untuk keamanan akun
- Reset password oleh admin

**2. Manajemen Data Santri**
- Penambahan data santri baru (NIS, nama, alamat, no HP, tanggal lahir, nama orang tua, jenjang, kelas)
- Pencarian dan filter daftar santri
- Pengeditan dan penghapusan data santri
- Reset password santri ke NIS default

**3. Manajemen Jadwal Pelajaran**
- Penentuan jadwal per hari (Senin-Sabtu)
- Pembagian jadwal berdasarkan jenjang (Safinatunnajah dan Muqodimah)
- Penentuan ustadz pengajar dan jam pelajaran

**4. Pencatatan Presensi**
- Input presensi harian oleh petugas/admin
- Pilihan status: Hadir, Izin, Sakit, Alpha
- Autosave perubahan presensi secara otomatis via AJAX
- Filter presensi berdasarkan jenjang dan tanggal

**5. Rekapitulasi dan Pelaporan**
- Rekap presensi bulanan per santri dengan persentase kehadiran
- Rekap denda bulanan yang terakumulasi
- Ranking kehadiran santri
- Export laporan ke format Excel
- Generate dan download laporan dalam format PDF (presensi, rekap, denda, ranking, laporan lengkap)

**6. Dashboard dan Statistik**
- Dashboard admin dengan statistik lengkap hari ini
- Dashboard petugas dengan ringkasan presensi hari ini
- Dashboard santri dengan ringkasan presensi pribadi
- Statistik bulanan dengan grafik tren kehadiran

### 3.2.4 Teknologi yang Digunakan

| Komponen | Teknologi | Fungsi |
|-----------|-----------|--------|
| Backend Framework | Laravel 12.x | Inti aplikasi dan logika bisnis |
| Database | MySQL/MariaDB | Penyimpanan data |
| Autentikasi | Laravel Breeze v2.4 | Manajemen login dan session |
| Export Excel | Maatwebsite Excel v3.1 | Unduh laporan rekap Excel |
| Generate PDF | Barryvdh Laravel-DomPDF v3.1 | Cetak laporan PDF |
| Date/Time | Carbon | Manipulasi tanggal dan waktu |
| Frontend | Blade Template, Alpine.js, ApexCharts | Tampilan antarmuka dan chart |

### 3.2.5 Manajemen Database

Sistem ini menggunakan 4 (empat) tabel utama dalam database:

1. **Tabel Users** — Menyimpan data akun pengguna (admin, petugas, santri)
2. **Tabel Santri** — Menyimpan data profil santri
3. **Tabel Jam Pelajaran** — Menyimpan data jadwal pelajaran
4. **Tabel Absensi** — Menyimpan data presensi harian santri

---

## 3.3 Tahapan Kerja Praktek

Kerja praktek ini dilaksanakan dengan tahapan-tahapan yang terstruktur sebagai berikut:

### 3.3.1 Tahap Persiapan

Tahap ini dimulai dari penetapan judul kerja praktek hingga persiapan administrasi. Kegiatan yang dilakukan meliputi:

- Surat pengajuan judul karya akhir/kerja praktek
- Pengajuan proposal kepada dosen pembimbing
- Persetujuan dan revisi proposal
- Pengajuan surat pengantar kerja praktek ke instansi

**Waktu pelaksanaan:** April 2026

### 3.3.2 Metode Pengumpulan Data

Untuk memahami kebutuhan sistem yang dibutuhkan oleh Pondok Pesantren Tahfidzul Qur'an Al-Asy'ariyyah, penulis menggunakan beberapa metode pengumpulan data, yaitu:

**1. Observasi Lapangan (Field Observation)**
Observasi dilakukan dengan mengunjungi langsung lokasi Pondok Pesantren Tahfidzul Qur'an Al-Asy'ariyyah untuk melihat proses pencatatan kehadiran santri yang sedang berjalan. Penulis mengamati aktivitas petugas dalam melakukan input presensi secara manual, penyimpanan data, serta masalah yang dihadapi seperti keterlambatan pencatatan, sulitnya perhitungan denda, dan ketidakhadiran data yang akurat.

**2. Wawancara (Interview)**
Wawancara dilakukan dengan pihak Pembina dan petugas yang bertugas menangani presensi santri. Wawancara bersifat semi-terstruktur dengan daftar pertanyaan yang telah disusun sebelumnya untuk mengidentifikasi kebutuhan fungsional dan non-fungsional sistem, termasuk alur kerja yang berlaku saat ini dan masalah yang ingin diselesaikan.

**3. Studi Dokumenter**
Pengumpulan data juga dilakukan melalui dokumentasi yang ada di instansi, seperti buku presensi fisik, daftar santri, jadwal pelajaran, dan laporan bulanan yang pernah dibuat. Dokumentasi ini membantu penulis memahami format data yang digunakan dan kebutuhan laporan yang diinginkan.

**4. Review Kode Sumber (Code Review / Reverse Engineering)**
Setelah sistem selesai dikembangkan, penulis melakukan analisis terhadap seluruh kode sumber (source code) yang telah dibuat untuk mendokumentasikan struktur sistem, relasi data, alur proses, dan fitur-fitur yang terimplementasi. Metode ini digunakan untuk memastikan bahwa dokumentasi yang dihasilkan sesuai dengan kondisi sistem yang sebenarnya berjalan.

### 3.3.3 Metode Pengembangan Sistem

Sistem Presensi Madrasah Diniyah Salafiyah Pondok Pesantren Tahfidzul Qur'an Al-Asy'ariyyah dikembangkan dengan menggunakan model **Waterfall (Cascading)** yang merupakan salah satu pendekatan dalam Software Development Life Cycle (SDLC). Model ini dipilih karena proses pengembangan sistem memiliki karakteristik tahapan yang berurutan dan saling terkait, di mana setiap tahapan harus diselesaikan sebelum tahapan berikutnya dimulai. Tahapan yang dilewati meliputi:

**1. Analisis Kebutuhan (Requirements Analysis)**
Tahap ini dilakukan untuk mengidentifikasi kebutuhan pengguna melalui observasi, wawancara, dan studi dokumenter. Hasilnya adalah penyusunan daftar kebutuhan fungsional dan non-fungsional yang harus terpenuhi oleh sistem. Tahapan ini menjadi dasar bagi seluruh pengembangan sistem ke depannya.

**2. Perancangan Sistem (System Design)**
Tahap perancangan meliputi:
- Perancangan basis data dengan menyusun Entity Relationship Diagram (ERD)
- Perancangan struktur sistem dengan menyusun Class Diagram
- Perancangan antarmuka dengan membuat wireframe setiap halaman
- Perancangan alur proses dengan Activity Diagram, Sequence Diagram, dan Use Case Diagram

Seluruh hasil perancangan menjadi acuan untuk tahap implementasi berikutnya.

**3. Implementasi (Implementation)**
Tahap implementasi adalah pembangunan sistem sesuai dengan desain yang telah dibuat, meliputi:
- Konfigurasi framework Laravel 12 dan lingkungan pengembangan
- Pembuatan struktur database melalui migration
- Pembuatan Model, Controller, Route, dan View
- Implementasi fitur autentikasi, otorisasi, dan manajemen data
- Integrasi library eksternal (Excel, PDF, Chart)

**4. Testing**
Setelah implementasi, sistem diuji untuk memastikan seluruh fitur berjalan sesuai kebutuhan. Testing mencakup:
- Functional testing: pengujian setiap fitur sesuai alur bisnis
- Integration testing: pengujian integrasi antar modul (misalnya antara presensi dan laporan)
- User Acceptance Testing (UAT): uji coba langsung oleh pengguna (petugas dan admin) untuk memastikan sistem dapat digunakan sesuai kebutuhan

Apabila hasil testing tidak memenuhi kriteria, sistem dikembalikan ke tahap perancangan atau implementasi untuk dilakukan perbaikan.

**5. Deployment dan Dokumentasi**
Setelah lolos testing, sistem dideploy di lingkungan production. Tahap dokumentasi meliputi penyusunan laporan kerja praktek, dokumentasi kode sumber, dan penyediaan panduan penggunaan sistem bagi admin dan petugas.

Penjelasan tahapan di atas merepresentasikan karakteristik utama model Waterfall, yaitu proses pengembangan yang **berurutan, terstruktur, dan terdokumentasi dengan baik**. Adapun pendekatan ini dipilih mengingat sistem ini dikembangkan untuk memenuhi kebutuhan spesifik di instansi, yang memerlukan desain yang telah tetap sebelum masuk ke tahap koding. Meskipun demikian, selama tahap implementasi terdapat unsur iterasi ringan untuk melakukan perbaikan dan debugging, tetapi tidak mengubah alur Waterfall sebagai metode utama yang digunakan.

### 3.3.4 Tahap Observasi dan Studi Literatur

Tahap ini dilakukan untuk memahami kondisi existing di Pondok Pesantren Tahfidzul Qur'an Al-Asy'ariyyah dan mempelajari teknologi yang akan digunakan.

Kegiatan yang dilakukan:
1. **Observasi Lapangan**
   - Mengamati proses pencatatan presensi yang sedang berjalan
   - Membedah masalah yang dihadapi petugas dan admin
   - Mendokumentasikan kebutuhan sistem

2. **Wawancara**
   - Wawancara dengan Pembina (Pimpinan) untuk memahami kebutuhan dan ekspektasi
   - Wawancara dengan petugas/pengelola untuk memahami alur kerja harian
   - Identifikasi masalah yang dihadapi dalam proses presensi manual

3. **Studi Literatur**
   - Mempelajari dokumentasi framework Laravel
   - Memahami konsep MVC (Model-View-Controller)
   - Mempelajari database MySQL dan relasi tabel
   - Studi tentang sistem informasi presensi yang sudah ada

4. **Analisis Kebutuhan**
   - Mengidentifikasi kebutuhan fungsional dan non-fungsional
   - Merancang arsitektur sistem
   - Mendesain database schema
   - Membuat diagram UML (Use Case, Activity, Sequence, Class, ERD)

### 3.3.5 Tahap Perancangan Sistem

Tahap ini meliputi perancangan struktur sistem sebelum mulai mengoding:

1. **Perancangan Database**
   - Menyusun ERD (Entity Relationship Diagram)
   - Menentukan struktur tabel dan relasi antar tabel
   - Menentukan atribut dan tipe data setiap tabel

2. **Perancangan Arsitektur**
   - Menyusun Class Diagram
   - Menentukan struktur folder dan file
   - Menyusun struktur Controller dan Model

3. **Perancangan Antarmuka**
   - Mendesain wireframe setiap halaman
   - Menyusun struktur navigasi sistem
   - Menentukan komponen UI yang digunakan

### 3.3.6 Tahap Implementasi

Tahap ini merupakan pengerjaan kode dan pembangunan sistem:

1. **Setup Lingkungan Pengembangan**
   - Instalasi framework Laravel
   - Konfigurasi database dan environment
   - Setup version control (Git)

2. **Pembangunan Backend**
   - Pembuatan Model dan migrasi database
   - Pembuatan Controller beserta logic bisnis
   - Konfigurasi路由 (routes) dan middleware
   - Implementasi autentikasi dan otorisasi

3. **Pembangunan Frontend**
   - Pembuatan layout dan template Blade
   - Implementasi halaman-halaman sistem
   - Styling dan interaksi dengan JavaScript/Alpine.js
   - Integrasi chart ApexCharts untuk dashboard

4. **Testing**
   - Functional testing setiap fitur
   - Uji coba input data presensi
   - Uji coba generate laporan Excel dan PDF
   - Bug fixing dan perbaikan

### 3.3.7 Tahap Dokumentasi dan Penyelesaian

1. **Dokumentasi Sistem**
   - Penyusunan laporan kerja praktek
   - Dokumentasi kode sumber
   - Pembuatan user manual

2. **Presentasi dan Sidang**
   - Persiapan presentasi
   - Demonstrasi sistem
   - Tanggapan dan revisi laporan

---

## 3.4 Jadwal Kerja Praktek

Jadwal kerja praktek dilaksanakan selama **7 (tujuh) bulan** sejak tanggal **4 April 2026** sampai dengan **4 November 2026**.

### 3.4.1 Rencana Jadwal Kerja Praktek

| No | Kegiatan | April | Mei | Juni | Juli | Agustus | September | Oktober | November |
|--|---------|-------|-----|------|------|---------|-----------|---------|----------|
| 1 | Pengajuan judul | ███ | | | | | | | |
| 2 | Studi literatur | ███ | ███ | | | | | | |
| 3 | Observasi & wawancara | | ███ | ███ | | | | | |
| 4 | Analisis kebutuhan | | | ███ | ███ | | | | |
| 5 | Perancangan sistem | | | | ███ | ███ | | | |
| 6 | Implementasi backend | | | | | ███ | ███ | | |
| 7 | Implementasi frontend | | | | | | ███ | ███ | |
| 8 | Testing & debugging | | | | | | | ███ | |
| 9 | Penyusunan laporan | | | | | | | ███ | ███ |
| 10 | Presentasi & sidang | | | | | | | | ███ |

*Keterangan: ███ = bulan pelaksanaan*

### 3.4.2 Detail Rencana Kegiatan per Bulan

**Bulan April 2026 (Mulai)**
- Pengajuan judul karya akhir
- Pengambilan survey awal di lokasi Pondok Pesantren
- Studi literatur teknologi yang relevan

**Bulan Mei - Juni 2026**
- Observasi langsung proses pencatatan presensi yang berjalan
- Wawancara dengan Pembina dan petugas
- Identifikasi masalah dan kebutuhan sistem
- Analisis kebutuhan fungsional dan non-fungsional

**Bulan Juli - Agustus 2026**
- Perancangan database (ERD)
- Perancangan struktur sistem (Class Diagram)
- Perancangan antarmuka (wireframe)
- Setup environment pengembangan

**Bulan September - Oktober 2026**
- Implementasi fitur-fitur sistem
- Testing dan debugging
- Uji coba langsung di lingkungan pondok pesantren

**Bulan November 2026 (Selesai)**
- Penyelesaian laporan kerja praktek
- Persiapan presentasi sidang
- Pelaksanaan sidang kerja praktek

### 3.4.3 Daftar Pustaka

Alat dan teknologi yang digunakan selama pelaksanaan kerja praktek:

- Framework Laravel 12.x
- PHP 8.2+
- MySQL/MariaDB
- Maatwebsite Excel v3.1
- Barryvdh Laravel-DomPDF v3.1
- ApexCharts untuk grafik
- Alpine.js untuk interaksi frontend
- Git untuk version control
- Visual Studio Code sebagai IDE

---

*Bab ini disusun berdasarkan hasil observasi, wawancara, dan studi literatur yang telah dilakukan selama pelaksanaan kerja praktek di Pondok Pesantren Tahfidzul Qur'an Al-Asy'ariyyah.*
