# BAB 5
# KESIMPULAN DAN SARAN

---

## 5.1 Kesimpulan

Berdasarkan hasil reverse engineering dan analisis Sistem Presensi Madrasah Diniyah Salafiyah Pondok Pesantren Tahfidzul Qur'an Al-Asy'ariyyah yang telah berjalan, dapat disimpulkan bahwa sistem ini telah berhasil dikembangkan untuk mengotomatisasi proses pencatatan kehadiran santri. Sistem dibangun menggunakan framework **Laravel 12** dengan menerapkan pola arsitektur **Model-View-Controller (MVC)**, sehingga menghasilkan struktur kode yang terorganisir dan mudah dipelihara.

Sistem ini telah mengimplementasikan mekanisme **Role-Based Access Control (RBAC)** melalui custom middleware `RoleMiddleware` untuk membedakan hak akses berdasarkan tiga peran pengguna, yaitu **Admin**, **Petugas**, dan **Santri**. Berdasarkan analisis terhadap seluruh kode sumber, seluruh kebutuhan fungsional telah terpenuhi dengan baik, meliputi proses autentikasi dengan dual login (username untuk admin/petugas, NIS untuk santri), manajemen data santri (CRUD lengkap dengan pencarian dan filter), manajemen jadwal pelajaran, pencatatan presensi harian dengan autosave AJAX, rekapitulasi presensi bulanan, ranking, perhitungan denda otomatis, pelaporan dalam format Excel dan PDF, serta dashboard statistik berbasis chart.

 Dari segi struktur data, sistem ini menggunakan **empat entitas utama**, yaitu `User`, `Santri`, `JamPelajaran`, dan `Absensi`, yang saling berhubisi melalui foreign key dengan unique constraint untuk mencegah duplikasi data presensi. Diagram UML yang telah dihasilkan meliputi Use Case Diagram, Activity Diagram, Sequence Diagram, Class Diagram, dan Entity Relationship Diagram (ERD), yang seluruhnya telah disusun sesuai kaidah UML akademik dan standar penulisan laporan kerja praktek.

 Dalam aspek keamanan, sistem telah menerapkan hash password dengan bcrypt, proteksi route menggunakan middleware `auth` dan `role`, verifikasi email dengan token signed dan rate limiting, serta regenerasi session ID setelah login untuk mencegah session fixation attacks. Dari segi kecepatan, sistem telah menerapkan query agregasi database, eager loading, pagination, dan operasi batch untuk mengoptimalkan kinerja. Dalam hal keandalan, sistem telah menerapkan validasi input yang ketat, unique constraint, transaksi implisit Eloquent, serta error handling dengan try-catch untuk menjaga konsistensi data.

---

## 5.2 Saran

Berdasarkan hasil analisis sistem yang telah berjalan, berikut ini beberapa saran yang diharapkan dapat dipertimbangkan untuk pengembangan sistem ke depannya:

### 5.2.1 Pengembangan Fitur

1. **Integrasi Notifikasi Otomatis**
   Pengembangan modul notifikasi WhatsApp atau email untuk mengirimkan pengingat kepada petugas agar melakukan input presensi sesuai jadwal, serta notifikasi kepada santri dan orang tua mengenai status kehadiran dan total denda yang terakumulasi.

2. **Modul Manajemen Pembayaran Denda**
   Penambahan fitur pencatatan pembayaran denda dengan generating kwitansi digital, melacak status lunas atau tagihan, serta menyimpan riwayat pembayaran per santri.

3. **Integrasi Perangkat Presensi**
   Pengembangan integrasi dengan perangkat fingerprint, RFID card reader, atau face recognition untuk melakukan input presensi secara otomatis tanpa perlu input manual oleh petugas, sehingga dapat mengurangi beban kerja serta kesalahan manusia.

4. **Pengembangan Aplikasi Mobile**
   Transformasi sistem menjadi aplikasi mobile (Android/iOS) atau progressive web app (PWA) agar petugas dapat melakukan input presensi dari mana saja dan santri dapat mengakses dashboard serta menerima notifikasi real-time.

