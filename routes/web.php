<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SantriController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\RekapController;
use App\Http\Controllers\StatistikController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\JamPelajaranController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\SantriPasswordController;
use App\Http\Controllers\SimpleLoginController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Santri\DashboardController as SantriDashboardController;
use App\Http\Controllers\Santri\AttendanceController;
use App\Http\Controllers\Santri\FineController;
use App\Http\Controllers\Santri\RankingController;
use App\Http\Controllers\Santri\StatisticsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [SimpleLoginController::class, 'show'])->name('login')->middleware('guest');
Route::post('/login', [SimpleLoginController::class, 'login'])->middleware('guest');
Route::post('/logout', [SimpleLoginController::class, 'logout'])->name('logout');
Route::get('/admin/forgot-password', [\App\Http\Controllers\AdminForgotPasswordController::class, 'show'])->name('admin.password.request');
Route::post('/admin/forgot-password', [\App\Http\Controllers\AdminForgotPasswordController::class, 'sendResetLink'])->middleware('throttle:6,1')->name('admin.password.email');
Route::get('/reset-password/{token}', [\App\Http\Controllers\Auth\NewPasswordController::class, 'create'])->name('password.reset');
Route::post('/reset-password', [\App\Http\Controllers\Auth\NewPasswordController::class, 'store'])->name('password.store');

// ── Shared password route (admin & petugas) ──
Route::put('/password', [App\Http\Controllers\Auth\PasswordController::class, 'update'])
    ->middleware('auth')
    ->name('password.update');

Route::get('/dashboard', function() {
    $user = auth()->user();
    if (!$user) {
        return redirect()->route('login');
    }
    
    return match($user->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'petugas' => redirect()->route('petugas.dashboard'),
        'santri' => redirect()->route('santri.dashboard'),
        default => redirect()->route('login'),
    };
})->middleware('auth')->name('dashboard');

