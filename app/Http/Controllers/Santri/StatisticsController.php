<?php

namespace App\Http\Controllers\Santri;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Santri;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class StatisticsController extends Controller
{
    public function index(Request $request)
    {
        $santri = Auth::user()->santri;
        if (!$santri) {
            return redirect()->back()->with('error', 'Data santri tidak ditemukan.');
        }

        $tahun = Carbon::now()->year;

        // Ambil data per bulan untuk grafik kehadiran per bulan
        $months = range(1, 12);
        $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'];

        $dataHadir = [];
        $dataAlpha = [];
        $dataIzin = [];
        $dataSakit = [];

        foreach ($months as $bulan) {
            $absensi = Absensi::where('santri_id', $santri->id)
                ->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal', $tahun)
                ->selectRaw('status, COUNT(*) as total')
                ->groupBy('status')
                ->pluck('total', 'status')
                ->toArray();

            $dataHadir[] = $absensi['hadir'] ?? 0;
            $dataAlpha[] = $absensi['alpha'] ?? 0;
            $dataIzin[]  = $absensi['izin']  ?? 0;
            $dataSakit[] = $absensi['sakit'] ?? 0;
        }

        // Distribusi status bulan ini
        $bulanIni = Carbon::now()->month;
        $statusBulanIni = Absensi::where('santri_id', $santri->id)
            ->whereMonth('tanggal', $bulanIni)
            ->whereYear('tanggal', $tahun)
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $statusLabels = ['Hadir', 'Alpha', 'Izin', 'Sakit'];
        $statusData = [
            $statusBulanIni['hadir'] ?? 0,
            $statusBulanIni['alpha'] ?? 0,
            $statusBulanIni['izin']  ?? 0,
            $statusBulanIni['sakit'] ?? 0,
        ];

        // Persentase kehadiran tahun ini (total hadir / (12 * 30) * 100) aslinya
        $totalHadirTahun = array_sum($dataHadir);
        $totalHariTahun = 12 * 30; // asumsi 30 hari per bulan
        $persentaseKehadiranTahun = $totalHariTahun > 0 ? round(($totalHadirTahun / $totalHariTahun) * 100, 2) : 0;

        return view('santri.statistics', compact(
            'labels', 'dataHadir', 'dataAlpha', 'dataIzin', 'dataSakit',
            'statusLabels', 'statusData',
            'persentaseKehadiranTahun',
            'santri'
        ));
    }
}