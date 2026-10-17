@extends('layouts.app')

@section('title', 'Detail Santri')

@section('content')
<div class="card" style="margin-bottom: 24px;">
    <div class="card-header">
        <h3 class="card-title">Detail Santri</h3>
        <div style="display: flex; gap: 8px;">
            <a href="{{ route('santri.edit', $santri->id) }}" class="btn btn-secondary">
                <i class="fas fa-edit"></i>
                Edit
            </a>
            <a href="{{ route('santri.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
        </div>
    </div>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
        <div>
            <p style="font-size: 12px; color: var(--gray); margin-bottom: 4px;">Nama</p>
            <p style="font-size: 18px; font-weight: 600;">{{ $santri->nama }}</p>
        </div>
        <div>
            <p style="font-size: 12px; color: var(--gray); margin-bottom: 4px;">NIS</p>
            <p style="font-size: 18px; font-weight: 600;">{{ $santri->nis }}</p>
        </div>
        <div>
            <p style="font-size: 12px; color: var(--gray); margin-bottom: 4px;">Khalaqoh</p>
            <p style="font-size: 18px; font-weight: 600;">
                <span class="badge badge-info">{{ $santri->jenjang }}</span>
            </p>
        </div>
        <div>
            <p style="font-size: 12px; color: var(--gray); margin-bottom: 4px;">Kelas</p>
            <p style="font-size: 18px; font-weight: 600;">{{ $santri->kelas ?? '-' }}</p>
        </div>
        <div>
            <p style="font-size: 12px; color: var(--gray); margin-bottom: 4px;">Status</p>
            <p style="font-size: 18px; font-weight: 600;">
                @if($santri->status)
                <span class="badge badge-success">Aktif</span>
                @else
                <span class="badge badge-danger">Nonaktif</span>
                @endif
            </p>
        </div>
        <div>
            <p style="font-size: 12px; color: var(--gray); margin-bottom: 4px;">Alamat</p>
            <p style="font-size: 16px;">{{ $santri->alamat ?? '-' }}</p>
        </div>
        <div>
            <p style="font-size: 12px; color: var(--gray); margin-bottom: 4px;">No. HP</p>
            <p style="font-size: 16px;">{{ $santri->no_hp ?? '-' }}</p>
        </div>
        <div>
            <p style="font-size: 12px; color: var(--gray); margin-bottom: 4px;">Nama Orang Tua</p>
            <p style="font-size: 16px;">{{ $santri->nama_orang_tua ?? '-' }}</p>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-clipboard-check"></i>
            Riwayat Absensi
        </h3>
    </div>
    
    @if($absensi->count() > 0)
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Hari</th>
                    <th>Urutan</th>
                    <th>Status</th>
                    <th>Denda</th>
                </tr>
            </thead>
            <tbody>
                @foreach($absensi as $a)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($a->tanggal)->format('d M Y') }}</td>
                    <td>{{ $a->hari }}</td>
                    <td>
                        @if($a->jamPelajaran)
                            Jam {{ $a->jamPelajaran->urutan }}
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($a->status === 'hadir')
                        <span class="badge badge-success">Hadir</span>
                        @elseif($a->status === 'izin')
                        <span class="badge badge-warning">Izin</span>
                        @elseif($a->status === 'sakit')
                        <span class="badge badge-info">Sakit</span>
                        @else
                        <span class="badge badge-danger">Alpha</span>
                        @endif
                    </td>
                    <td>Rp {{ number_format($a->denda, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="pagination">
        {{ $absensi->links() }}
    </div>
    @else
    <div class="empty-state">
        <i class="fas fa-clipboard"></i>
        <h3>Belum Ada Riwayat Absensi</h3>
        <p>Belum ada data absensi untuk santri ini</p>
    </div>
    @endif
</div>
@endsection