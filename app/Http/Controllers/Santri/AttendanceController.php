<?php

namespace App\Http\Controllers\Santri;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Santri;
use App\Models\JamPelajaran;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $santri = Auth::user()->santri;
        if (!$santri) {
            return redirect()->back()->with('error', 'Data santri tidak ditemukan.');
        }

        $query = Absensi::with('jamPelajaran')
            ->where('santri_id', $santri->id);

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

        // Pencarian berdasarkan status
        if ($request->filled('cari')) {
            $cari = $request->input('cari');
            $query->where('status', 'like', "%{$cari}%");
        }

        $absensi = $query->orderBy('tanggal', 'desc')
            ->orderBy('jam_pelajaran_id', 'asc')
            ->paginate(15)
            ->appends($request->query());

        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        
        $years = range(Carbon::now()->year - 2, Carbon::now()->year + 1);

        return view('santri.attendance', compact(
            'absensi', 'months', 'years', 'santri'
        ));
    }
}