<?php $__env->startSection('title', 'Dashboard Santri'); ?>

<?php $__env->startPush('styles'); ?>
<style>
.dashboard-header {
    border-radius: 16px;
    padding: 1.75rem 2rem;
    margin-bottom: 1.25rem;
    background: linear-gradient(135deg, #059669 0%, #0d9488 50%, #0f766e 100%);
    color: white;
    position: relative;
    overflow: hidden;
}

.dashboard-header h1 {
    font-size: 1.6rem;
    font-weight: 700;
    margin-bottom: 0.35rem;
    color: white;
}

.dashboard-header p {
    font-size: 0.9rem;
    opacity: 0.9;
    margin-bottom: 1rem;
}

.dashboard-header .d-flex {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
}

.countdown-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    background: rgba(255,255,255,0.15);
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.85rem;
}

.section-label {
    font-size: 0.9rem;
    font-weight: 600;
    color: #334155;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.section-card {
    background: white;
    border-radius: 16px;
    padding: 1.25rem 1.5rem;
    border: 1px solid #e2e8f0;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    margin-bottom: 1.25rem;
}

.section-card h5 {
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 1rem;
    color: #1e293b;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.section-divider {
    border: none;
    border-top: 1px solid #e2e8f0;
    margin: 1.5rem 0;
}

/* Stat Summary Cards */
.stat-summary-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-bottom: 1rem;
}

.stat-summary-item {
    background: #f8fafc;
    border-radius: 12px;
    padding: 1rem;
    text-align: center;
    border: 1px solid #e2e8f0;
    transition: all 0.25s ease;
}

.stat-summary-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.06);
}

.stat-summary-item .icon {
    font-size: 1.5rem;
    margin-bottom: 0.5rem;
}