Route::get('/admin/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'role:admin'])->name('admin.dashboard');

Route::middleware(['auth', 'role:admin'])->group(function () {
     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

      // ── Email Verification ──
     Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
         ->middleware('throttle:6,1')->name('verification.send');
     Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
         ->middleware(['auth', 'signed'])->name('verification.verify');

      Route::get('/santri', [SantriController::class, 'index'])->name('santri.index');
      Route::get('/santri/create', [SantriController::class, 'create'])->name('santri.create');
      Route::post('/santri', [SantriController::class, 'store'])->name('santri.store');
      Route::get('/santri/{santri}', [SantriController::class, 'show'])->where('santri', '[0-9]+')->name('santri.show');
      Route::get('/santri/{santri}/edit', [SantriController::class, 'edit'])->where('santri', '[0-9]+')->name('santri.edit');
      Route::put('/santri/{santri}', [SantriController::class, 'update'])->name('santri.update');
      Route::delete('/santri/{santri}', [SantriController::class, 'destroy'])->name('santri.destroy');
      Route::post('/santri/{santri}/reset-password', [SantriController::class, 'resetPassword'])->name('santri.reset-password');

      Route::get('/presensi', [PresensiController::class, 'index'])->name('presensi.index');
      Route::get('/presensi/safinatunnajah', [PresensiController::class, 'safinatunnajah'])->name('presensi.safinatunnajah');
      Route::get('/presensi/muqodimah', [PresensiController::class, 'muqodimah'])->name('presensi.muqodimah');
      Route::post('/presensi', [PresensiController::class, 'store'])->name('presensi.store');
      Route::post('/presensi/autosave', [PresensiController::class, 'autoSave'])->name('presensi.autosave');
      Route::get('/presensi/edit', [PresensiController::class, 'edit'])->name('presensi.edit');
      Route::put('/presensi/{tanggal}', [PresensiController::class, 'update'])->name('presensi.update');

      Route::get('/rekap/presensi', [RekapController::class, 'presensi'])->name('rekap.presensi');
      Route::get('/rekap/presensi/export', [RekapController::class, 'exportExcel'])->name('rekap.presensi.export');
      Route::get('/rekap/presensi/print', [RekapController::class, 'print'])->name('rekap.presensi.print');
      Route::get('/rekap/denda', [RekapController::class, 'denda'])->name('rekap.denda');
      Route::post('/rekap/denda/toggle-pembayaran', [RekapController::class, 'togglePembayaran'])->name('rekap.denda.toggle-pembayaran');
      Route::get('/rekap/ranking', function() {
          return redirect()->route('rekap.presensi');
      })->name('rekap.ranking');

      Route::get('/statistik', [StatistikController::class, 'index'])->name('statistik.index');

      Route::get('/laporan', [LaporanController::class, 'presensi'])->name('laporan.presensi');
      Route::get('/laporan/pdf-rekap', [LaporanController::class, 'pdfRekap'])->name('laporan.pdf-rekap');
      Route::get('/laporan/pdf-denda', [LaporanController::class, 'pdfDenda'])->name('laporan.pdf-denda');
      Route::get('/laporan/pdf-ranking', [LaporanController::class, 'pdfRanking'])->name('laporan.pdf-ranking');
      Route::get('/laporan/pdf-complete', [LaporanController::class, 'pdfComplete'])->name('laporan.pdf-complete');

      Route::get('/jam-pelajaran', [JamPelajaranController::class, 'index'])->name('jam-pelajaran.index');
      Route::get('/jam-pelajaran/create', [JamPelajaranController::class, 'create'])->name('jam-pelajaran.create');
      Route::post('/jam-pelajaran', [JamPelajaranController::class, 'store'])->name('jam-pelajaran.store');
      Route::get('/jam-pelajaran/{jamPelajaran}/edit', [JamPelajaranController::class, 'edit'])->name('jam-pelajaran.edit');
      Route::put('/jam-pelajaran/{jamPelajaran}', [JamPelajaranController::class, 'update'])->name('jam-pelajaran.update');
      Route::delete('/jam-pelajaran/{jamPelajaran}', [JamPelajaranController::class, 'destroy'])->name('jam-pelajaran.destroy');

      // ── Pengaturan ──
      Route::prefix('pengaturan')->name('pengaturan.')->group(function () {
          Route::get('/', [PengaturanController::class, 'index'])->name('index');
          Route::post('/reset-presensi', [PengaturanController::class, 'resetPresensi'])->name('reset-presensi');
          Route::get('/template-santri', [PengaturanController::class, 'exportTemplateSantri'])->name('template-santri');
          Route::post('/reset-santri', [PengaturanController::class, 'resetSantri'])->name('reset-santri');
      });

      // ── Kelola Pengguna ──
      Route::get('/users', [App\Http\Controllers\UserManagementController::class, 'index'])->name('users.index');
      Route::post('/users/{user}/reset-password', [App\Http\Controllers\UserManagementController::class, 'resetPassword'])->name('users.reset-password');

      Route::get('/debug-jadwal', function() {
          \DB::connection()->enableQueryLog();
          $data = \App\Models\JamPelajaran::orderBy('hari')->orderBy('kelas')->orderBy('urutan')->get(['id','hari','kelas','nama','jam_mulai','jam_selesai','ustadz']);
          echo "<pre style='font-family: monospace; font-size: 12px; line-height: 1.4;'>";
          echo "=== JADWAL PELAJARAN ===\n\n";
          foreach($data as $row) {
              echo sprintf("%-10s | %-18s | %-20s | %-8s - %-8s | %s\n",
                  $row->hari,
                  $row->kelas ?? 'NULL',
                  substr($row->nama,0,20),
                  $row->jam_mulai,
                  $row->jam_selesai,
                  $row->ustadz
              );
          }
          echo "\nTotal Records: " . count($data) . "\n";
          echo "Safinatunnajah: " . \DB::table('jam_pelajaran')->where('kelas','Safinatunnajah')->count() . "\n";
          echo "Muqodimah: " . \DB::table('jam_pelajaran')->where('kelas','Muqodimah')->count() . "\n";
          echo "NULL: " . \DB::table('jam_pelajaran')->whereNull('kelas')->count() . "\n";
          echo "</pre>";
      });
 });

    // Routes for petugas

    // Routes for petugas
    Route::middleware(['auth', 'role:petugas'])->prefix('petugas')->group(function () {
        Route::get('/dashboard', [PresensiController::class, 'dashboard'])->name('petugas.dashboard');
        Route::get('/presensi', [PresensiController::class, 'index'])->name('petugas.presensi.index');
        Route::get('/presensi/safinatunnajah', [PresensiController::class, 'safinatunnajah'])->name('petugas.presensi.safinatunnajah');
        Route::get('/presensi/muqodimah', [PresensiController::class, 'muqodimah'])->name('petugas.presensi.muqodimah');
        Route::post('/presensi', [PresensiController::class, 'store'])->name('petugas.presensi.store');
        Route::post('/presensi/autosave', [PresensiController::class, 'autoSave'])->name('petugas.presensi.autosave');
        Route::get('/presensi/edit', [PresensiController::class, 'edit'])->name('petugas.presensi.edit');
        Route::put('/presensi/{tanggal}', [PresensiController::class, 'update'])->name('petugas.presensi.update');

        Route::get('/profile', [ProfileController::class, 'edit'])->name('petugas.profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('petugas.profile.update');
    });

// Routes for santri
    Route::middleware(['auth', 'role:santri'])->prefix('santri')->group(function () {
        Route::get('/dashboard', [SantriDashboardController::class, 'index'])->name('santri.dashboard');
        Route::get('/profile', [ProfileController::class, 'show'])->name('santri.profile');
        Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('santri.password.update');
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('santri.profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('santri.profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('santri.profile.destroy');

        Route::get('/attendance', [AttendanceController::class, 'index'])->name('santri.attendance');
        Route::get('/fine', [FineController::class, 'index'])->name('santri.fine');
        Route::get('/ranking', [RankingController::class, 'index'])->name('santri.ranking');
        Route::get('/statistics', [StatisticsController::class, 'index'])->name('santri.statistics');
    });

Route::post('/login-test', [SimpleLoginController::class, 'login']);

// Development helper - auto login santri dan redirect ke dashboard
// Gunakan route ini jika ada masalah session/auth
Route::get('/dev-santri', function() {
    \Log::info('Dev-santri route: Looking for user with NIS 0001 and role santri');
    $user = \App\Models\User::where('nis', '0001')->where('role', 'santri')->first();
    if (!$user) {
        \Log::info('Dev-santri route: User not found');
        return 'Santri dengan NIS 0001 tidak ditemukan di database';
    }
    \Log::info('Dev-santri route: User found: ' . $user->id . ', ' . $user->name . ', ' . $user->role);
    auth()->login($user);
    \Log::info('Dev-santri route: After login, auth check: ' . Auth::check() . ', user: ' . (Auth::user() ? Auth::user()->id : 'null') . ', session ID: ' . session()->getId());
    \Log::info('Dev-santri route: User logged in, redirecting to /santri/dashboard');
    return redirect('/santri/dashboard');
});

# require __DIR__.'/auth.php';