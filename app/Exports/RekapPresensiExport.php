<?php

namespace App\Exports;

use App\Models\Santri;
use App\Models\Absensi;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RekapPresensiExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $bulan;
    protected $tahun;
    protected $kelas;
    protected $search;
    protected $rekapData;

    public function __construct($bulan, $tahun, $kelas = '', $search = '')
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
        $this->kelas = $kelas;
        $this->search = $search;

        $this->prepareData();
    }

    private function prepareData(): void
    {
        $absensiQuery = Absensi::whereMonth('tanggal', $this->bulan)
            ->whereYear('tanggal', $this->tahun);
        $absensiData = $absensiQuery->get();

        $santriQuery = Santri::where('status', true);
        if ($this->kelas) {
            $santriQuery->where('kelas', $this->kelas);
        }
        if ($this->search) {
            $santriQuery->where('nama', 'like', '%' . $this->search . '%');
        }
        $santriList = $santriQuery->orderBy('nama')->get();

        $totalPertemuan = $this->calculateTotalPertemuan($this->bulan, $this->tahun);

        $this->rekapData = collect();
        foreach ($santriList as $s) {
            $santriAbsensi = $absensiData->where('santri_id', $s->id);
            $hadir = $santriAbsensi->where('status', 'hadir')->count();
            $izin = $santriAbsensi->where('status', 'izin')->count();
            $sakit = $santriAbsensi->where('status', 'sakit')->count();
            $alpha = $santriAbsensi->where('status', 'alpha')->count();
            $total = $santriAbsensi->count();
            $persentase = $totalPertemuan > 0 ? round(($hadir / $totalPertemuan) * 100, 2) : 0;

            $this->rekapData->push([
                'santri' => $s,
                'nis' => $s->nis,
                'kelas' => $s->kelas ?? '-',
                'hadir' => $hadir,
                'izin' => $izin,
                'sakit' => $sakit,
                'alpha' => $alpha,
                'total' => $total,
                'persentase' => $persentase,
                'total_pertemuan' => $totalPertemuan,
            ]);
        }

        // Sort by hadir descending
        $this->rekapData = $this->rekapData->sortByDesc('hadir')->values();
    }

    private function calculateTotalPertemuan(int $bulan, int $tahun): int
    {
        $daysInMonth = Carbon::createFromDate($tahun, $bulan, 1)->daysInMonth;
        $totalSessions = 0;

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::createFromDate($tahun, $bulan, $day);
            $dayName = $date->locale('id')->dayName;

            if ($dayName === 'Jumat') {
                $totalSessions += 1;
            } elseif (in_array($dayName, ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Sabtu'])) {
                $totalSessions += 3;
            }
        }

        return $totalSessions;
    }

    public function collection()
    {
        return $this->rekapData;
    }

    public function headings(): array
    {
        return [
            'No',
            'NIS',
            'Nama Santri',
            'Kelas',
            'Hadir',
            'Izin',
            'Sakit',
            'Alpha',
            'Total',
            'Total Pertemuan',
            'Persentase (%)',
        ];
    }

    public function map($row): array
    {
        static $counter = 0;
        $counter++;

        return [
            $counter,
            $row['nis'],
            $row['santri']->nama,
            $row['kelas'],
            $row['hadir'],
            $row['izin'],
            $row['sakit'],
            $row['alpha'],
            $row['total'],
            $row['total_pertemuan'],
            $row['persentase'],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1 => ['font' => ['bold' => true, 'size' => 10]],

            // Apply borders to all cells
            'A1:K' . ($this->rekapData->count() + 1) => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ],

            // Header background
            'A1:K1' => [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '1e40af'],
                ],
                'font' => ['color' => ['rgb' => 'ffffff']],
            ],

            // Alternating row colors
            'A2:K' . ($this->rekapData->count() + 1) => [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'f9fafb'],
                ],
            ],

            // Odd rows - white background
            'A2:K2' => ['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'ffffff']]],
            'A4:K4' => ['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'ffffff']]],
            'A6:K6' => ['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'ffffff']]],
            'A8:K8' => ['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'ffffff']]],
            'A10:K10' => ['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'ffffff']]],
            // etc - you can add more if needed
        ];
    }
}
