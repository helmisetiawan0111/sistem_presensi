@extends('layouts.app')

@section('title', 'Riwayat Presensi Saya')

@push('styles')
<style>
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
    <div class="section-card mb-3">
        <h5 class="mb-3"><i class="fas fa-search"></i> Filter Pencarian</h5>
        <form method="GET" action="{{ route('santri.attendance') }}">
            <div class="row g-2">
                <div class="col-md-2 col-sm-4 col-6">
                    <label class="form-label">Bulan</label>
                    <select name="bulan" class="form-select">
                        <option value="">Semua Bulan</option>
                        @foreach($months as $value => $label)
                            <option value="{{ $value }}" {{ request()->input('bulan') == $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 col-sm-4 col-6">
                    <label class="form-label">Tahun</label>
                    <select name="tahun" class="form-select">
                        <option value="">Semua Tahun</option>
                        @foreach($years as $year)
                            <option value="{{ $year }}" {{ request()->input('tahun') == $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 col-sm-4 col-6">
                    <label class="form-label">Status</label>
                    <select name="cari" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="hadir" {{ request()->input('cari') == 'hadir' ? 'selected' : '' }}>Hadir</option>
                        <option value="alpha" {{ request()->input('cari') == 'alpha' ? 'selected' : '' }}>Alpha</option>
                        <option value="izin" {{ request()->input('cari') == 'izin' ? 'selected' : '' }}>Izin</option>
                        <option value="sakit" {{ request()->input('cari') == 'sakit' ? 'selected' : '' }}>Sakit</option>
                    </select>
                </div>
            </div>
            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Cari
                </button>
                <a href="{{ route('santri.attendance') }}" class="btn btn-warning">
                    <i class="fas fa-undo"></i> Reset
                </a>
            </div>
        </form>
    </div>

    <div class="section-card">
        @if($absensi->isEmpty())
            <div class="empty-state">
                <div class="empty-icon"><i class="fas fa-folder-open"></i></div>
                <p class="empty-text">Tidak ada data presensi untuk filter yang dipilih.</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Jam Pelajaran</th>
                            <th>Status</th>
                            <th>Keterangan</th>
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
                                    @if($row->jamPelajaran)
                                        {{ $row->jamPelajaran->nama }}
                                        <div class="table-row-subtext">
                                            {{ $row->jamPelajaran->jam_mulai_formatted }} - {{ $row->jamPelajaran->jam_selesai_formatted }}
                                        </div>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <span class="badge-status {{ $row->status }}">
                                        <i class="fas fa-circle me-1" style="font-size:0.5rem;"></i>
                                        {{ ucfirst($row->status) }}
                                    </span>
                                </td>
                                <td>{{ $row->keterangan ?? '-' }}</td>
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