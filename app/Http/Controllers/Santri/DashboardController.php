<?php

namespace App\Http\Controllers\Santri;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Santri;
use App\Models\JamPelajaran;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $santri = Auth::user()->santri;
        if (!$santri) {
            return redirect()->back()->with('error', 'Data santri tidak ditemukan.');
        }

        $today = Carbon::now()->toDateString();

        // Statistik keseluruhan
        $stats = Absensi::where('santri_id', $santri->id)
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $totalHadir = $stats['hadir'] ?? 0;
        $totalIzin = $stats['izin'] ?? 0;
        $totalSakit = $stats['sakit'] ?? 0;
        $totalAlpha = $stats['alpha'] ?? 0;
        $totalPertemuan = array_sum($stats);
        $persentaseKehadiran = $totalPertemuan > 0 ? round(($totalHadir / $totalPertemuan) * 100, 2) : 0;

        // Denda bulan ini
        $totalDendaBulan = Absensi::where('santri_id', $santri->id)
            ->whereMonth('tanggal', Carbon::now()->month)
            ->whereYear('tanggal', Carbon::now()->year)
            ->sum('denda');

        // Denda keseluruhan
        $totalDendaKeseluruhan = Absensi::where('santri_id', $santri->id)->sum('denda');

        // Status kehadiran terbaru hari ini
        $todayAttendance = Absensi::where('santri_id', $santri->id)
            ->whereDate('tanggal', $today)
            ->first();

        // Rekap bulan ini
        $bulanIniStats = Absensi::where('santri_id', $santri->id)
            ->whereMonth('tanggal', Carbon::now()->month)
            ->whereYear('tanggal', Carbon::now()->year)
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $totalHadirBulan = $bulanIniStats['hadir'] ?? 0;
        $totalAlphaBulan = $bulanIniStats['alpha'] ?? 0;
        $totalIzinBulan = $bulanIniStats['izin'] ?? 0;
        $totalSakitBulan = $bulanIniStats['sakit'] ?? 0;
        $totalPertemuanBulan = array_sum($bulanIniStats);
        $persentaseKehadiranBulan = $totalPertemuanBulan > 0 ? round(($totalHadirBulan / $totalPertemuanBulan) * 100, 2) : 0;

        // Jadwal hari ini untuk kelas santri
        $hariMap = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
        ];
        $hariIni = $hariMap[Carbon::now()->format('l')] ?? Carbon::now()->format('l');
        $kelas = $santri->kelas ?? '';

        $jadwalHariIni = JamPelajaran::where('hari', $hariIni)
            ->when($kelas, function($q, $kelas) {
                return $q->where('kelas', $kelas);
            })
            ->where('status', true)
            ->orderBy('urutan')
            ->get()
            ->map(function($jam) {
                return [
                    'nama' => $jam->nama,
                    'jam_mulai' => $jam->jam_mulai instanceof Carbon
                        ? $jam->jam_mulai->format('H:i')
                        : Carbon::parse($jam->jam_mulai)->format('H:i'),
                    'jam_selesai' => $jam->jam_selesai instanceof Carbon
                        ? $jam->jam_selesai->format('H:i')
                        : Carbon::parse($jam->jam_selesai)->format('H:i'),
                    'ustadz' => $jam->ustadz,
                    'kelas' => $jam->kelas,
                ];
            })->toArray();

        // Aktivitas terbaru (max 5)
        $recentActivities = Absensi::where('santri_id', $santri->id)
            ->orderBy('tanggal', 'desc')
            ->orderBy('updated_at', 'desc')
            ->take(5)
            ->get()
            ->map(function($absensi) {
                return [
                    'tanggal' => $absensi->tanggal,
                    'status' => $absensi->status,
                    'keterangan' => $absensi->keterangan,
                    'nama_status' => $absensi->nama_status,
                    'denda' => $absensi->denda,
                ];
            });

        // Posisi ranking santri
        $santriRanking = $this->getSantriRanking($santri->id);

        $now = Carbon::now();

        return view('santri.dashboard', compact(
            'totalHadir',
            'totalIzin',
            'totalSakit',
            'totalAlpha',
            'totalDendaBulan',
            'totalDendaKeseluruhan',
            'persentaseKehadiran',
            'persentaseKehadiranBulan',
            'todayAttendance',
            'totalHadirBulan',
            'totalAlphaBulan',
            'totalIzinBulan',
            'totalSakitBulan',
            'hariIni',
            'today',
            'jadwalHariIni',
            'recentActivities',
            'santriRanking',
            'santri',
            'now'
        ));
    }

    private function getSantriRanking(int $santriId): array
    {
        $bulan = Carbon::now()->month;
        $tahun = Carbon::now()->year;

        $allSantris = Santri::where('status', true)
            ->withCount(['absensi as hadir_count' => function($q) use ($bulan, $tahun) {
                $q->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->where('status', 'hadir');
            }])
            ->get();

        $ranked = $allSantris->sortByDesc(function($s) {
            return $s->hadir_count;
        })->values();

        $myPosition = $ranked->search(function($s) use ($santriId) {
            return $s->id == $santriId;
        });

        $mySantri = $ranked[$myPosition ?? 0];

        return [
            'position' => $myPosition !== false ? $myPosition + 1 : '-',
            'total_hadir' => $mySantri->hadir_count ?? 0,
            'persentase' => $mySantri->hadir_count > 0 ? round(($mySantri->hadir_count / 30) * 100, 2) : 0,
        ];
    }
}