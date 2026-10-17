<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Santri;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RekapPresensiExport;

class RekapController extends Controller
{
    /**
     * Original method - untuk halaman ranking (tidak diubah)
     */
    public function ranking(Request $request): View
    {
        $bulan = $request->bulan ?? Carbon::now()->month;
        $tahun = $request->tahun ?? Carbon::now()->year;

        $santri = Santri::select('id', 'nama', 'jenjang', 'status')->where('status', true)->orderBy('nama')->get();

        $absensiAggregate = Absensi::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->where('status', 'hadir')
            ->select('santri_id', DB::raw('COUNT(*) as hadir_count'))
            ->groupBy('santri_id')
            ->get()
            ->keyBy('santri_id');

        $data = [];
        foreach ($santri as $s) {
            $agg = $absensiAggregate->get($s->id);
            $hadir = $agg ? (int)$agg->hadir_count : 0;
            
            $data[] = [
                'santri' => $s,
                'hadir' => $hadir,
                'izin' => 0,
                'sakit' => 0,
                'alpha' => 0,
                'total' => $hadir,
            ];
        }

        usort($data, function ($a, $b) {
            return $b['hadir'] - $a['hadir'];
        });

        foreach ($data as $i => $d) {
            $data[$i]['rank'] = $i + 1;
        }

        $bulanList = [];
        for ($i = 1; $i <= 12; $i++) {
            $bulanList[$i] = Carbon::createFromDate($tahun, $i, 1)->locale('id')->monthName;
        }

        $tahunList = range(Carbon::now()->year - 2, Carbon::now()->year);

        return view('rekap.ranking', compact(
            'data',
            'bulan',
            'tahun',
            'bulanList',
            'tahunList'
        ));
    }

    /**
     * Original method - untuk halaman denda (tidak diubah)
     */
    public function denda(Request $request): View
    {
        $bulan = $request->bulan ?? Carbon::now()->month;
        $tahun = $request->tahun ?? Carbon::now()->year;

        $absensiData = Absensi::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->where('denda', '>', 0)
            ->orderBy('tanggal', 'desc')
            ->with('santri:id,nama,nis,jenjang,status')
            ->get(['santri_id', 'denda', 'status', 'tanggal', 'status_pembayaran']);

        $data = [];
        $totalDenda = 0;

        foreach ($absensiData as $absensi) {
            $data[] = [
                'absensi' => $absensi,
                'santri' => $absensi->santri,
                'denda' => $absensi->denda,
                'status' => $absensi->status,
                'tanggal' => $absensi->tanggal,
                'status_pembayaran' => $absensi->status_pembayaran,
            ];
            $totalDenda += $absensi->denda;
        }

        $bulanList = [];
        for ($i = 1; $i <= 12; $i++) {
            $bulanList[$i] = Carbon::createFromDate($tahun, $i, 1)->locale('id')->monthName;
        }

        $tahunList = range(Carbon::now()->year - 2, Carbon::now()->year);

        return view('rekap.denda', compact(
            'data',
            'bulan',
            'tahun',
            'totalDenda',
            'bulanList',
            'tahunList'
        ));
    }

    /**
     * NEW: Rekap Presensi dengan UI modern
     */
    public function presensi(Request $request): View
    {
        $bulan = $request->bulan ?? Carbon::now()->month;
        $tahun = $request->tahun ?? Carbon::now()->year;
        $kelas = $request->kelas ?? '';
        $search = $request->search ?? '';

        // Base Santri query with filters
        $santriQuery = Santri::where('status', true);
        if ($kelas) {
            $santriQuery->where('kelas', $kelas);
        }
        if ($search) {
            $santriQuery->where('nama', 'like', '%' . $search . '%');
        }

        // Get all filtered santri (for sorting & ranking)
        $allSantri = $santriQuery->get();
        $totalSantri = $allSantri->count();

        // Total pertemuan for the month
        $totalPertemuan = $this->calculateTotalPertemuan($bulan, $tahun);

        // Get aggregated absensi data for all filtered santri at once (optimized query)
        $santriIds = $allSantri->pluck('id')->toArray();

        $absensiAggregate = Absensi::whereIn('santri_id', $santriIds)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->select(
                'santri_id',
                DB::raw('COUNT(*) as total'),
                DB::raw("SUM(CASE WHEN status = 'hadir' THEN 1 ELSE 0 END) as hadir"),
                DB::raw("SUM(CASE WHEN status = 'izin' THEN 1 ELSE 0 END) as izin"),
                DB::raw("SUM(CASE WHEN status = 'sakit' THEN 1 ELSE 0 END) as sakit"),
                DB::raw("SUM(CASE WHEN status = 'alpha' THEN 1 ELSE 0 END) as alpha")
            )
            ->groupBy('santri_id')
            ->get()
            ->keyBy('santri_id');

        // Build data array
        $dataArray = [];
        foreach ($allSantri as $s) {
            $agg = $absensiAggregate->get($s->id);
            $hadir = $agg ? (int)$agg->hadir : 0;
            $izin = $agg ? (int)$agg->izin : 0;
            $sakit = $agg ? (int)$agg->sakit : 0;
            $alpha = $agg ? (int)$agg->alpha : 0;
            $total = $agg ? (int)$agg->total : 0;
            $persentase = $totalPertemuan > 0 ? round(($hadir / $totalPertemuan) * 100, 2) : 0;

            $dataArray[] = [
                'santri' => $s,
                'hadir' => $hadir,
                'izin' => $izin,
                'sakit' => $sakit,
                'alpha' => $alpha,
                'total' => $total,
                'persentase' => $persentase,
            ];
        }

        // Sort by hadir descending
        usort($dataArray, function ($a, $b) {
            return $b['hadir'] - $a['hadir'];
        });

        // Add ranking
        foreach ($dataArray as $i => &$item) {
            $item['rank'] = $i + 1;
        }
        unset($item);

        // Get top 10 for chart
        $topData = collect($dataArray)->take(10);

        // Manual pagination
        $page = $request->get('page', 1);
        $perPage = 10;
        $offset = ($page - 1) * $perPage;
        $paginatedItems = array_slice($dataArray, $offset, $perPage);
        $total = count($dataArray);

        $data = new LengthAwarePaginator(
            $paginatedItems,
            $total,
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->except('page')]
        );

