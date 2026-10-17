@extends('layouts.app')

@section('title', 'Laporan')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-file-alt"></i> Laporan Presensi
        </h3>
        <div style="display: flex; gap: 8px; align-items: center;">
            <span style="font-size: 13px; color: #64748b;">
                <i class="fas fa-calendar-alt"></i> {{ \Carbon\Carbon::createFromDate($tahun, $bulan, 1)->locale('id')->monthName }} {{ $tahun }}
            </span>
        </div>
    </div>

    <!-- Filter Section -->
    <div style="background: #f8fafc; padding: 20px; border-radius: 12px; margin-bottom: 24px; border: 1px solid #e2e8f0;">
        <form action="{{ route('laporan.presensi') }}" method="GET" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; align-items: end;">
            <div class="form-group" style="margin-bottom: 0;">
                <label class="form-label">Bulan</label>
                <select name="bulan" class="form-select">
                    @foreach($bulanList as $key => $name)
                    <option value="{{ $key }}" {{ $bulan == $key ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group" style="margin-bottom: 0;">
                <label class="form-label">Tahun</label>
                <select name="tahun" class="form-select">
                    @foreach($tahunList as $t)
                    <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>{{ $t }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <button type="submit" class="btn btn-primary" style="width: 100%;">
                    <i class="fas fa-filter"></i> Filter
                </button>
            </div>
        </form>
    </div>

    <!-- PDF Actions -->
    <div style="display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 24px; padding: 16px; background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border-radius: 12px; border: 1px solid #e2e8f0;">
        <div style="flex: 1; min-width: 200px;">
            <h4 style="font-size: 14px; font-weight: 600; color: #1e293b; margin-bottom: 8px;">
                <i class="fas fa-file-pdf" style="color: #dc2626;"></i> Export PDF
            </h4>
            <p style="font-size: 12px; color: #64748b; margin-bottom: 12px;">Cetak laporan dalam format PDF</p>
            <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                <a href="{{ route('laporan.pdf-rekap', ['bulan' => $bulan, 'tahun' => $tahun]) }}" class="btn btn-sm btn-secondary" target="_blank">
                    <i class="fas fa-chart-bar"></i> Rekap
                </a>
                <a href="{{ route('laporan.pdf-denda', ['bulan' => $bulan, 'tahun' => $tahun]) }}" class="btn btn-sm btn-secondary" target="_blank">
                    <i class="fas fa-money-check-alt"></i> Denda
                </a>
                <a href="{{ route('laporan.pdf-ranking', ['bulan' => $bulan, 'tahun' => $tahun]) }}" class="btn btn-sm btn-secondary" target="_blank">
                    <i class="fas fa-trophy"></i> Ranking
                </a>
                <a href="{{ route('laporan.pdf-complete', ['bulan' => $bulan, 'tahun' => $tahun]) }}" class="btn btn-sm btn-primary" target="_blank">
                    <i class="fas fa-file-alt"></i> Lengkap
                </a>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    @if(count($data) > 0)
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th>Nama Santri</th>
                    <th class="text-center">Hadir</th>
                    <th class="text-center">Izin</th>
                    <th class="text-center">Sakit</th>
                    <th class="text-center">Alpha</th>
                    <th class="text-center">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $index => $d)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 32px; height: 32px; background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 12px;">
                                {{ strtoupper(substr($d['santri']->nama, 0, 1)) }}
                            </div>
                            <span style="font-weight: 500;">{{ $d['santri']->nama }}</span>
                        </div>
                    </td>
                    <td class="text-center"><span class="badge badge-success">{{ $d['hadir'] }}</span></td>
                    <td class="text-center"><span class="badge badge-warning">{{ $d['izin'] }}</span></td>
                    <td class="text-center"><span class="badge badge-info">{{ $d['sakit'] }}</span></td>
                    <td class="text-center"><span class="badge badge-danger">{{ $d['alpha'] }}</span></td>
                    <td class="text-center"><strong>{{ $d['total'] }}</strong></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="empty-state">
        <i class="fas fa-search" style="font-size: 48px; color: #cbd5e1; margin-bottom: 16px;"></i>
        <h3>Tidak Ada Data</h3>
        <p>Tidak ada data presensi untuk bulan dan tahun yang dipilih.</p>
    </div>
    @endif
</div>
@endsection