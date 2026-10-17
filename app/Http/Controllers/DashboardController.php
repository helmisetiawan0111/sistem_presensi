<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Santri;
use App\Models\JamPelajaran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $today = Carbon::now()->toDateString();
        $todayName = Carbon::now()->format('l');

        $hariMap = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
        ];
        $hariIni = $hariMap[$todayName] ?? $todayName;

        $totalSantri = Santri::where('status', true)->count();

        $totalHadirHariIni = Absensi::whereDate('tanggal', $today)->where('status', 'hadir')->count();
        $totalAlphaHariIni = Absensi::whereDate('tanggal', $today)->where('status', 'alpha')->count();
        $totalIzinHariIni = Absensi::whereDate('tanggal', $today)->where('status', 'izin')->count();
        $totalSakitHariIni = Absensi::whereDate('tanggal', $today)->where('status', 'sakit')->count();

        $dendaHariIni = Absensi::whereDate('tanggal', $today)->sum('denda');

        $jamPelajaran = $this->getJamPelajaranForToday($hariIni);

        $rekapBulan = $this->getRekapBulan();
        $totalDendaBulan = $rekapBulan['denda'] ?? 0;

        $rankingTerbaik = $this->getRankingTerbaik(5);

        // Recent activities
        $recentActivities = Absensi::with('santri')
            ->where('tanggal', $today)
            ->orderBy('updated_at', 'desc')
            ->take(10)
            ->get()
            ->map(function($absensi) {
                return [
                    'santri' => $absensi->santri->nama ?? 'Unknown',
                    'time' => Carbon::parse($absensi->updated_at)->diffForHumans(),
                    'status' => $absensi->status,
                    'type' => in_array($absensi->status, ['hadir', 'alpha', 'izin', 'sakit']) ? $absensi->status : 'hadir'
                ];
            })->toArray();

        // Chart data
        $chartData = $this->getChartData();
        $stats = $rekapBulan;

        $persentaseKehadiran = $totalSantri > 0 ? round(($totalHadirHariIni / $totalSantri) * 100) : 0;

        // Rata-rata kehadiran bulan ini (persentase)
        $rataRataKehadiran = $totalSantri > 0 ? round(($rekapBulan['hadir'] / ($totalSantri * 30)) * 100) : 0;
        // Note: asumsi 30 hari per bulan sebagai baseline; bisa di refinement dengan hari efektif

        $santriTerajin = $rankingTerbaik->first()->hadir_count ?? 0;

        $totalPetugas = User::where('role', 'petugas')->count();
        $totalPelanggaran = $totalAlphaHariIni + $totalIzinHariIni + $totalSakitHariIni;

        $totalHadirBulan = $rekapBulan['hadir'] ?? 0;
        $totalAlphaBulan = $rekapBulan['alpha'] ?? 0;
        $totalIzinBulan = $rekapBulan['izin'] ?? 0;
        $totalSakitBulan = $rekapBulan['sakit'] ?? 0;

        // Get current Carbon instance for use in view
        $now = Carbon::now();

        // Schedule data
        $jadwalHariIni = $this->getActiveSchedule($jamPelajaran);

        // Determine which view to return based on route prefix
        $viewName = 'admin.dashboard'; // default
        if (auth()->check()) {
            if (auth()->user()->role === 'santri') {
                $viewName = 'santri.dashboard';
            }
            // admin and petugas use admin.dashboard (petugas dashboard uses different controller)
        }

        return view($viewName, compact(
            'totalSantri',
            'totalHadirHariIni',
            'totalAlphaHariIni',
            'totalIzinHariIni',
            'totalSakitHariIni',
            'dendaHariIni',
            'jamPelajaran',
            'hariIni',
            'today',
            'rekapBulan',
            'rankingTerbaik',
            'totalDendaBulan',
            'recentActivities',
            'chartData',
            'stats',
            'persentaseKehadiran',
            'rataRataKehadiran',
            'santriTerajin',
            'totalPetugas',
            'totalPelanggaran',
            'jadwalHariIni',
            'totalHadirBulan',
            'totalAlphaBulan',
            'totalIzinBulan',
            'totalSakitBulan',
            'now'
        ));
    }

    private function getChartData(): array
    {
        $tahun = Carbon::now()->year;

        $absensi = Absensi::whereYear('tanggal', $tahun)
            ->selectRaw('MONTH(tanggal) as bulan, status, COUNT(*) as total')
            ->groupBy('bulan', 'status')
            ->orderBy('bulan')
            ->get();

        $data = [
            'hadir' => array_fill(0, 12, 0),
            'alpha' => array_fill(0, 12, 0),
            'izin'  => array_fill(0, 12, 0),
            'sakit' => array_fill(0, 12, 0),
        ];

        foreach ($absensi as $row) {
            $bulanIndex = $row->bulan - 1;
            if (isset($data[$row->status]) && $bulanIndex >= 0 && $bulanIndex < 12) {
                $data[$row->status][$bulanIndex] = (int) $row->total;
            }
        }

        return $data;
    }

    private function getActiveSchedule(array $jamPelajaran): array
    {
        $now = Carbon::now();
        $schedule = [];

        foreach (['safinatunnajah', 'muqodimah'] as $kelas) {
            foreach ($jamPelajaran[$kelas] ?? [] as $jadwal) {
                $jamMulai = Carbon::parse($jadwal['jam_mulai']);
                $jamSelesai = Carbon::parse($jadwal['jam_selesai']);
                $isActive = $now->between($jamMulai, $jamSelesai);

                $schedule[] = [
                    'nama' => $jadwal['nama'],
                    'jam_mulai' => $jadwal['jam_mulai'],
                    'jam_selesai' => $jadwal['jam_selesai'],
                    'ustadz' => $jadwal['ustadz'] ?? '',
                    'active' => $isActive,
                    'kelas' => ucfirst($kelas)
                ];
            }
        }

        return $schedule;
    }

    private function getJamPelajaranForToday(string $hari): array
    {
        $getSchedule = function($kelas) use ($hari) {
            return JamPelajaran::where('hari', $hari)
                ->where('kelas', $kelas)
                ->where('status', true)
                ->orderBy('urutan')
                ->get()
                ->map(function($jam) {
                    return [
                        'nama' => $jam->nama,
                        'jam_mulai' => $jam->jam_mulai instanceof \Carbon\Carbon
                            ? $jam->jam_mulai->format('H:i')
                            : \Carbon\Carbon::parse($jam->jam_mulai)->format('H:i'),
                        'jam_selesai' => $jam->jam_selesai instanceof \Carbon\Carbon
                            ? $jam->jam_selesai->format('H:i')
                            : \Carbon\Carbon::parse($jam->jam_selesai)->format('H:i'),
                        'ustadz' => $jam->ustadz,
                    ];
                })->toArray();
        };

        return [
            'safinatunnajah' => $getSchedule('Safinatunnajah'),
            'muqodimah' => $getSchedule('Muqodimah'),
        ];
    }

    private function getRekapBulan(): array
    {
        $bulan = Carbon::now()->month;
        $tahun = Carbon::now()->year;

        $absensiBulan = Absensi::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->selectRaw('status, COUNT(*) as total, SUM(denda) as total_denda')
            ->groupBy('status')
            ->get();

        $result = [
            'hadir' => 0,
            'izin' => 0,
            'sakit' => 0,
            'alpha' => 0,
            'denda' => 0,
        ];

        foreach ($absensiBulan as $item) {
            if (isset($result[$item->status])) {
                $result[$item->status] = $item->total;
                $result['denda'] += $item->total_denda;
            }
        }

        return $result;
    }

    private function getRankingTerbaik(int $limit = 5): \Illuminate\Database\Eloquent\Collection
    {
        $bulan = Carbon::now()->month;
        $tahun = Carbon::now()->year;

        return Santri::where('status', true)
            ->select('santri.*')
            ->selectSub(function ($query) use ($bulan, $tahun) {
                $query->selectRaw('COUNT(*)')
                    ->from('absensi')
                    ->whereColumn('absensi.santri_id', 'santri.id')
                    ->whereMonth('tanggal', $bulan)
                    ->whereYear('tanggal', $tahun)
                    ->where('status', 'hadir');
            }, 'hadir_count')
            ->orderByDesc('hadir_count')
            ->limit($limit)
            ->get()
            ->filter(fn($s) => $s->hadir_count > 0)
            ->values();
    }
}