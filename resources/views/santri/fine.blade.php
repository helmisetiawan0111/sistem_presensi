@extends('layouts.app')

@section('title', 'Rekap Denda Saya')

@push('styles')
<style>
.total-card {
    background: linear-gradient(135deg, #06d950 0%, #f59e0b 100%);
    color: white;
    border-radius: 16px;
    padding: 1.5rem;
    text-align: center;
    margin-bottom: 1.5rem;
}

.total-card .amount {
    font-size: 2rem;
    font-weight: 700;
}

.total-card .label {
    font-size: 0.85rem;
    opacity: 0.9;
}

.stat-card-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.stat-card {
    background: #f8fafc;
    border-radius: 12px;
    padding: 1rem;
    text-align: center;
    border: 1px solid #e2e8f0;
    transition: all 0.25s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.06);
}

.stat-card .icon {
    font-size: 1.25rem;
    margin-bottom: 0.5rem;
}

.stat-card .icon.text-warning { color: #f59e0b; }
.stat-card .icon.text-danger { color: #ef4444; }
.stat-card .icon.text-info { color: #0891b2; }

.stat-card .number {
    font-size: 1rem;
    font-weight: 600;
    color: #1e293b;
}

.stat-card .label {
    font-size: 0.75rem;
    color: #64748b;
}

.denda-table th {
    background: #f8fafc;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
}

.denda-table td {
    font-size: 0.85rem;
}

.table-row-header {
    font-weight: 500;
}

.table-row-subtext {
    font-size: 0.75rem;
    color: #64748b;
}
</style>
@endpush

@section('content')
    <!-- Total Denda Card -->
    <div class="total-card">
        <div class="label">Total Denda Keseluruhan</div>
        <div class="amount">Rp {{ number_format($totalDenda, 0, ',', '.') }}</div>
    </div>

    <!-- Statistik Kecil -->
    <div class="stat-card-grid">
        <div class="stat-card">
            <div class="icon text-warning"><i class="fas fa-calendar-alt"></i></div>
            <div class="number">Rp {{ number_format($totalDendaBulan, 0, ',', '.') }}</div>
            <div class="label">Bulan Ini</div>
        </div>
        <div class="stat-card">
            <div class="icon text-danger"><i class="fas fa-times-circle"></i></div>
            <div class="number">{{ $jumlahAlpha }}</div>
            <div class="label">Alpha</div>
        </div>
        <div class="stat-card">
            <div class="icon text-warning"><i class="fas fa-clipboard-check"></i></div>
            <div class="number">{{ $jumlahIzin }}</div>
            <div class="label">Izin</div>
        </div>
        <div class="stat-card">
            <div class="icon text-info"><i class="fas fa-notes-medical"></i></div>
            <div class="number">{{ $jumlahSakit }}</div>
            <div class="label">Sakit</div>
        </div>
    </div>

    <div class="section-card">
        <h5 class="mb-3"><i class="fas fa-history"></i> Riwayat Denda</h5>

        <!-- Filter -->
        <form method="GET" action="{{ route('santri.fine') }}">
            <div class="row g-2">
                <div class="col-md-2 col-6">
                    <label class="form-label">Bulan</label>
                    <select name="bulan" class="form-select">
                        <option value="">Semua Bulan</option>
                        @foreach([1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'] as $value => $label)
                            <option value="{{ $value }}" {{ request()->input('bulan') == $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 col-6">
                    <label class="form-label">Tahun</label>
                    <select name="tahun" class="form-select">
                        <option value="">Semua Tahun</option>
                        @php $currentYear = \Carbon\Carbon::now()->year; @endphp
                        @for($y = $currentYear - 2; $y <= $currentYear + 1; $y++)
                            <option value="{{ $y }}" {{ request()->input('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-filter"></i> <span class="d-none d-sm-inline">Filter</span>
                </button>
                <a href="{{ route('santri.fine') }}" class="btn btn-warning">
                    <i class="fas fa-undo"></i> <span class="d-none d-sm-inline">Reset</span>
                </a>
            </div>
        </form>

        <!-- Tabel Riwayat Denda -->
        @if($absensi->isEmpty())
            <div class="empty-state">
                <div class="empty-icon"><i class="fas fa-folder-open"></i></div>
                <p class="empty-text">Tidak ada data denda untuk filter yang dipilih.</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="data-table denda-table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Nominal Denda</th>
                            <th>Status Pembayaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($absensi as $row)
                            <tr>
                                <td>
                                    <div class="table-row-header">{{ \Carbon\Carbon::parse($row->tanggal)->format('d M Y') }}</div>
                                    <div class="table-row-subtext">{{ \Carbon\Carbon::parse($row->tanggal)->locale('id')->dayName }}</div>
                                </td>
                                <td>
                                    <span class="badge-status {{ $row->status }}">
                                        {{ ucfirst($row->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div style="font-weight:600; color:#1e293b;">
                                        @if($row->denda > 0)
                                            Rp {{ number_format($row->denda, 0, ',', '.') }}
                                        @else
                                            -
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @if($row->denda > 0)
                                        @if($row->status_pembayaran === 'sudah_bayar')
                                            <span class="badge badge-success">Sudah bayar</span>
                                        @else
                                            <span class="badge badge-danger">Belum bayar</span>
                                        @endif
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pagination">
                {{ $absensi->links() }}
            </div>
        @endif
    </div>
@endsection