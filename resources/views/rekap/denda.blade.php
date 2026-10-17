@extends('layouts.app')

@section('title', 'Rekap Denda')

@section('content')
<div class="card">
    <!-- Header Section -->
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-money-check-alt"></i> Rekap Denda Santri
        </h3>
        <div style="display: flex; gap: 8px; align-items: center;">
            <span style="font-size: 13px; color: #64748b;">
                <i class="fas fa-calendar-alt"></i> {{ \Carbon\Carbon::createFromDate($tahun, $bulan, 1)->locale('id')->monthName }} {{ $tahun }}
            </span>
        </div>
    </div>

    <!-- Filter Section -->
    <div style="background: #f8fafc; padding: 20px; border-radius: 12px; margin-bottom: 24px; border: 1px solid #e2e8f0;">
        <form action="{{ route('rekap.denda') }}" method="GET" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; align-items: end;">
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

    <!-- Statistics Card -->
    <div class="stats-grid" style="margin-bottom: 24px;">
        <div class="stat-card">
            <div class="stat-icon red">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <div class="stat-content">
                <h3>Rp {{ number_format($totalDenda, 0, ',', '.') }}</h3>
                <p>Total Denda Bulan Ini</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="fas fa-file-alt"></i>
            </div>
            <div class="stat-content">
                <h3>{{ count($data) }}</h3>
                <p>Jumlah Record Denda</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon purple">
                <i class="fas fa-calculator"></i>
            </div>
            <div class="stat-content">
                <h3>{{ count($data) > 0 ? number_format($totalDenda / count($data), 0, ',', '.') : 0 }}</h3>
                <p>Rata-rata Denda per Record</p>
            </div>
        </div>
    </div>

    <!-- Main Table -->
    @if(count($data) > 0)
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Denda</h3>
            <div style="font-size: 13px; color: #64748b;">
                <i class="fas fa-list"></i> {{ count($data) }} record denda
            </div>
        </div>
        
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 60px;">No</th>
                        <th>Nama Santri</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th class="text-center" style="width: 120px;">Nominal Denda</th>
                        <th class="text-center" style="width: 150px;">Status Pembayaran</th>
                        <th class="text-center" style="width: 120px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $index => $d)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 36px; height: 36px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 13px;">
                                    {{ strtoupper(substr($d['santri']->nama, 0, 1)) }}
                                </div>
                                <div>
                                    <div style="font-weight: 600; color: #1e293b;">{{ $d['santri']->nama }}</div>
                                    <div style="font-size: 11px; color: #94a3b8;">{{ $d['santri']->nis ?? 'N/A' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="font-weight:500; color:#1e293b;">{{ \Carbon\Carbon::parse($d['tanggal'])->format('d M Y') }}</div>
                            <div style="font-size: 11px; color: #94a3b8;">{{ \Carbon\Carbon::parse($d['tanggal'])->locale('id')->dayName }}</div>
                        </td>
                        <td>
                            <span class="badge-status {{ $d['status'] }}">
                                {{ ucfirst($d['status']) }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div style="font-weight: 700; color: #dc2626; font-size: 15px;">
                                Rp {{ number_format($d['denda'], 0, ',', '.') }}
                            </div>
                        </td>
                        <td class="text-center">
                            @if($d['status_pembayaran'] === 'sudah_bayar')
                                <span class="badge badge-success">Sudah bayar</span>
                            @else
                                <span class="badge badge-danger">Belum bayar</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm {{ $d['status_pembayaran'] === 'sudah_bayar' ? 'btn-warning' : 'btn-success' }}" onclick="togglePembayaran({{ $d['absensi']->id }}, this)" title="{{ $d['status_pembayaran'] === 'sudah_bayar' ? 'Tandai Belum Bayar' : 'Tandai Sudah Bayar' }}">
                                <i class="fas {{ $d['status_pembayaran'] === 'sudah_bayar' ? 'fa-undo' : 'fa-check' }}"></i>
                                {{ $d['status_pembayaran'] === 'sudah_bayar' ? 'Belum' : 'Bayar' }}
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Summary Footer -->
        <div style="margin-top: 20px; padding: 16px; background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); border-radius: 10px; border-left: 4px solid #d97706;">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
                <div>
                    <span style="font-size: 13px; color: #92400e; font-weight: 600;">
                        Total Denda: <strong>Rp {{ number_format($totalDenda, 0, ',', '.') }}</strong>
                    </span>
                </div>
                <div style="font-size: 14px; color: #78350f;">
                    <i class="fas fa-info-circle"></i> Denda: Izin × Rp 2.000, Sakit × Rp 2.000, Alpha × Rp 5.000
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="empty-state">
        <i class="fas fa-smile" style="font-size: 64px; color: #10b981; margin-bottom: 24px;"></i>
        <h3 style="color: #059669; font-weight: 600;">Alhamdulillah!</h3>
        <p style="color: #64748b; font-size: 15px;">Tidak ada santri dengan denda pada bulan {{ \Carbon\Carbon::createFromDate($tahun, $bulan, 1)->locale('id')->monthName }} {{ $tahun }}.</p>
        <p style="color: #94a3b8; font-size: 13px; margin-top: 8px;">Semua santri telah memiliki kehadiran yang baik.</p>
    </div>
    @endif
</div>

<script>
function togglePembayaran(absensiId, button) {
    Swal.fire({
        title: 'Ubah status pembayaran?',
        text: 'Apakah Anda yakin ingin mengubah status pembayaran denda ini?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#10b981',
        cancelButtonColor: '#ef4444',
        confirmButtonText: 'Ya, ubah!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            const token = '{{ csrf_token() }}';
            const xhttp = new XMLHttpRequest();
            xhttp.open('POST', '{{ route('rekap.denda.toggle-pembayaran') }}', true);
            xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhttp.setRequestHeader('X-CSRF-TOKEN', token);
            xhttp.send('absensi_id=' + absensiId + '&_token=' + token);

            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    try {
                        var data = JSON.parse(this.responseText);
                        if (data.success) {
                            const isSudahBayar = data.status_pembayaran === 'sudah_bayar';
                            button.className = 'btn btn-sm ' + (isSudahBayar ? 'btn-warning' : 'btn-success');
                            button.title = isSudahBayar ? 'Tandai Belum Bayar' : 'Tandai Sudah Bayar';
                            button.innerHTML = '<i class="fas ' + (isSudahBayar ? 'fa-undo' : 'fa-check') + '"></i> ' + (isSudahBayar ? 'Belum' : 'Bayar');
                            const row = button.closest('tr');
                            const badgeCell = row.querySelector('.text-center:nth-child(6)');
                            if (badgeCell) {
                                badgeCell.innerHTML = isSudahBayar
                                    ? '<span class="badge badge-success">Sudah bayar</span>'
                                    : '<span class="badge badge-danger">Belum bayar</span>';
                            }
                            showToast(data.message, isSudahBayar ? 'success' : 'warning');
                        } else {
                            showToast('Error: ' + (data.error || 'Unknown'), 'error');
                        }
                    } catch (e) {
                        showToast('Error: ' + e.message, 'error');
                    }
                } else if (this.readyState == 4) {
                    showToast('HTTP Error: ' + this.status, 'error');
                }
            };
        }
    });
}
</script>

@endsection