        // Overall statistics
        $totalHadir = collect($dataArray)->sum('hadir');
        $totalIzin = collect($dataArray)->sum('izin');
        $totalSakit = collect($dataArray)->sum('sakit');
        $totalAlpha = collect($dataArray)->sum('alpha');
        $avgKehadiran = $totalSantri > 0 ? round(($totalHadir / ($totalSantri * $totalPertemuan)) * 100, 2) : 0;

        // Kelas list for filter dropdown
        $kelasList = Santri::where('status', true)
            ->distinct()
            ->pluck('kelas')
            ->filter()
            ->sort()
            ->values()
            ->toArray();

        // Bulan & tahun list
        $bulanList = [];
        for ($i = 1; $i <= 12; $i++) {
            $bulanList[$i] = Carbon::createFromDate($tahun, $i, 1)->locale('id')->monthName;
        }
        $tahunList = range(Carbon::now()->year - 5, Carbon::now()->year + 1);

        return view('rekap.presensi', compact(
            'data',
            'bulan',
            'tahun',
            'kelas',
            'search',
            'totalSantri',
            'totalHadir',
            'totalIzin',
            'totalSakit',
            'totalAlpha',
            'avgKehadiran',
            'totalPertemuan',
            'bulanList',
            'tahunList',
            'kelasList',
            'topData'
        ));
    }

    public function togglePembayaran(Request $request)
    {
        $request->validate([
            'absensi_id' => 'required|integer|exists:absensi,id',
        ]);

        $absensi = Absensi::findOrFail($request->absensi_id);
        $absensi->status_pembayaran = $absensi->status_pembayaran === 'sudah_bayar' ? 'belum_bayar' : 'sudah_bayar';
        $absensi->save();

        return response()->json([
            'success' => true,
            'status_pembayaran' => $absensi->status_pembayaran,
            'message' => $absensi->status_pembayaran === 'sudah_bayar' ? 'Denda sudah ditandai lunas' : 'Denda dikembalikan ke belum bayar'
        ]);
    }

    /**
     * Calculate total pertemuan (meetings) for given month/year
     * Based on rules: Jumat = 1 session/day, other weekdays = 3 sessions/day
     */
    private function calculateTotalPertemuan(int $bulan, int $tahun): int
    {
        $totalSessions = 0;
        $daysInMonth = Carbon::createFromDate($tahun, $bulan, 1)->daysInMonth;

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::createFromDate($tahun, $bulan, $day);
            $dayName = $date->locale('id')->dayName; // Senin, Selasa, etc.

            if ($dayName === 'Jumat') {
                $totalSessions += 1;
            } elseif (in_array($dayName, ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Sabtu'])) {
                $totalSessions += 3;
            }
            // Minggu (Sunday) = 0 sessions
        }

        return $totalSessions;
    }

    /**
     * Build rekap data array for given santri IDs
     * Returns sorted data (by hadir desc) with ranking
     */
    private function buildRekapData(array $santriIds, int $bulan, int $tahun, int $totalPertemuan): array
    {
        if (empty($santriIds)) {
            return [];
        }

        $santriList = Santri::whereIn('id', $santriIds)->get();

        $absensiAggregate = Absensi::whereIn('santri_id', $santriIds)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->select(
                'santri_id',
                DB::raw('COUNT(*) as total'),
                DB::raw("SUM(CASE WHEN status = 'hadir' THEN 1 ELSE 0 END) as hadir"),
                DB::raw("SUM(CASE WHEN status = 'izin' THEN 1 ELSE 0 END) as izin"),
                DB::raw("SUM(CASE WHEN status = 'sakit' THEN 1 ELSE 0 END) as sakit"),
                DB::raw("SUM(CASE WHEN status = 'alpha' THEN 1 ELSE 0 END) as alpha")
            )
            ->groupBy('santri_id')
            ->get()
            ->keyBy('santri_id');

        $dataArray = [];
        foreach ($santriList as $s) {
            $agg = $absensiAggregate->get($s->id);
            $hadir = $agg ? (int)$agg->hadir : 0;
            $izin = $agg ? (int)$agg->izin : 0;
            $sakit = $agg ? (int)$agg->sakit : 0;
            $alpha = $agg ? (int)$agg->alpha : 0;
            $total = $agg ? (int)$agg->total : 0;
            $persentase = $totalPertemuan > 0 ? round(($hadir / $totalPertemuan) * 100, 2) : 0;

            $dataArray[] = [
                'santri' => $s,
                'hadir' => $hadir,
                'izin' => $izin,
                'sakit' => $sakit,
                'alpha' => $alpha,
                'total' => $total,
                'persentase' => $persentase,
            ];
        }

        // Sort by hadir descending
        usort($dataArray, fn($a, $b) => $b['hadir'] - $a['hadir']);

        // Add ranking
        foreach ($dataArray as $i => &$item) {
            $item['rank'] = $i + 1;
        }
        unset($item);

        return $dataArray;
    }

    /**
     * Get rekap data aggregated per santri
     */
    private function getRekapData($santriList, $absensiData, int $totalPertemuan): array
    {
        $result = [];

        foreach ($santriList as $s) {
            $santriAbsensi = $absensiData->where('santri_id', $s->id);

            $hadir = $santriAbsensi->where('status', 'hadir')->count();
            $izin = $santriAbsensi->where('status', 'izin')->count();
            $sakit = $santriAbsensi->where('status', 'sakit')->count();
            $alpha = $santriAbsensi->where('status', 'alpha')->count();
            $total = $santriAbsensi->count();
            $persentase = $totalPertemuan > 0 ? round(($hadir / $totalPertemuan) * 100, 2) : 0;

            $result[] = [
                'santri' => $s,
                'hadir' => $hadir,
                'izin' => $izin,
                'sakit' => $sakit,
                'alpha' => $alpha,
                'total' => $total,
                'persentase' => $persentase,
                'total_pertemuan' => $totalPertemuan,
            ];
        }

        return $result;
    }

    /**
     * Export to Excel
     */
    public function exportExcel(Request $request)
    {
        $bulan = $request->bulan ?? Carbon::now()->month;
        $tahun = $request->tahun ?? Carbon::now()->year;
        $kelas = $request->kelas ?? '';
        $search = $request->search ?? '';

        $fileName = 'rekap-presensi-' . Carbon::createFromDate($tahun, $bulan, 1)->locale('id')->monthName . '-' . $tahun . '.xlsx';

        return Excel::download(new RekapPresensiExport($bulan, $tahun, $kelas, $search), $fileName);
    }

    /**
     * Print view (browser print)
     */
    public function print(Request $request)
    {
        $bulan = $request->bulan ?? Carbon::now()->month;
        $tahun = $request->tahun ?? Carbon::now()->year;
        $kelas = $request->kelas ?? '';
        $search = $request->search ?? '';

        $santriQuery = Santri::where('status', true);
        if ($kelas) {
            $santriQuery->where('kelas', $kelas);
        }
        if ($search) {
            $santriQuery->where('nama', 'like', '%' . $search . '%');
        }
        $santriList = $santriQuery->get();
        $santriIds = $santriList->pluck('id')->toArray();

        $totalPertemuan = $this->calculateTotalPertemuan($bulan, $tahun);

        // Build rekap data using optimized query
        $rekapData = $this->buildRekapData($santriIds, $bulan, $tahun, $totalPertemuan);

        $namaBulan = Carbon::createFromDate($tahun, $bulan, 1)->locale('id')->monthName;
        $totalHadir = collect($rekapData)->sum('hadir');
        $totalIzin = collect($rekapData)->sum('izin');
        $totalSakit = collect($rekapData)->sum('sakit');
        $totalAlpha = collect($rekapData)->sum('alpha');

        return view('rekap.print-presensi', compact(
            'rekapData',
            'namaBulan',
            'tahun',
            'totalPertemuan',
            'totalHadir',
            'totalIzin',
            'totalSakit',
            'totalAlpha'
        ));
    }
}