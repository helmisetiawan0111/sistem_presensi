<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Lengkap Absensi - {{ $namaBulan }} {{ $tahun }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; }
        .header { text-align: center; margin-bottom: 20px; }
        .title { font-size: 18px; font-weight: bold; }
        .subtitle { font-size: 12px; color: #666; }
        h2 { font-size: 14px; margin-top: 30px; background: #4a90d9; color: white; padding: 8px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: center; }
        th { background-color: #4a90d9; color: white; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .summary { margin-top: 20px; padding: 10px; background: #f0f0f0; border-radius: 5px; }
        .footer { margin-top: 30px; text-align: right; font-size: 10px; }
        .page-break { page-break-after: always; }
        .rank-1 { background-color: #fbbf24 !important; font-weight: bold; }
        .rank-2 { background-color: #d1d5db !important; }
        .rank-3 { background-color: #cd7f32 !important; color: white; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">LAPORAN LENGKAP PRESENSI SANTRI</div>
        <div class="subtitle">Bulan: {{ $namaBulan }} {{ $tahun }}</div>
        <div>Madrasah Diniyah Salafiyah PPTQ Al-Asy'ariyyah Pusat</div>
    </div>

    <!-- Bagian 1: Rekap Absensi Santri -->
    <h2>REKAP PRESENSI SANTRI</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Santri</th>
                <th>Khalaqoh</th>
                <th>Hadir</th>
                <th>Izin</th>
                <th>Sakit</th>
                <th>Alpha</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $d)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td style="text-align: left;">{{ $d['santri']->nama }}</td>
                <td>{{ $d['santri']->jenjang }}</td>
                <td>{{ $d['hadir'] }}</td>
                <td>{{ $d['izin'] }}</td>
                <td>{{ $d['sakit'] }}</td>
                <td>{{ $d['alpha'] }}</td>
                <td>{{ $d['total'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <strong>Ringkasan {{ $namaBulan }} {{ $tahun }}:</strong>
        <table style="border: none; margin-top: 10px;">
            <tr>
                <td style="border: none;">Total Hadir:</td>
                <td style="border: none;"><strong>{{ $totalHadir }}</strong></td>
                <td style="border: none;">Total Izin:</td>
                <td style="border: none;"><strong>{{ $totalIzin }}</strong></td>
                <td style="border: none;">Total Sakit:</td>
                <td style="border: none;"><strong>{{ $totalSakit }}</strong></td>
                <td style="border: none;">Total Alpha:</td>
                <td style="border: none;"><strong>{{ $totalAlpha }}</strong></td>
            </tr>
        </table>
    </div>

    <!-- Bagian 2: Rekap Denda -->
    <h2>REKAP DENDA</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Santri</th>
                <th>Izin (Rp2.000)</th>
                <th>Sakit (Rp2.000)</th>
                <th>Alpha (Rp5.000)</th>
                <th>Total Denda</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $d)
            @if($d['denda'] > 0)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td style="text-align: left;">{{ $d['santri']->nama }}</td>
                <td>{{ $d['izin'] * 2000 }}</td>
                <td>{{ $d['sakit'] * 2000 }}</td>
                <td>{{ $d['alpha'] * 5000 }}</td>
                <td>Rp {{ number_format($d['denda'], 0, ',', '.') }}</td>
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>
    <div class="summary">
        <strong>Total Denda Bulan Ini: Rp {{ number_format($totalDenda, 0, ',', '.') }}</strong>
    </div>

    <!-- Bagian 3: Ranking -->
    <h2>RANKING KEHADIRAN TERBAIK</h2>
    <table>
        <thead>
            <tr>
                <th>Peringkat</th>
                <th>Nama Santri</th>
                <th>Jumlah Hadir</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ranking as $index => $r)
            <tr class="rank-{{ $index + 1 }}">
                <td>
                    @if($index == 0)                     1
                    @elseif($index == 1) 2
                    @elseif($index == 2) 3
                    @else {{ $index + 1 }}
                    @endif
                </td>
                <td style="text-align: left;">{{ $r->santri->nama ?? 'Unknown' }}</td>
                <td><strong>{{ $r->hadir_count }}x</strong></td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ $printedAt }}
    </div>
</body>
</html>