5. **Penambahan Fitur Pelaporan Kehadiran oleh Orang Tua**
   Modul baru yang memungkinkan orang tua atau wali santri dapat melaporkan kehadiran atau mengajukan permohonan izin secara online melalui sistem tanpa perlu datang ke pondok pesantren.

### 5.2.2 Peningkatan Teknis

6. **Implementasi API RESTful**
   Pembuatan API endpoint untuk memungkinkan integrasi dengan sistem eksternal, pengembangan aplikasi mobile, atau penerapan layanan microservices di masa depan.

7. **Penerapan Caching Strategy**
   Penambahan mekanisme caching untuk data statis atau semi-statis seperti jadwal pelajaran, daftar santri aktif, dan data ranking guna mengurangi beban query database dan meningkatkan waktu respons sistem.

8. **Audit Trail dan Logging**
   Pengembangan fitur audit trail yang lebih komprehensif untuk mencatat seluruh aktivitas penting pengguna, seperti login, perubahan data, input presensi, dan export laporan, guna mendukung kebutuhan keamanan dan akuntabilitas.

9. **Backup dan Recovery Otomatis**
   Konfigurasi sistem backup database yang terjadwal secara otomatis dengan mekanisme recovery yang terdokumentasi dengan baik untuk mencegah kehilangan data presensi.

10. **Peningkatan Keamanan dengan Two-Factor Authentication (2FA)**
    Implementasi autentikasi dua faktor untuk peran Admin dan Petugas sebagai lapisan keamanan tambahan, terutama ketika sistem akan diakses melalui jaringan publik atau aplikasi mobile.

### 5.2.3 Skalabilitas

11. **Dukungan Multi-Pondok**
    Redesign struktur database dan sistem untuk mendukung multi-tenant atau multi-pondok pesantren dalam satu instance aplikasi, memungkinkan sistem digunakan oleh beberapa pondok dengan data yang terpisah namun terkelola secara terpusat.

12. **Export dan Scheduling Report Otomatis**
    Penambahan fitur penjadwalan laporan bulanan yang dapat dikirimkan otomatis via email kepada admin atau pihak tertentu tanpa perlu download manual.

---

## 5.3 Buku Manual (Panduan Penggunaan Sistem)

Buku manual berikut disusun berdasarkan hasil analisis terhadap alur sistem yang berjalan, sebagai panduan operasional bagi masing-masing pengguna (admin, petugas, dan santri). Penulisan ini murni bersifat dokumentatif dan tidak mengubah logika maupun tampilan sistem.

### 5.3.1 Akses dan Login

1. Buka aplikasi melalui browser di url utama sistem.
2. Pada halaman login, masukkan **Username** (untuk Admin/Petugas) **atau NIS** (untuk Santri) pada kolom "Username / NIS".
3. Masukkan **Kata Sandi** pada kolom yang tersedia.
4. Klik tombol **Masuk**.
5. Sistem akan mengarahkan pengguna ke dashboard sesuai dengan peran masing-masing:
   - Admin → Dashboard Admin
   - Petugas → Dashboard Petugas
   - Santri → Dashboard Santri
6. Untuk keluar dari sistem, klik menu **Logout** pada sudut kanan atas.

### 5.3.2 Panduan Penggunaan untuk Admin

**a. Dashboard Admin**
- Menampilkan ringkasan statistik hari ini (total santri, hadir, izin, sakit, alpha, persentase kehadiran).
- Menampilkan total denda hari ini, ranking santri terajin, jadwal pelajaran hari ini, serta grafik tren kehadiran 12 bulan terakhir.

**b. Manajemen Data Santri**
1. Klik menu **Data Santri**.
2. Klik **Tambah Santri**, lalu isi form: NIS, Nama, Alamat, No. HP, Tanggal Lahir, Nama Orang Tua, Khalaqoh (Safinatunnajah/Muqodimah), dan Kelas.
3. Klik **Simpan**. Sistem otomatis membuatkan akun login santri dengan password default = NIS.
4. Untuk melihat detail, klik **Detail** pada baris santri.
5. Untuk mengubah data, klik **Edit**.
6. Untuk menghapus, klik **Hapus** (akan menghapus data santri beserta akun login terkait).
7. Untuk mereset password santri ke NIS, klik tombol **Reset Password** pada halaman detail.

