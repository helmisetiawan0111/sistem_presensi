<?php $__env->startSection('title', 'Statistik Kehadiran Saya'); ?>

<?php $__env->startPush('styles'); ?>
<style>
.chart-section {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    border: 1px solid #e2e8f0;
    margin-bottom: 1.5rem;
}

.chart-section h5 {
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 1rem;
    color: #1e293b;
}

.chart-container {
    position: relative;
    height: 300px;
}

.stat-summary {
    background: #f8fafc;
    border-radius: 12px;
    padding: 1rem;
    margin-top: 1rem;
}

.stat-summary h6 {
    font-size: 0.9rem;
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 0.75rem;
}

.stat-summary .progress-item {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.5rem;
    font-size: 0.85rem;
}

.stat-summary .progress-bar {
    height: 8px;
    background: #e2e8f0;
    border-radius: 4px;
    overflow: hidden;
    margin-top: 0.25rem;
}

.stat-summary .progress-fill {
    height: 100%;
    border-radius: 4px;
    transition: width 0.5s ease;
}

.empty-state {
    text-align: center;
    padding: 3rem 1rem;
}

.empty-state .empty-icon {
    font-size: 3rem;
    color: #cbd5e1;
    margin-bottom: 0.75rem;
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row g-4 mb-4">
        <div class="col-md-7">
            <div class="chart-section">
                <h5><i class="fas fa-chart-line"></i> Grafik Kehadiran per Bulan (<?php echo e(\Carbon\Carbon::now()->year); ?>)</h5>
                <div class="chart-container">
                    <div id="attendanceChart"></div>
                </div>
            </div>
        </div>
        
        <div class="col-md-5">
            <div class="chart-section">
                <h5><i class="fas fa-chart-pie"></i> Distribusi Kehadiran Bulan Ini</h5>
                <div class="chart-container">
                    <div id="statusChart"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Ringkas -->
    <div class="chart-section">
        <h5><i class="fas fa-info-circle"></i> Persentase Kehadiran Tahun Ini</h5>
        <div class="stat-summary">
            <div class="progress-item">
                <span style="color:#059669;"><i class="fas fa-check-circle"></i> Hadir</span>
                <span style="font-weight:600;"><?php echo e($persentaseKehadiranTahun); ?>%</span>
            </div>
            <div class="progress-bar">
                <div class="progress-fill" style="width:<?php echo e($persentaseKehadiranTahun); ?>%; background:#059669;"></div>
            </div>
            <small style="font-size:0.75rem; color:#64748b;">
                Total hadir <?php echo e(array_sum($dataHadir)); ?> hari dari <?php echo e(12*30); ?> hari kerja
            </small>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var attendanceOptions = {
        series: [
            { name: 'Hadir', data: <?php echo json_encode($dataHadir); ?> },
            { name: 'Alpha', data: <?php echo json_encode($dataAlpha); ?> },
            { name: 'Izin',  data: <?php echo json_encode($dataIzin); ?> },
            { name: 'Sakit', data: <?php echo json_encode($dataSakit); ?> }
        ],
        chart: { 
            type: 'area', 
            height: 300, 
            toolbar: { show: false }, 
            zoom: { enabled: false },
            fontFamily: 'Poppins'
        },
        colors: ['#059669', '#ef4444', '#f59e0b', '#0891b2'],
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth', width: 2 },
        fill: { 
            type: 'gradient', 
            gradient: { 
                shadeIntensity: 1, 
                opacityFrom: 0.2, 
                opacityTo: 0.02 
            } 
        },
        markers: { size: 0, hover: { size: 4 } },
        xaxis: {
            categories: <?php echo json_encode($labels); ?>,
            labels: { style: { fontSize: '11px', colors: '#94a3b8', fontFamily: 'Poppins' } }
        },
        yaxis: { 
            labels: { style: { fontSize: '11px', colors: '#94a3b8', fontFamily: 'Poppins' } },
            min: 0
        },
        grid: { show: true, borderColor: '#f1f5f9', strokeDashArray: 3 },
        tooltip: { theme: 'light', fontFamily: 'Poppins' },
        legend: { 
            position: 'top', 
            horizontalAlign: 'left', 
            fontSize: '12px', 
            fontFamily: 'Poppins', 
            markers: { width: 12, height: 12 } 
        }
    };
    new ApexCharts(document.querySelector("#attendanceChart"), attendanceOptions).render();

    var statusOptions = {
        series: <?php echo json_encode($statusData); ?>,
        chart: { type: 'donut', height: 280, fontFamily: 'Poppins' },
        labels: <?php echo json_encode($statusLabels); ?>,
        colors: ['#059669', '#ef4444', '#f59e0b', '#0891b2'],
        legend: { 
            position: 'bottom', 
            horizontalAlign: 'center', 
            fontSize: '12px', 
            fontFamily: 'Poppins', 
            markers: { width: 12, height: 12 } 
        },
        plotOptions: { pie: { donut: { size: '55%' } } },
        dataLabels: { 
            enabled: true, 
            style: { fontSize: '12px', fontFamily: 'Poppins' } 
        }
    };
    new ApexCharts(document.querySelector("#statusChart"), statusOptions).render();
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PROJEK BOSS\sistem-presensi\sistem-presensi\resources\views/santri/statistics.blade.php ENDPATH**/ ?>