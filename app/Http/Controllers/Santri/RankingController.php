<?php

namespace App\Http\Controllers\Santri;

use App\Http\Controllers\Controller;
use App\Models\Santri;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RankingController extends Controller
{
    public function index(Request $request)
    {
        $authSantri = Auth::user()->santri;
        if (!$authSantri) {
            return redirect()->back()->with('error', 'Data santri tidak ditemukan.');
        }

        $bulan = Carbon::now()->month;
        $tahun = Carbon::now()->year;

        $santriList = Santri::select('id', 'nama', 'nis', 'kelas', 'status')
            ->where('status', true)
            ->orderBy('nama')
            ->get();

        $absensiAggregate = Absensi::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->select('santri_id', DB::raw('COUNT(*) as total_pertemuan'), DB::raw('SUM(CASE WHEN status = "hadir" THEN 1 ELSE 0 END) as hadir_count'))
            ->groupBy('santri_id')
            ->get()
            ->keyBy('santri_id');

        $ranking = [];
        foreach ($santriList as $santri) {
            $agg = $absensiAggregate->get($santri->id);
            $hadir = $agg ? (int)$agg->hadir_count : 0;
            $totalPertemuan = $agg ? (int)$agg->total_pertemuan : 0;
            $persentase = $totalPertemuan > 0 ? round(($hadir / 30) * 100, 2) : 0;

            $ranking[] = [
                'id' => $santri->id,
                'nama' => $santri->nama,
                'nis' => $santri->nis,
                'kelas' => $santri->kelas,
                'hadir_count' => $hadir,
                'persentase' => $persentase,
                'is_me' => $santri->id == $authSantri->id,
            ];
        }

        usort($ranking, function($a, $b) {
            return $b['hadir_count'] <=> $a['hadir_count'];
        });

        $santris = array_slice($ranking, 0, 10);

        foreach ($santris as $index => &$santri) {
            $santri['position'] = $index + 1;
        }

        $myPosition = null;
        foreach ($ranking as $index => $s) {
            if ($s['is_me']) {
                $myPosition = $index + 1;
                break;
            }
        }

        return view('santri.ranking', compact('santris', 'myPosition'));
    }
}