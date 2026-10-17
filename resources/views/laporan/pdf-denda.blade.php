<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Denda - {{ $namaBulan }} {{ $tahun }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
        th { background-color: #f0f0f0; }
        .header { text-align: center; margin-bottom: 20px; }
        .title { font-size: 18px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">LAPORAN DENDA</div>
        <div>Bulan: {{ $namaBulan }} {{ $tahun }}</div>
        <div> Madrasah Diniyah Salafiyah PPTQ Al-Asy'ariyyah Pusat</div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Santri</th>
                <th>Izin</th>
                <th>Sakit</th>
                <th>Alpha</th>
                <th>Total Denda</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $d)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $d['santri']->nama }}</td>
                <td>{{ $d['izin'] }}</td>
                <td>{{ $d['sakit'] }}</td>
                <td>{{ $d['alpha'] }}</td>
                <td>Rp {{ number_format($d['denda'], 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div style="margin-top: 20px;">
        <p><strong>Total Denda Bulan Ini: Rp {{ number_format($totalDenda, 0, ',', '.') }}</strong></p>
    </div>
</body>
</html>