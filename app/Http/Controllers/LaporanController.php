<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Santri;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function presensi(Request $request): View
    {
        $bulan = $request->bulan ?? Carbon::now()->month;
        $tahun = $request->tahun ?? Carbon::now()->year;

        $santri = Santri::select('id', 'nama', 'jenjang', 'status')->where('status', true)->orderBy('nama')->get();

        $absensiData = Absensi::select('santri_id', 'status', 'denda')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->get()
            ->groupBy('santri_id');

        $data = [];
        foreach ($santri as $s) {
            $santriAbsensi = $absensiData->get($s->id, collect());
            
            $data[] = [
                'santri' => $s,
                'hadir' => $santriAbsensi->where('status', 'hadir')->count(),
                'izin' => $santriAbsensi->where('status', 'izin')->count(),
                'sakit' => $santriAbsensi->where('status', 'sakit')->count(),
                'alpha' => $santriAbsensi->where('status', 'alpha')->count(),
                'total' => $santriAbsensi->count(),
            ];
        }

        $namaBulan = Carbon::createFromDate($tahun, $bulan, 1)->locale('id')->monthName;

        $bulanList = [];
        for ($i = 1; $i <= 12; $i++) {
            $bulanList[$i] = Carbon::createFromDate($tahun, $i, 1)->locale('id')->monthName;
        }
        $tahunList = range(Carbon::now()->year - 5, Carbon::now()->year + 1);

        return view('laporan.presensi', compact(
            'data',
            'bulan',
            'tahun',
            'namaBulan',
            'bulanList',
            'tahunList'
        ));
    }

    public function pdfDenda(Request $request)
    {
        set_time_limit(120);
        $bulan = $request->bulan ?? Carbon::now()->month;
        $tahun = $request->tahun ?? Carbon::now()->year;

        $santri = Santri::select('id', 'nama', 'jenjang', 'status')->where('status', true)->orderBy('nama')->get();

        $absensiData = Absensi::select('santri_id', 'status', 'denda')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->get()
            ->groupBy('santri_id');

        $data = [];
        $totalDenda = 0;

        foreach ($santri as $s) {
            $santriAbsensi = $absensiData->get($s->id, collect());
            $santriDenda = $santriAbsensi->sum('denda');

            if ($santriDenda > 0) {
                $data[] = [
                    'santri' => $s,
                    'denda' => $santriDenda,
                    'izin' => $santriAbsensi->where('status', 'izin')->count(),
                    'sakit' => $santriAbsensi->where('status', 'sakit')->count(),
                    'alpha' => $santriAbsensi->where('status', 'alpha')->count(),
                ];
                $totalDenda += $santriDenda;
            }
        }

        usort($data, function ($a, $b) {
            return $b['denda'] - $a['denda'];
        });

        $namaBulan = Carbon::createFromDate($tahun, $bulan, 1)->locale('id')->monthName;

        $pdf = Pdf::loadView('laporan.pdf-denda', compact(
            'data',
            'bulan',
            'tahun',
            'namaBulan',
            'totalDenda'
        ));

        return $pdf->download('laporan-denda-' . $namaBulan . '-' . $tahun . '.pdf');
    }

    public function pdfRekap(Request $request)
    {
        set_time_limit(120);
        $bulan = $request->bulan ?? Carbon::now()->month;
        $tahun = $request->tahun ?? Carbon::now()->year;

        $santri = Santri::select('id', 'nama', 'jenjang', 'status')->where('status', true)->orderBy('nama')->get();

        $absensiData = Absensi::select('santri_id', 'status', 'denda')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->get()
            ->groupBy('santri_id');

        $data = [];
        foreach ($santri as $s) {
            $santriAbsensi = $absensiData->get($s->id, collect());
            $data[] = [
                'santri' => $s,
                'hadir' => $santriAbsensi->where('status', 'hadir')->count(),
                'izin' => $santriAbsensi->where('status', 'izin')->count(),
                'sakit' => $santriAbsensi->where('status', 'sakit')->count(),
                'alpha' => $santriAbsensi->where('status', 'alpha')->count(),
                'total' => $santriAbsensi->count(),
            ];
        }

        $namaBulan = Carbon::createFromDate($tahun, $bulan, 1)->locale('id')->monthName;
        $allAbsensi = $absensiData->flatten();
        $totalHadir = $allAbsensi->where('status', 'hadir')->count();
        $totalIzin = $allAbsensi->where('status', 'izin')->count();
        $totalSakit = $allAbsensi->where('status', 'sakit')->count();
        $totalAlpha = $allAbsensi->where('status', 'alpha')->count();

        $pdf = Pdf::loadView('laporan.pdf-rekap', compact(
            'data',
            'bulan',
            'tahun',
            'namaBulan',
            'totalHadir',
            'totalIzin',
            'totalSakit',
            'totalAlpha'
        ));

        return $pdf->download('rekap-absensi-' . $namaBulan . '-' . $tahun . '.pdf');
    }

    public function pdfRanking()
    {
        set_time_limit(120);
        $ranking = Absensi::select('santri_id')
            ->whereMonth('tanggal', Carbon::now()->month)
            ->whereYear('tanggal', Carbon::now()->year)
            ->where('status', 'hadir')
            ->groupBy('santri_id')
            ->selectRaw('COUNT(*) as hadir_count')
            ->orderByDesc('hadir_count')
            ->limit(10)
            ->with('santri')
            ->get();

        $namaBulan = Carbon::now()->locale('id')->monthName;
        $tahun = Carbon::now()->year;

        $pdf = Pdf::loadView('laporan.pdf-ranking', compact('ranking', 'namaBulan', 'tahun'));
        return $pdf->download('ranking-kehadiran.pdf');
    }

    public function pdfComplete(Request $request)
    {
        set_time_limit(120);
        $bulan = $request->bulan ?? Carbon::now()->month;
        $tahun = $request->tahun ?? Carbon::now()->year;

        $santri = Santri::select('id', 'nama', 'jenjang', 'status')->where('status', true)->orderBy('nama')->get();

        $absensiData = Absensi::select('santri_id', 'status', 'denda')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->get()
            ->groupBy('santri_id');

        $data = [];
        foreach ($santri as $s) {
            $santriAbsensi = $absensiData->get($s->id, collect());
            $data[] = [
                'santri' => $s,
                'hadir' => $santriAbsensi->where('status', 'hadir')->count(),
                'izin' => $santriAbsensi->where('status', 'izin')->count(),
                'sakit' => $santriAbsensi->where('status', 'sakit')->count(),
                'alpha' => $santriAbsensi->where('status', 'alpha')->count(),
                'denda' => $santriAbsensi->sum('denda'),
                'total' => $santriAbsensi->count(),
            ];
        }

        $namaBulan = Carbon::createFromDate($tahun, $bulan, 1)->locale('id')->monthName;
        $allAbsensi = $absensiData->flatten();
        $totalHadir = $allAbsensi->where('status', 'hadir')->count();
        $totalIzin = $allAbsensi->where('status', 'izin')->count();
        $totalSakit = $allAbsensi->where('status', 'sakit')->count();
        $totalAlpha = $allAbsensi->where('status', 'alpha')->count();
        $totalDenda = $allAbsensi->sum('denda');

        $ranking = Absensi::select('santri_id')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->where('status', 'hadir')
            ->groupBy('santri_id')
            ->selectRaw('COUNT(*) as hadir_count')
            ->orderByDesc('hadir_count')
            ->limit(10)
            ->with('santri')
            ->get();

        $printedAt = Carbon::now()->format('d M Y H:i');

        $pdf = Pdf::loadView('laporan.pdf-complete', compact(
            'data',
            'bulan',
            'tahun',
            'namaBulan',
            'totalHadir',
            'totalIzin',
            'totalSakit',
            'totalAlpha',
            'totalDenda',
            'ranking',
            'printedAt'
        ));

        return $pdf->download('laporan-selesai-' . $namaBulan . '-' . $tahun . '.pdf');
    }
}