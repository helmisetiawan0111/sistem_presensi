@extends('layouts.app')

@section('title', 'Rekap Presensi')

@section('content')
<div class="card">
    <!-- Header Section -->
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-chart-bar"></i> Rekap Presensi Santri
        </h3>
        <div style="display: flex; gap: 8px; align-items: center;">
            <span style="font-size: 13px; color: #64748b;">
                <i class="fas fa-calendar-alt"></i> {{ \Carbon\Carbon::createFromDate($tahun, $bulan, 1)->locale('id')->monthName }} {{ $tahun }}
            </span>
        </div>
    </div>

    <!-- Filter Section -->
    <div style="background: #f8fafc; padding: 20px; border-radius: 12px; margin-bottom: 24px; border: 1px solid #e2e8f0;">
        <form action="{{ route('rekap.presensi') }}" method="GET" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; align-items: end;">
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
            <div class="form-group" style="margin-bottom: 0;">
                <label class="form-label">Kelas</label>
                <select name="kelas" class="form-select">
                    <option value="">Semua Kelas</option>
                    @foreach($kelasList as $k)
                    <option value="{{ $k }}" {{ $kelas == $k ? 'selected' : '' }}>{{ $k }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group" style="margin-bottom: 0;">
                <label class="form-label">Cari Nama Santri</label>
                <input type="text" name="search" class="form-input" placeholder="Ketikan nama..." value="{{ $search }}">
            </div>
            <div>
                <button type="submit" class="btn btn-primary" style="width: 100%;">
                    <i class="fas fa-filter"></i> Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Results Summary -->
        <div style="margin-bottom: 16px; padding: 12px 16px; background: #dbeafe; border-radius: 8px; border-left: 4px solid #1e40af; font-size: 13px;">
            <i class="fas fa-info-circle"></i>
            Menampilkan <strong>{{ $data->count() }}</strong> dari <strong>{{ $data->total() }}</strong> santri.
            Total pertemuan bulan ini: <strong>{{ $totalPertemuan }}</strong> sesi.
        </div>

    <!-- Main Table -->
    @if($data->count() > 0)
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th class="text-center" style="width: 60px;">Rank</th>
                    <th>Nama Santri</th>
                    <th class="text-center" style="width: 80px;">Kelas</th>
                    <th class="text-center" style="width: 70px; color: #059669;">Hadir</th>
                    <th class="text-center" style="width: 70px; color: #d97706;">Izin</th>
                    <th class="text-center" style="width: 70px; color: #2563eb;">Sakit</th>
                    <th class="text-center" style="width: 70px; color: #dc2626;">Alpha</th>
                    <th class="text-center" style="width: 80px;">Persentase</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $d)
                <tr>
                    <td class="text-center">
                        @if($d['rank'] == 1)
                            <span class="badge badge-warning" style="font-size: 14px;">🥇 {{ $d['rank'] }}</span>
                        @elseif($d['rank'] == 2)
                            <span class="badge" style="background:#e5e7eb;color:#374151; font-size: 14px;">🥈 {{ $d['rank'] }}</span>
                        @elseif($d['rank'] == 3)
                            <span class="badge" style="background:#d97706;color:#fff; font-size: 14px;">🥉 {{ $d['rank'] }}</span>
                        @else
                            <span style="font-weight: 600; color: #64748b;">{{ $d['rank'] }}</span>
                        @endif
                    </td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 36px; height: 36px; background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 13px;">
                                {{ strtoupper(substr($d['santri']->nama, 0, 1)) }}
                            </div>
                            <div>
                                <div style="font-weight: 600; color: #1e293b;">{{ $d['santri']->nama }}</div>
                                <div style="font-size: 11px; color: #94a3b8;">{{ $d['santri']->nis ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="text-center">
                        <span class="badge" style="background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0;">
                            {{ $d['santri']->kelas ?? '-' }}
                        </span>
                    </td>
                    <td class="text-center">
                        <span class="badge badge-success" style="font-weight: 700;">{{ $d['hadir'] }}</span>
                    </td>
                    <td class="text-center">
                        <span class="badge badge-warning">{{ $d['izin'] }}</span>
                    </td>
                    <td class="text-center">
                        <span class="badge badge-info">{{ $d['sakit'] }}</span>
                    </td>
                    <td class="text-center">
                        <span class="badge badge-danger">{{ $d['alpha'] }}</span>
                    </td>
                    <td class="text-center">
                        <div style="display: flex; align-items: center; justify-content: center; gap: 6px;">
                            <div style="width: 40px; height: 6px; background: #e2e8f0; border-radius: 3px; overflow: hidden;">
                                <div style="width: {{ $d['persentase'] }}%; height: 100%; background: linear-gradient(90deg, #10b981 0%, #059669 100%); border-radius: 3px;"></div>
                            </div>
                            <span style="font-weight: 600; color: #059669; font-size: 12px;">{{ $d['persentase'] }}%</span>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-top: 20px;">
        <div style="color: var(--secondary); font-size: 13px;">
            Menampilkan {{ $data->firstItem() ?? 0 }} - {{ $data->lastItem() ?? 0 }} dari {{ $data->total() }} data
        </div>
        <div class="pagination" style="display: flex; gap: 4px; align-items: center; flex-wrap: wrap;">
            <button type="button" class="btn btn-sm btn-secondary" 
                    style="cursor: pointer; opacity: {{ $data->onFirstPage() ? '0.4' : '1' }}; pointer-events: {{ $data->onFirstPage() ? 'none' : 'auto' }};"
                    onclick="changeRekapPage({{ $data->currentPage() - 1 }})">
                <i class="fas fa-chevron-left"></i> Sebelumnya
            </button>

            @for ($i = 1; $i <= $data->lastPage(); $i++)
                <a href="javascript:void(0)" 
                   onclick="changeRekapPage({{ $i }})"
                   style="display: flex; align-items: center; justify-content: center; width: 36px; height: 36px; border-radius: 10px; font-size: 13px; font-weight: 600; text-decoration: none; border: 1px solid var(--border); color: var(--dark); background: var(--white); transition: all 0.2s; cursor: pointer; {{ $i === $data->currentPage() ? 'background: var(--primary); color: white; border-color: var(--primary);' : '' }} {{ $i !== $data->currentPage() ? 'cursor: pointer;' : '' }}"
                >{{ $i }}</a>
            @endfor

            <button type="button" class="btn btn-sm btn-secondary" 
                    style="cursor: pointer; opacity: {{ $data->hasMorePages() ? '1' : '0.4' }}; pointer-events: {{ $data->hasMorePages() ? 'auto' : 'none' }};"
                    onclick="changeRekapPage({{ $data->currentPage() + 1 }})">
                Berikutnya <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>

    <form id="rekapPaginationForm" action="{{ route('rekap.presensi') }}" method="GET">
        <input type="hidden" name="page" id="rekapPageInput">
        <input type="hidden" name="bulan" value="{{ $bulan }}">
        <input type="hidden" name="tahun" value="{{ $tahun }}">
        <input type="hidden" name="kelas" value="{{ $kelas }}">
        <input type="hidden" name="search" value="{{ $search }}">
    </form>

    <script>
        function changeRekapPage(page) {
            document.getElementById('rekapPageInput').value = page;
            document.getElementById('rekapPaginationForm').submit();
        }
    </script>
    @else
    <div class="empty-state">
        <i class="fas fa-search" style="font-size: 48px; color: #cbd5e1; margin-bottom: 16px;"></i>
        <h3>Tidak Ada Data</h3>
        <p>Tidak ada data rekap presensi untuk bulan dan filter yang dipilih.</p>
    </div>
    @endif

    <!-- Charts Section -->
    @if($data->count() > 0)
    <div class="card" style="margin-top: 24px;">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-chart-pie"></i> Grafik Kehadiran
            </h3>
        </div>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 24px; padding: 10px;">
            <div>
                <canvas id="pieChart" height="250"></canvas>
            </div>
            <div>
                <canvas id="barChart" height="250"></canvas>
            </div>
        </div>
    </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Data from PHP
    const statusLabels = ['Hadir', 'Izin', 'Sakit', 'Alpha'];
    const statusData = [{{ $totalHadir }}, {{ $totalIzin }}, {{ $totalSakit }}, {{ $totalAlpha }}];
    const statusColors = ['#10b981', '#f59e0b', '#3b82f6', '#ef4444'];

    // Pie Chart
    const pieCtx = document.getElementById('pieChart').getContext('2d');
    new Chart(pieCtx, {
        type: 'doughnut',
        data: {
            labels: statusLabels,
            datasets: [{
                data: statusData,
                backgroundColor: statusColors,
                borderWidth: 0,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 15,
                        font: { size: 12 }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.label || '';
                            let value = context.raw || 0;
                            let total = context.dataset.data.reduce((a, b) => a + b, 0);
                            let percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                            return label + ': ' + value + ' (' + percentage + '%)';
                        }
                    }
                }
            }
        }
    });

    // Bar Chart (Top 10 by attendance)
    const topSantri = @json($topData->map(function($item) {
        return [
            'nama' => $item['santri']->nama,
            'hadir' => $item['hadir']
        ];
    })->toArray());

    const barCtx = document.getElementById('barChart').getContext('2d');
    new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: topSantri.map(s => s.nama.length > 15 ? s.nama.substring(0, 15) + '...' : s.nama),
            datasets: [{
                label: 'Jumlah Hadir',
                data: topSantri.map(s => s.hadir),
                backgroundColor: '#1e40af',
                borderRadius: 6,
                hoverBackgroundColor: '#3b82f6'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        title: function(context) {
                            return topSantri[context[0].dataIndex].nama;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });
});
</script>

@endsection