**c. Manajemen Jadwal Pelajaran**
1. Klik menu **Jadwal Pelajaran**.
2. Klik **Tambah**, lalu isi: Nama Mata Pelajaran, Ustadz, Jam Mulai, Jam Selesai, Hari, Urutan, Kelas (Jenjang), dan status Aktif.
3. Klik **Simpan**.

**d. Pencatatan Presensi**
1. Klik menu **Presensi**.
2. Pilih Tanggal, Jenjang (Safinatunnajah/Muqodimah), dan Jam Pelajaran.
3. Untuk setiap santri, pilih status: Hadir, Izin, Sakit, atau Alpha.
4. Sistem menyimpan perubahan otomatis (autosave) tanpa perlu menekan tombol.
5. Klik **Simpan Presensi** untuk menyimpan seluruh data sekaligus.

**e. Rekapitulasi dan Laporan**
- **Rekap Presensi**: Menampilkan rekap per santri per bulan dengan persentase kehadiran, dapat difilter bulan/tahun/kelas.
- **Rekap Denda**: Menampilkan total denda per santri yang diurutkan dari yang terbesar.
- **Ranking**: Menampilkan peringkat kehadiran santri.
- **Export Excel**: Mengunduh rekap presensi dalam format `.xlsx`.
- **Print**: Mencetak rekap langsung dari browser.
- **Laporan PDF**: Mengunduh laporan dalam format PDF (Presensi, Rekap, Denda, Ranking, atau Laporan Lengkap).

**f. Pengaturan Sistem**
- **Reset Presensi**: Mengosongkan seluruh data presensi. Pengguna wajib mengetikkan konfirmasi `YA` pada kolom yang disediakan sebelum tombol reset dapat diproses. Proses ini dijalankan dalam transaksi database agar aman.
- **Reset Santri**: Mengosongkan seluruh data santri. Sama dengan reset presensi, pengguna wajib mengetikkan konfirmasi `YA` terlebih dahulu. Proses dijalankan dalam transaksi database.

**g. Kelola Users**
- Menampilkan dan mengelola daftar akun pengguna (admin, petugas, santri aktif).
- Admin dapat mereset password user lain ke nilai default (NIS/username).

### 5.3.3 Panduan Penggunaan untuk Petugas

**a. Dashboard Petugas**
- Menampilkan statistik presensi hari ini: total santri, jumlah sudah presensi, jumlah belum presensi, dan persentase per jenjang.
- Menampilkan daftar 10 santri yang belum presensi hari ini.

**b. Input Presensi**
- Sama dengan panduan admin pada poin 5.3.2(d), petugas dapat memilih tanggal, jenjang, jam pelajaran, dan mengisi status kehadiran tiap santri.

**c. Profil**
- Petugas dapat mengubah data profil dan mengganti password melalui menu **Profil**.

### 5.3.4 Panduan Penggunaan untuk Santri

**a. Dashboard Santri**
- Menampilkan ringkasan presensi pribadi: total hadir, izin, sakit, alpha, persentase kehadiran, dan total denda.

**b. Riwayat Presensi**
- Klik menu **Attendance**, santri dapat melihat riwayat kehadiran pribadi dengan filter bulan dan tahun.

**c. Riwayat Denda**
- Klik menu **Fine**, santri dapat melihat rincian dan total denda yang terakumulasi.

**d. Ranking**
- Klik menu **Ranking**, santri dapat melihat posisi kehadirannya dibanding santri lain.

**e. Statistik**
- Klik menu **Statistics**, santri dapat melihat grafik statistik kehadiran pribadi.

**f. Profil**
- Santri dapat mengedit profil dan mengganti password pada menu **Profil**.
- Apabila santri login pertama kali, sistem akan meminta penggantian password default (NIS).

---

*Kesimpulan, saran, dan buku manual ini disusun berdasarkan hasil analisis sistem yang sedang berjalan. Tidak ada perubahan atau modifikasi yang diajukan terhadap struktur logika, kode, atau tampilan sistem yang sudah ada.*
