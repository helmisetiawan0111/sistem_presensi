<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Rekap Absensi Santri - {{ $namaBulan }} {{ $tahun }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: center; }
        th { background-color: #4a90d9; color: white; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .header { text-align: center; }
        .title { font-size: 20px; font-weight: bold; }
        .subtitle { font-size: 14px; color: #666; }
        .summary { margin-top: 20px; padding: 10px; background: #f0f0f0; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">REKAP PRESENSI SANTRI</div>
        <div class="subtitle">Bulan: {{ $namaBulan }} {{ $tahun }}</div>
        <div>Madrasah Diniyah Salafiyah PPTQ Al-Asy'ariyyah Pusat</div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Santri</th>
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
        <strong>Ringkasan Bulan {{ $namaBulan }} {{ $tahun }}:</strong>
        <table style="margin-top: 10px; border: none;">
            <tr>
                <td style="border: none; text-align: right;">Total Hadir:</td>
                <td style="border: none; text-align: left;"><strong>{{ $totalHadir }}</strong></td>
            </tr>
            <tr>
                <td style="border: none; text-align: right;">Total Izin:</td>
                <td style="border: none; text-align: left;"><strong>{{ $totalIzin }}</strong></td>
            </tr>
            <tr>
                <td style="border: none; text-align: right;">Total Sakit:</td>
                <td style="border: none; text-align: left;"><strong>{{ $totalSakit }}</strong></td>
            </tr>
            <tr>
                <td style="border: none; text-align: right;">Total Alpha:</td>
                <td style="border: none; text-align: left;"><strong>{{ $totalAlpha }}</strong></td>
            </tr>
        </table>
    </div>
</body>
</html>