@extends('layouts.app')

@section('title', 'Statistik')

@section('content')
<div class="card">
    <!-- Header -->
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-chart-bar"></i> Statistik Kehadiran
        </h3>
        <div style="font-size: 13px; color: #64748b;">
            <i class="fas fa-calendar-alt"></i> {{ \Carbon\Carbon::createFromDate($tahun, $bulan, 1)->locale('id')->monthName }} {{ $tahun }}
        </div>
    </div>

    <!-- Filter -->
    <div style="background: #f8fafc; padding: 20px; border-radius: 12px; margin-bottom: 24px; border: 1px solid #e2e8f0;">
        <form action="{{ route('statistik.index') }}" method="GET" style="display: flex; gap: 12px; align-items: flex-end; flex-wrap: wrap;">
            <div style="min-width: 180px;">
                <label class="form-label">Bulan</label>
                <select name="bulan" class="form-select">
                    @foreach($bulanList as $key => $name)
                    <option value="{{ $key }}" {{ $bulan == $key ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
            </div>
            <div style="min-width: 140px;">
                <label class="form-label">Tahun</label>
                <select name="tahun" class="form-select">
                    @foreach($tahunList as $t)
                    <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>{{ $t }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-filter"></i> Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Stat Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon blue"><i class="fas fa-clipboard-check"></i></div>
            <div class="stat-content"><h3>{{ array_sum($statusCounts) }}</h3><p>Total Absensi</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green"><i class="fas fa-check-circle"></i></div>
            <div class="stat-content"><h3>{{ $statusCounts['hadir'] }}</h3><p>Hadir</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon red"><i class="fas fa-times-circle"></i></div>
            <div class="stat-content"><h3>{{ $statusCounts['izin'] + $statusCounts['sakit'] + $statusCounts['alpha'] }}</h3><p>Tidak Hadir</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon yellow"><i class="fas fa-money-bill-wave"></i></div>
            <div class="stat-content"><h3>Rp {{ number_format($totalDenda, 0, ',', '.') }}</h3><p>Total Denda</p></div>
        </div>
    </div>

    <!-- Charts -->
    <div style="display: grid; grid-template-columns: 1fr; gap: 24px; margin-top: 24px;">
        <!-- Pie Chart (Distribusi Kehadiran) -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-chart-pie"></i> Distribusi Kehadiran</h3>
            </div>
            <div style="position: relative; height: 340px; display: flex; align-items: center; justify-content: center;">
                <canvas id="pieChart"></canvas>
            </div>
        </div>

        <!-- Bar Chart (Kehadiran Harian - Full Tanggal) -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-chart-bar"></i> Kehadiran Harian (1 - {{ \Carbon\Carbon::createFromDate($tahun, $bulan, 1)->daysInMonth }} {{ \Carbon\Carbon::createFromDate($tahun, $bulan, 1)->locale('id')->monthName }})</h3>
            </div>
            <div style="position: relative; height: 420px; padding: 10px 0;">
                <canvas id="barChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ========== PIE CHART ==========
    const pieCtx = document.getElementById('pieChart').getContext('2d');
    const totalAbsen = {{ $statusCounts['hadir'] }} + {{ $statusCounts['izin'] }} + {{ $statusCounts['sakit'] }} + {{ $statusCounts['alpha'] }};

    new Chart(pieCtx, {
        type: 'doughnut',
        data: {
            labels: ['Hadir', 'Izin', 'Sakit', 'Alpha'],
            datasets: [{
                data: [{{ $statusCounts['hadir'] }}, {{ $statusCounts['izin'] }}, {{ $statusCounts['sakit'] }}, {{ $statusCounts['alpha'] }}],
                backgroundColor: ['#10b981', '#f59e0b', '#3b82f6', '#ef4444'],
                borderWidth: 2,
                borderColor: '#ffffff',
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '60%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 16,
                        font: { size: 12 },
                        usePointStyle: true,
                        boxWidth: 10
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0,0,0,0.8)',
                    titleFont: { size: 13 },
                    bodyFont: { size: 12 },
                    padding: 12,
                    callbacks: {
                        label: function(ctx) {
                            let val = ctx.raw || 0;
                            let pct = totalAbsen > 0 ? ((val / totalAbsen) * 100).toFixed(1) : 0;
                            return ctx.label + ': ' + val + ' (' + pct + '%)';
                        }
                    }
                }
            }
        }
    });

    // ========== BAR CHART (Stacked - Clear & Readable) ==========
    const barCtx = document.getElementById('barChart').getContext('2d');
    const labels = {!! json_encode(array_column($dailyData, 'tanggal')) !!};
    const hadir = {!! json_encode(array_column($dailyData, 'hadir')) !!};
    const izin = {!! json_encode(array_column($dailyData, 'izin')) !!};
    const sakit = {!! json_encode(array_column($dailyData, 'sakit')) !!};
    const alpha = {!! json_encode(array_column($dailyData, 'alpha')) !!};

    new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                { 
                    label: 'Hadir', 
                    data: hadir, 
                    backgroundColor: '#10b981',
                    borderColor: '#059669',
                    borderWidth: 1,
                    borderRadius: 3
                },
                { 
                    label: 'Izin', 
                    data: izin, 
                    backgroundColor: '#f59e0b',
                    borderColor: '#d97706',
                    borderWidth: 1,
                    borderRadius: 3
                },
                { 
                    label: 'Sakit', 
                    data: sakit, 
                    backgroundColor: '#3b82f6',
                    borderColor: '#2563eb',
                    borderWidth: 1,
                    borderRadius: 3
                },
                { 
                    label: 'Alpha', 
                    data: alpha, 
                    backgroundColor: '#ef4444',
                    borderColor: '#dc2626',
                    borderWidth: 1,
                    borderRadius: 3
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false
            },
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 16,
                        font: { size: 12 },
                        usePointStyle: true,
                        boxWidth: 12
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(31, 41, 55, 0.95)',
                    titleFont: { size: 13, weight: 'bold' },
                    bodyFont: { size: 12 },
                    padding: 14,
                    cornerRadius: 8,
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + context.raw + ' orang';
                        }
                    }
                }
            },
            scales: {
                x: {
                    stacked: false,
                    grid: { display: false },
                    ticks: {
                        font: { size: 11 },
                        maxRotation: 70,
                        minRotation: 60,
                        autoSkip: false
                    }
                },
                y: {
                    stacked: false,
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        font: { size: 11 }
                    },
                    grid: { color: '#e5e7eb' }
                }
            }
        }
    });
});
</script>
@endsection
