<?php

namespace App\Http\Controllers\Santri;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Santri;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class FineController extends Controller
{
    public function index(Request $request)
    {
        $santri = Auth::user()->santri;
        if (!$santri) {
            return redirect()->back()->with('error', 'Data santri tidak ditemukan.');
        }

        $query = Absensi::where('santri_id', $santri->id);

        // Filter bulan
        if ($request->filled('bulan')) {
            $bulan = (int)$request->input('bulan');
            if ($bulan >= 1 && $bulan <= 12) {
                $query->whereMonth('tanggal', $bulan);
            }
        }

        // Filter tahun
        if ($request->filled('tahun')) {
            $tahun = (int)$request->input('tahun');
            if ($tahun >= 2000 && $tahun <= 2100) {
                $query->whereYear('tanggal', $tahun);
            }
        }

        $absensi = $query->orderBy('tanggal', 'desc')
            ->paginate(15)
            ->appends($request->query());

        // Hitung total denda keseluruhan
        $totalDenda = Absensi::where('santri_id', $santri->id)->sum('denda');

        // Hitung denda bulan ini
        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;

        $bulanStats = Absensi::where('santri_id', $santri->id)
            ->whereMonth('tanggal', $bulanIni)
            ->whereYear('tanggal', $tahunIni)
            ->selectRaw('status, COUNT(*) as total, SUM(denda) as total_denda')
            ->groupBy('status')
            ->pluck('total_denda', 'status')
            ->toArray();

        $totalDendaBulan = array_sum($bulanStats);

        $jumlahAlpha = Absensi::where('santri_id', $santri->id)
            ->whereMonth('tanggal', $bulanIni)
            ->whereYear('tanggal', $tahunIni)
            ->where('status', 'alpha')
            ->count();
        
        $jumlahIzin = Absensi::where('santri_id', $santri->id)
            ->whereMonth('tanggal', $bulanIni)
            ->whereYear('tanggal', $tahunIni)
            ->where('status', 'izin')
            ->count();
        
        $jumlahSakit = Absensi::where('santri_id', $santri->id)
            ->whereMonth('tanggal', $bulanIni)
            ->whereYear('tanggal', $tahunIni)
            ->where('status', 'sakit')
            ->count();

        return view('santri.fine', compact(
            'absensi', 'totalDenda', 'totalDendaBulan',
            'jumlahAlpha', 'jumlahIzin', 'jumlahSakit',
            'santri'
        ));
    }
}