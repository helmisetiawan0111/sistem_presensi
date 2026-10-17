<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class StatistikController extends Controller
{
    public function index(Request $request): View
    {
        $bulan = $request->bulan ?? Carbon::now()->month;
        $tahun = $request->tahun ?? Carbon::now()->year;

        $statusAggregate = Absensi::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->selectRaw('status, COUNT(*) as total, SUM(denda) as total_denda')
            ->groupBy('status')
            ->get();

        $statusCounts = [
            'hadir' => 0,
            'izin' => 0,
            'sakit' => 0,
            'alpha' => 0,
        ];
        $totalDenda = 0;

        foreach ($statusAggregate as $item) {
            if (isset($statusCounts[$item->status])) {
                $statusCounts[$item->status] = (int)$item->total;
            }
            $totalDenda += (int)($item->total_denda ?? 0);
        }

        $absensiDataPerDay = Absensi::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->selectRaw('DATE(tanggal) as date, status, COUNT(*) as count')
            ->groupBy('date', 'status')
            ->get()
            ->keyBy(fn($item) => $item->date . '_' . $item->status);

        $dailyData = [];
        $daysInMonth = Carbon::createFromDate($tahun, $bulan, 1)->daysInMonth;

        for ($i = 1; $i <= $daysInMonth; $i++) {
            $tgl = Carbon::createFromDate($tahun, $bulan, $i);
            $dateStr = $tgl->toDateString();
            
            $dailyData[] = [
                'tanggal' => $tgl->format('d'),
                'hari' => $tgl->locale('id')->dayName,
                'hadir' => $absensiDataPerDay[$dateStr . '_hadir']->count ?? 0,
                'izin' => $absensiDataPerDay[$dateStr . '_izin']->count ?? 0,
                'sakit' => $absensiDataPerDay[$dateStr . '_sakit']->count ?? 0,
                'alpha' => $absensiDataPerDay[$dateStr . '_alpha']->count ?? 0,
            ];
        }

        $bulanList = [];
        for ($i = 1; $i <= 12; $i++) {
            $bulanList[$i] = Carbon::createFromDate($tahun, $i, 1)->locale('id')->monthName;
        }

        $tahunList = range(Carbon::now()->year - 2, Carbon::now()->year);

        return view('statistik.index', compact(
            'bulan',
            'tahun',
            'statusCounts',
            'totalDenda',
            'dailyData',
            'bulanList',
            'tahunList'
        ));
    }
}