.stat-summary-item.hadir .icon { color: #059669; }
.stat-summary-item.alpha .icon { color: #ef4444; }
.stat-summary-item.izin .icon { color: #f59e0b; }
.stat-summary-item.sakit .icon { color: #0891b2; }
.stat-summary-item.denda .icon { color: #d97706; }
.stat-summary-item.persentase .icon { color: #0d9488; }

.stat-summary-item .number {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0.25rem 0;
}

.stat-summary-item .label {
    font-size: 0.75rem;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Status Badge */
.badge-status {
    display: inline-flex;
    align-items: center;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 500;
}

.badge-status.hadir { background: #d1fae5; color: #065f46; }
.badge-status.alpha { background: #fee2e2; color: #991b1b; }
.badge-status.izin { background: #fef3c7; color: #92400e; }
.badge-status.sakit { background: #dbeafe; color: #1e40af; }

/* Info Box */
.info-box {
    background: #f8fafc;
    border-radius: 12px;
    padding: 1rem;
    text-align: center;
    border: 1px solid #e2e8f0;
}

.info-box i {
    font-size: 1.5rem;
    color: #0d9488;
    margin-bottom: 0.5rem;
}

.info-box h4 {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0.25rem 0;
}

.info-box p {
    font-size: 0.75rem;
    color: #64748b;
    margin: 0;
}

/* Schedule Tabs */
.schedule-tabs {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 0.75rem;
    align-items: center;
    flex-wrap: wrap;
}

.schedule-tab-btn {
    background: rgba(255,255,255,0.15);
    border: none;
    border-radius: 16px;
    padding: 0.4rem 1rem;
    font-size: 0.75rem;
    color: white;
    cursor: pointer;
}

.schedule-tab-btn.active {
    background: white;
    color: #0d9488;
    font-weight: 600;
}

.schedule-tab-btn.safin { background: rgba(255,255,255,0.2); }
.schedule-tab-btn.muqo { background: rgba(255,255,255,0.15); }

.badge-tab {
    background: rgba(255,255,255,0.15);
    color: white;
    font-size: 0.7rem;
    padding: 0.2rem 0.6rem;
    border-radius: 12px;
    margin-left: auto;
}

.timeline-axis-wrapper {
    position: relative;
    height: 40px;
    margin-bottom: 1rem;
    overflow: hidden;
}

.timeline-axis {
    position: relative;
    height: 100%;
    border-top: 1px dashed rgba(255,255,255,0.3);
}

.timeline-ruler-line {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 1px;
    background: rgba(255,255,255,0.3);
}

.timeline-hour-mark {
    position: absolute;
    top: -8px;
    transform: translateX(-50%);
    text-align: center;
}

.timeline-hour-mark .tl-dot {
    width: 8px;
    height: 8px;
    background: rgba(255,255,255,0.5);
    border-radius: 50%;
    margin: 0 auto 4px;
}

.timeline-hour-mark small {
    font-size: 0.65rem;
    color: rgba(255,255,255,0.7);
}

.timeline-hour-mark.tl-active .tl-dot {
    background: #fbbf24;
    box-shadow: 0 0 0 2px rgba(251,191,36,0.3);
}

.timeline-now-indicator {
    position: absolute;
    top: -6px;
    transform: translateX(-50%);
    text-align: center;
    z-index: 10;
}

.timeline-now-line {
    width: 2px;
    height: 16px;
    background: #fbbf24;
    margin: 0 auto 4px;
    border-radius: 2px;
}

.schedule-card-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1rem;
}

.schedule-card-item {
    background: white;
    border-radius: 12px;
    padding: 1rem;
    border: 1px solid #e2e8f0;
}

.schedule-card-item.active {
    border-color: #10b981;
    background: #f0fdf4;
}

.schedule-card-item .schedule-time {
    font-size: 0.75rem;
    color: #64748b;
    margin-bottom: 0.25rem;
}

.schedule-card-item .schedule-name {
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 0.25rem;
}

.schedule-card-item .schedule-ustadz {
    font-size: 0.8rem;
    color: #0d9488;
}

/* Activity List */
.activity-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.activity-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem;
    background: #f8fafc;
    border-radius: 10px;
}

.activity-item .activity-icon {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.9rem;
}

.activity-item .activity-icon.hadir { background: #d1fae5; color: #059669; }
.activity-item .activity-icon.alpha { background: #fee2e2; color: #ef4444; }
.activity-item .activity-icon.izin { background: #fef3c7; color: #f59e0b; }
.activity-item .activity-icon.sakit { background: #dbeafe; color: #0891b2; }

/* Empty State */
.empty-state {
    text-align: center;
    padding: 2rem 1rem;
}

.empty-state .empty-icon {
    font-size: 3rem;
    color: #cbd5e1;
    margin-bottom: 0.75rem;
}

.empty-state .empty-text {
    color: #64748b;
    font-size: 0.9rem;
}

/* Chart Container */
.chart-container {
    position: relative;
    height: 260px;
}

/* Responsive */
@media (max-width: 768px) {
    .stat-summary-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    .schedule-card-grid {
        grid-template-columns: 1fr;
    }
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <!-- Welcome Header -->
    <div class="dashboard-header">
        <h1>Selamat Datang, <?php echo e(auth()->user()->nama ?? auth()->user()->name); ?></h1>
        <p>Semoga hari ini menjadi hari yang produktik untuk belajar dan beribadah.</p>
        <div class="d-flex">
            <div style="display:flex; align-items:center; gap:0.5rem; color:rgba(255,255,255,0.9);">
                <i class="fas fa-calendar-alt"></i> <?php echo e(\Carbon\Carbon::now()->locale('id')->dayName); ?>, <?php echo e(\Carbon\Carbon::now()->format('d F Y')); ?>

            </div>
            <div class="countdown-badge">
                <i class="fas fa-clock"></i> <span id="time-display"><?php echo e($now->format('H:i:s')); ?></span>
            </div>
        </div>
    </div>

    <!-- Ringkasan Statistik -->
    <div class="section-label"><i class="fas fa-tachometer-alt"></i> Ringkasan Statistik Saya</div>
    
    <div class="stat-summary-grid">
        <div class="stat-summary-item hadir">
            <div class="icon"><i class="fas fa-check-circle"></i></div>
            <div class="number"><?php echo e($totalHadir); ?></div>
            <div class="label">Total Hadir</div>
        </div>
        <div class="stat-summary-item alpha">
            <div class="icon"><i class="fas fa-user-times"></i></div>
            <div class="number"><?php echo e($totalAlpha); ?></div>
            <div class="label">Total Alpha</div>
        </div>
        <div class="stat-summary-item izin">
            <div class="icon"><i class="fas fa-clipboard-check"></i></div>
            <div class="number"><?php echo e($totalIzin); ?></div>
            <div class="label">Total Izin</div>
        </div>
        <div class="stat-summary-item sakit">
            <div class="icon"><i class="fas fa-notes-medical"></i></div>
            <div class="number"><?php echo e($totalSakit); ?></div>
            <div class="label">Total Sakit</div>
        </div>
        <div class="stat-summary-item denda">
            <div class="icon"><i class="fas fa-money-bill-wave"></i></div>
            <div class="number">Rp <?php echo e(number_format($totalDendaKeseluruhan, 0, ',', '.')); ?></div>
            <div class="label">Total Denda</div>
        </div>
        <div class="stat-summary-item persentase">
            <div class="icon"><i class="fas fa-percentage"></i></div>
            <div class="number"><?php echo e($persentaseKehadiran); ?>%</div>
            <div class="label">Persentase Kehadiran</div>
        </div>
    </div>

    <!-- Status Kehadiran Terbaru -->
    <div class="section-card" style="margin-bottom: 1.25rem;">
        <h5><i class="fas fa-bell"></i> Status Kehadiran Terbaru</h5>
        <?php if($todayAttendance): ?>
            <div class="d-flex align-items-center gap-3">
                <span class="badge-status <?php echo e($todayAttendance->status); ?>">
                    <i class="fas fa-circle me-1" style="font-size:0.5rem;"></i>
                    <?php echo e($todayAttendance->nama_status); ?>

                </span>
                <span style="font-size:0.85rem; color:#64748b;">
                    Hari ini, <?php echo e(\Carbon\Carbon::parse($todayAttendance->tanggal)->format('d M Y')); ?>

                </span>
                <?php if($todayAttendance->denda > 0): ?>
                    <span class="text-danger" style="font-size:0.85rem;">
                        <i class="fas fa-exclamation-triangle"></i> Denda: Rp <?php echo e(number_format($todayAttendance->denda, 0, ',', '.')); ?>

                    </span>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <div class="empty-icon"><i class="fas fa-calendar-check"></i></div>
                <p class="empty-text">Belum ada data kehadiran hari ini</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Ranking Card -->
    <div class="section-card" style="margin-bottom: 1.25rem;">
        <h5><i class="fas fa-trophy"></i> Posisi Ranking Kehadiran</h5>
        <div class="d-flex align-items-center gap-3">
            <div style="width:60px; height:60px; background:linear-gradient(135deg, #059669, #0d9488); border-radius:50%; display:flex; align-items:center; justify-content:center; color:white; font-size:1.5rem; font-weight:700;">
                <?php echo e($santriRanking['position'] ?? '-'); ?>

            </div>
            <div>
                <div style="font-weight:600; color:#1e293b; font-size:1rem;">Posisi Anda</div>
                <div style="font-size:0.85rem; color:#64748b;">
                    <?php echo e($santriRanking['total_hadir'] ?? 0); ?> kehadiran • <?php echo e($santriRanking['persentase'] ?? 0); ?>% persentase
                </div>
            </div>
        </div>
    </div>

    <hr class="section-divider">

    <!-- Rekap Bulan Ini -->
    <div class="section-label"><i class="fas fa-calendar-alt"></i> Rekap Kehadiran Bulan Ini</div>

    <div class="stat-summary-grid">
        <div class="stat-summary-item hadir">
            <div class="icon"><i class="fas fa-calendar-check"></i></div>
            <div class="number"><?php echo e($totalHadirBulan); ?></div>
            <div class="label">Hadir</div>
        </div>
        <div class="stat-summary-item alpha">
            <div class="icon"><i class="fas fa-times-circle"></i></div>
            <div class="number"><?php echo e($totalAlphaBulan); ?></div>
            <div class="label">Alpha</div>
        </div>
        <div class="stat-summary-item izin">
            <div class="icon"><i class="fas fa-clipboard-check"></i></div>
            <div class="number"><?php echo e($totalIzinBulan); ?></div>
            <div class="label">Izin</div>
        </div>
        <div class="stat-summary-item sakit">
            <div class="icon"><i class="fas fa-notes-medical"></i></div>
            <div class="number"><?php echo e($totalSakitBulan); ?></div>
            <div class="label">Sakit</div>
        </div>
    </div>

    <!-- Distribusi Kehadiran -->
    <div class="section-card">
        <h5><i class="fas fa-chart-pie"></i> Distribusi Kehadiran Bulan Ini</h5>
        <div class="chart-container">
            <div id="statusChart"></div>
        </div>
    </div>

    <hr class="section-divider">

    <!-- Aktivitas Terkini -->
    <div class="section-label"><i class="fas fa-history"></i> Aktivitas Kehadiran Terbaru</div>
    
    <div class="section-card">
        <?php if($recentActivities->isEmpty()): ?>
            <div class="empty-state">
                <div class="empty-icon"><i class="fas fa-calendar-day"></i></div>
                <p class="empty-text">Belum ada aktivitas kehadiran</p>
            </div>
        <?php else: ?>
            <div class="activity-list">
                <?php $__currentLoopData = $recentActivities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="activity-item">
                        <div class="activity-icon <?php echo e($activity['status']); ?>">
                            <i class="fas fa-circle"></i>
                        </div>
                        <div>
                            <div style="font-weight:500; color:#1e293b;">
                                <?php echo e($activity['nama_status']); ?>

                            </div>
                            <div style="font-size:0.8rem; color:#64748b;">
                                <?php echo e(\Carbon\Carbon::parse($activity['tanggal'])->format('d M Y')); ?>

                                <?php if($activity['denda'] > 0): ?>
                                    • Denda: Rp <?php echo e(number_format($activity['denda'], 0, ',', '.')); ?>

                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
setInterval(function() {
    var now = new Date();
    document.getElementById('time-display').textContent = now.toLocaleTimeString('id-ID');
}, 1000);

var statusOptions = {
    series: [<?php echo json_encode($totalHadirBulan ?? 0); ?>, <?php echo json_encode($totalAlphaBulan ?? 0); ?>, <?php echo json_encode($totalIzinBulan ?? 0); ?>, <?php echo json_encode($totalSakitBulan ?? 0); ?>],
    chart: { type: 'donut', height: 260 },
    labels: ['Hadir', 'Alpha', 'Izin', 'Sakit'],
    colors: ['#059669', '#ef4444', '#f59e0b', '#0891b2'],
    legend: { position: 'bottom', horizontalAlign: 'center', fontSize: '11px', fontFamily: 'Poppins', markers: { width: 10, height: 10 } },
    plotOptions: { pie: { donut: { size: '55%' } } },
    dataLabels: { enabled: true, style: { fontSize: '12px', fontFamily: 'Poppins' } }
};
new ApexCharts(document.querySelector("#statusChart"), statusOptions).render();
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PROJEK BOSS\sistem-presensi\sistem-presensi\resources\views\santri\dashboard.blade.php ENDPATH**/ ?>