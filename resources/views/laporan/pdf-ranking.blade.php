<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Ranking Kehadiran Santri</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 12px; text-align: center; }
        th { background-color: #f59e0b; color: white; }
        tr:nth-child(even) { background-color: #fef3c7; }
        .header { text-align: center; }
        .title { font-size: 20px; font-weight: bold; }
        .subtitle { font-size: 14px; color: #666; }
        .rank-1 { background-color: #fbbf24 !important; font-weight: bold; }
        .rank-2 { background-color: #d1d5db !important; }
        .rank-3 { background-color: #cd7f32 !important; color: white; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">RANKING KEHADIRAN SANTRI</div>
        <div class="subtitle">Bulan: {{ $namaBulan ?? 'Sekarang' }} {{ $tahun ?? date('Y') }}</div>
        <div>Madrasah Diniyah Al Asy'ariyyah</div>
    </div>
    
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
                    @if($index == 0) 1
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
</body>
</html>