<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .welcome-sm {
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        border-radius: 14px;
        padding: 1.25rem 1.5rem;
        margin-bottom: 1.25rem;
        color: white;
        position: relative;
        overflow: hidden;
    }
    .welcome-sm::before {
        content: '';
        position: absolute;
        top: -40px;
        right: -40px;
        width: 120px;
        height: 120px;
        background: rgba(255,255,255,0.08);
        border-radius: 50%;
    }
    .welcome-sm h4 { font-size: 1.05rem; font-weight: 600; margin-bottom: 2px; }
    .welcome-sm p  { font-size: 0.8rem; opacity: 0.8; margin: 0; }

    /* Animasi Fade-In (Item 1 & 3) */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .animate-in {
        animation: fadeInUp 0.5s ease forwards;
        opacity: 0;
    }
    .animate-in:nth-child(1) { animation-delay: 0.05s; }
    .animate-in:nth-child(2) { animation-delay: 0.1s; }
    .animate-in:nth-child(3) { animation-delay: 0.15s; }
    .animate-in-row {
        animation: fadeInUp 0.6s ease forwards;
        opacity: 0;
    }
    .animate-in-row:nth-child(1) { animation-delay: 0.25s; }
    .animate-in-row:nth-child(2) { animation-delay: 0.3s; }

    /* Efek Glow Hover (Item 6 & 7) */
    .stat-card-sm {
        background: var(--white);
        border-radius: 12px;
        border: 1px solid var(--border);
        padding: 12px 14px;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: all 0.2s ease;
        position: relative;
        overflow: hidden;
    }
    .stat-card-sm::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        border-radius: 4px 0 0 4px;
    }
    .stat-card-sm::after {
        content: '';
        position: absolute;
        top: 0; left: -100%;
        width: 100%; height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        transition: left 0.6s ease;
        pointer-events: none;
    }
    .stat-card-sm:hover::after {
        left: 100%;
    }
    .stat-card-sm:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 14px rgba(0,0,0,0.1);
    }
    .stat-icon-sm {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
    }
    .stat-icon-sm.blue  { background: #dbeafe; color: #1e3a8a; }
    .stat-icon-sm.green { background: #d1fae5; color: #15803d; }
    .stat-icon-sm.purple { background: #ede9fe; color: #7c3aed; }
    .stat-card-sm.blue::before  { background: #1e3a8a; }
    .stat-card-sm.green::before { background: #15803d; }
    .stat-card-sm.purple::before { background: #7c3aed; }
    .stat-info-sm h4 { font-size: 1.05rem; font-weight: 700; color: var(--dark); margin-bottom: 1px; }
    .stat-info-sm p { font-size: 0.75rem; color: var(--gray); margin: 0; }

    .mini-card {
        background: var(--white);
        border-radius: 12px;
        border: 1px solid var(--border);
        padding: 1rem 1.15rem;
    }
    .mini-card h6 {
        font-size: 0.82rem;
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 0.65rem;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .activity-item-sm {
        padding: 0.45rem 0.55rem;
        border-radius: 8px;
        border-left: 3px solid transparent;
        transition: all 0.15s ease;
        margin-bottom: 0.3rem;
    }
    .activity-item-sm:hover { background: var(--secondary-gray); border-left-color: var(--primary); }

    .ranking-row {
        display: flex;
        align-items: center;
        padding: 0.5rem 0.6rem;
        border-radius: 6px;
        margin-bottom: 0.25rem;
        transition: background 0.15s;
    }
    .ranking-row:hover { background: var(--secondary-gray); }
    .rank-badge-sm {
        width: 24px;
        height: 24px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.65rem;
        font-weight: 700;
        flex-shrink: 0;
        color: white;
    }
    .rank-1 { background: #fbbf24; }
    .rank-2 { background: #9ca3af; }
    .rank-3 { background: #b45309; }

    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.4rem 0.6rem;
        border-radius: 6px;
        margin-bottom: 0.25rem;
        transition: background 0.15s;
    }
    .info-row:hover { background: var(--secondary-gray); }

    .chart-mini { height: 180px !important; }

    .badge-xs {
        font-size: 0.65rem;
        padding: 0.15rem 0.45rem;
        border-radius: 8px;
    }

    /* Custom scrollbar */
    .activity-timeline::-webkit-scrollbar { width: 4px; }
    .activity-timeline::-webkit-scrollbar-track { background: transparent; }
    .activity-timeline::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
    .activity-timeline::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

    /* Ring Progress SVG */
    .ring-progress {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        pointer-events: none;
    }

    /* Mini card shadow enhancement */
    .mini-card { box-shadow: 0 1px 3px rgba(0,0,0,0.04); }
    .mini-card:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.06); }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
<?php if(auth()->guard()->check()): ?>
<?php if(auth()->user()->role === 'santri'): ?>

<!-- Welcome Banner (Item 6: Badge Notifikasi) -->
<div class="welcome-sm">
    <h4>👋 Selamat Datang, <?php echo e(Auth::user()->name); ?></h4>
    <p><?php echo e(\Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y')); ?></p>
    <?php if($totalAlphaHariIni > 0): ?>
    <span class="badge bg-danger border border-2 border-white" style="position:absolute; top:12px; left:16px; font-size:10px; padding:3px 8px;">
        <i class="fas fa-exclamation-circle me-1"></i> <?php echo e($totalAlphaHariIni); ?> Alpha
    </span>
    <?php endif; ?>
</div>

<!-- Statistik Utama - Horizontal Compact (Item 1 & 3: Animasi + Ring Progress) -->
<div class="row g-2 mb-3">
    <div class="col-4 animate-in">
        <div class="stat-card-sm blue">
            <div class="stat-icon-sm blue"><i class="fas fa-calendar-check"></i></div>
            <div class="stat-info-sm">
                <h4 id="myHadirCount">0</h4>
                <p>Hadir</p>
            </div>
        </div>
    </div>
    <div class="col-4 animate-in" style="position:relative;">
        <svg class="ring-progress" width="46" height="46" viewBox="0 0 46 46">
            <circle cx="23" cy="23" r="18" fill="none" stroke="#d1fae5" stroke-width="4"/>
            <circle cx="23" cy="23" r="18" fill="none" stroke="#15803d" stroke-width="4"
                    stroke-dasharray="113.10"
                    id="ringKehadiran"
                    stroke-linecap="round"
                    transform="rotate(-90 23 23)"
                    style="transition: stroke-dashoffset 1s ease;"/>
        </svg>
        <div class="stat-icon-sm green" style="position:relative; z-index:1;"><i class="fas fa-percentage"></i></div>
        <div class="stat-info-sm" style="position:relative; z-index:1;">
            <h4 id="myHadirPercentage">0%</h4>
            <p>Kehadiran</p>
        </div>
    </div>
    <div class="col-4 animate-in">
        <div class="stat-card-sm purple">
            <div class="stat-icon-sm purple"><i class="fas fa-trophy"></i></div>
            <div class="stat-info-sm">
                <h4 id="myRanking">-</h4>
                <p>Ranking</p>
            </div>
        </div>
    </div>
</div>

<!-- Item 6: Card Peringatan (kondisional) -->
<?php if($totalAlphaHariIni > 0 || ($totalDendaBulan ?? 0) > 50000): ?>
<div class="row g-2 mb-3 animate-in-row" style="animation-delay:0.25s;">
    <div class="col-12">
        <div class="mini-card" style="border-left:3px solid #ef4444;">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="mb-0"><i class="fas fa-exclamation-triangle text-warning"></i> Peringatan</h6>
                <span class="badge bg-danger text-white">Perlu Perhatian</span>
            </div>
            <div class="row g-2">
                <?php if($totalAlphaHariIni > 0): ?>
                <div class="col-6 col-md-3">
                    <div class="alert alert-warning py-2 px-3 mb-0" style="font-size:0.8rem; border-radius:10px;">
                        <strong><i class="fas fa-user-times me-1"></i><?php echo e($totalAlphaHariIni); ?> Alpha</strong> terdeteksi hari ini!
                    </div>
                </div>
                <?php endif; ?>
                <?php if(($totalDendaBulan ?? 0) > 50000): ?>
                <div class="col-6 col-md-3">
                    <div class="alert alert-danger py-2 px-3 mb-0" style="font-size:0.8rem; border-radius:10px;">
                        <strong><i class="fas fa-money-bill-wave me-1"></i>Rp <?php echo e(number_format($totalDendaBulan ?? 0, 0, ',', '.')); ?></strong> denda bulan ini — Perlu tindakan!
                    </div>
                </div>
                <?php endif; ?>
                <?php if($totalAlphaHariIni == 0 && ($totalDendaBulan ?? 0) <= 50000): ?>
                <div class="col-12">
                    <p class="text-muted mb-0" style="font-size:0.85rem;">✅ Tidak ada pelanggaran signifikan hari ini.</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Chart + Info Cepat Row -->
<div class="row g-2 mb-3 animate-in-row" style="animation-delay:0.3s;">
    <div class="col-lg-8">
        <div class="mini-card h-100">
            <h6><i class="fas fa-chart-line text-primary"></i> Kehadiran Minggu Ini</h6>
            <div id="weeklyChart"></div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="mini-card h-100 d-flex flex-column">
            <h6><i class="fas fa-crown text-warning"></i> Top 5 Kehadiran</h6>
            <div id="rankingList" style="flex:1;">
                <?php $__currentLoopData = $rankingTerbaik ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $santri): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="ranking-row">
                    <div class="rank-badge-sm rank-<?php echo e($index < 3 ? $index + 1 : ''); ?> me-2">
                        <?php if($index === 0): ?> <i class="fas fa-crown" style="font-size:9px;"></i>
                        <?php elseif($index === 1): ?> <i class="fas fa-medal" style="font-size:9px;"></i>
                        <?php elseif($index === 2): ?> <i class="fas fa-award" style="font-size:9px;"></i>
                        <?php else: ?> <?php echo e($index + 1); ?> <?php endif; ?>
                    </div>
                    <div class="flex-grow-1">
                        <small class="fw-medium text-dark"><?php echo e($santri->nama ?? $santri->name); ?></small>
                        <div class="progress-mini mt-1">
                            <div class="progress-bar bg-success" style="width:<?php echo e(max(($santri->hadir_count ?? 0) / max(1, ($rankingTerbaik->first()->hadir_count ?? 1)) * 100, 5)); ?>%; height:100%; border-radius:2px;"></div>
                        </div>
                    </div>
                    <small class="text-muted ms-2"><?php echo e($santri->hadir_count ?? 0); ?>x</small>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
</div>

<!-- Aktivitas + Info Cepat Row -->
<div class="row g-2 mb-3 animate-in-row" style="animation-delay:0.35s;">
    <div class="col-lg-7">
        <div class="mini-card h-100 d-flex flex-column">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="mb-0"><i class="fas fa-bolt text-primary"></i> Aktivitas Terbaru</h6>
                <div class="btn-group btn-group-sm">
                    <a href="?periode=hari_ini" class="btn btn-outline-primary <?php echo e((!request('periode') || request('periode') === 'hari_ini') ? 'active' : ''); ?>">Hari Ini</a>
                    <a href="?periode=kemarin" class="btn btn-outline-primary <?php echo e(request('periode') === 'kemarin' ? 'active' : ''); ?>">Kemarin</a>
                    <a href="?periode=7_hari" class="btn btn-outline-primary <?php echo e(request('periode') === '7_hari' ? 'active' : ''); ?>">7 Hari</a>
                </div>
            </div>
            <div class="activity-timeline" style="flex:1; overflow-y:auto; max-height:280px;">
                <?php $__empty_1 = true; $__currentLoopData = $recentActivities ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="activity-item-sm d-flex align-items-center px-2 py-2">
                    <div class="me-2" style="width:32px; height:32px; border-radius:8px; display:flex; align-items:center; justify-content:center; flex-shrink:0;
                        <?php if($activity['type'] === 'hadir'): ?> bg-success bg-opacity-10 text-success
                        <?php elseif($activity['type'] === 'alpha'): ?> bg-danger bg-opacity-10 text-danger
                        <?php elseif($activity['type'] === 'izin'): ?> bg-warning bg-opacity-10 text-warning
                        <?php else: ?> bg-info bg-opacity-10 text-info <?php endif; ?>;">
                        <?php if($activity['type'] === 'hadir'): ?>
                            <i class="fas fa-check" style="font-size:12px;"></i>
                        <?php elseif($activity['type'] === 'alpha'): ?>
                            <i class="fas fa-times" style="font-size:12px;"></i>
                        <?php elseif($activity['type'] === 'izin'): ?>
                            <i class="fas fa-user-clock" style="font-size:12px;"></i>
                        <?php else: ?>
                            <i class="fas fa-user-injured" style="font-size:12px;"></i>
                        <?php endif; ?>
                    </div>
                    <div class="flex-grow-1" style="min-width:0;">
                        <small class="fw-medium text-dark d-block text-truncate"><?php echo e($activity['santri']); ?></small>
                        <small class="text-muted"><?php echo e($activity['time']); ?></small>
                    </div>
                    <span class="badge rounded-pill px-2 py-1 fs-10 <?php echo e($activity['status'] === 'hadir' ? 'bg-success' : 
                        ($activity['status'] === 'alpha' ? 'bg-danger' : 
                        ($activity['status'] === 'izin' ? 'bg-warning' : 'bg-info'))); ?> text-white">
                        <?php echo e(ucfirst($activity['status'])); ?>

                    </span>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="text-center py-3">
                    <i class="fas fa-inbox text-muted" style="font-size:1.5rem; display:block; margin-bottom:0.5rem;"></i>
                    <p class="text-muted mb-0" style="font-size:0.82rem;">Tidak ada aktivitas.</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="mini-card h-100 d-flex flex-column">
            <h6 class="mb-2"><i class="fas fa-info-circle text-primary"></i> Info Cepat</h6>
            <div class="flex-grow-1">
                <div class="info-row">
                    <span class="d-flex align-items-center gap-2 mb-0">
                        <i class="fas fa-users text-primary" style="font-size:0.75rem;"></i>
                        <small class="text-muted">Total Santri Aktif</small>
                    </span>
                    <strong class="mb-0"><?php echo e($totalSantri ?? 0); ?></strong>
                </div>
                <div class="info-row">
                    <span class="d-flex align-items-center gap-2 mb-0">
                        <i class="fas fa-check-circle text-success" style="font-size:0.75rem;"></i>
                        <small class="text-muted">Hadir Hari Ini</small>
                    </span>
                    <strong class="mb-0 text-success"><?php echo e($totalHadirHariIni ?? 0); ?></strong>
                </div>
                <div class="info-row">
                    <span class="d-flex align-items-center gap-2 mb-0">
                        <i class="fas fa-times-circle text-danger" style="font-size:0.75rem;"></i>
                        <small class="text-muted">Alpha Hari Ini</small>
                    </span>
                    <strong class="mb-0 text-danger"><?php echo e($totalAlphaHariIni ?? 0); ?></strong>
                </div>
                <div class="info-row">
                    <span class="d-flex align-items-center gap-2 mb-0">
                        <i class="fas fa-money-bill-wave text-warning" style="font-size:0.75rem;"></i>
                        <small class="text-muted">Denda Bulan Ini</small>
                    </span>
                    <strong class="mb-0 text-warning">Rp <?php echo e(number_format($totalDendaBulan ?? 0, 0, ',', '.')); ?></strong>
                </div>
                <div class="info-row">
                    <span class="d-flex align-items-center gap-2 mb-0">
                        <i class="fas fa-percentage text-info" style="font-size:0.75rem;"></i>
                        <small class="text-muted">Tingkat Kehadiran</small>
                    </span>
                    <strong class="mb-0 text-info"><?php echo e($persentaseKehadiran ?? 0); ?>%</strong>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Akhir Section Dashboard Santri -->

<?php endif; ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.46.0/dist/apexcharts.min.js"></script>
<script>
    // Item 3 & 4: Ring Progress Animation
    var persentaseKehadiran = <?php echo e($persentaseKehadiran ?? 0); ?>;
    var circumference = 138.23;
    var offset = circumference * (1 - persentaseKehadiran / 100);
    document.getElementById('ringKehadiran').style.strokeDashoffset = offset;

    var weeklyOptions = {
        series: [{ name: 'Kehadiran', data: <?php echo json_encode($weeklyData ?? [0, 0, 0) ?> }],
        chart: { type: 'area', height: 180, sparkline: { enabled: false }, toolbar: { show: false }, zoom: { enabled: false }},
        colors: ['#059669'],
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth', width: 2 },
        fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.3, opacityTo: 0.05 }},
        xaxis: { categories: ['Sen','Sel','Rab','Kam','Jum','Sab','Min'], labels: { style: { fontSize: '10px', colors: '#94a3b8' }}},
        yaxis: { labels: { style: { fontSize: '10px', colors: '#94a3b8' }}},
        grid: { show: true, borderColor: '#e5e7eb', strokeDashArray: 3 }
    };
    new ApexCharts(document.querySelector("#weeklyChart"), weeklyOptions).render();
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PROJEK BOSS\sistem-presensi\sistem-presensi\resources\views\dashboard.blade.php ENDPATH**/ ?>