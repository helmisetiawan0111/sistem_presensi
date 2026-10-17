<?php $__env->startSection('title', 'Rekap Denda'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <!-- Header Section -->
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-money-check-alt"></i> Rekap Denda Santri
        </h3>
        <div style="display: flex; gap: 8px; align-items: center;">
            <span style="font-size: 13px; color: #64748b;">
                <i class="fas fa-calendar-alt"></i> <?php echo e(\Carbon\Carbon::createFromDate($tahun, $bulan, 1)->locale('id')->monthName); ?> <?php echo e($tahun); ?>

            </span>
        </div>
    </div>

    <!-- Filter Section -->
    <div style="background: #f8fafc; padding: 20px; border-radius: 12px; margin-bottom: 24px; border: 1px solid #e2e8f0;">
        <form action="<?php echo e(route('rekap.denda')); ?>" method="GET" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; align-items: end;">
            <div class="form-group" style="margin-bottom: 0;">
                <label class="form-label">Bulan</label>
                <select name="bulan" class="form-select">
                    <?php $__currentLoopData = $bulanList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($key); ?>" <?php echo e($bulan == $key ? 'selected' : ''); ?>><?php echo e($name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="form-group" style="margin-bottom: 0;">
                <label class="form-label">Tahun</label>
                <select name="tahun" class="form-select">
                    <?php $__currentLoopData = $tahunList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($t); ?>" <?php echo e($tahun == $t ? 'selected' : ''); ?>><?php echo e($t); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                <h3>Rp <?php echo e(number_format($totalDenda, 0, ',', '.')); ?></h3>
                <p>Total Denda Bulan Ini</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <h3><?php echo e(count($data)); ?></h3>
                <p>Jumlah Santri Denda</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon purple">
                <i class="fas fa-calculator"></i>
            </div>
            <div class="stat-content">
                <h3><?php echo e(count($data) > 0 ? number_format($totalDenda / count($data), 0, ',', '.') : 0); ?></h3>
                <p>Rata-rata Denda per Santri</p>
            </div>
        </div>
    </div>

    <!-- Main Table -->
    <?php if(count($data) > 0): ?>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Rekap Denda per Santri</h3>
            <div style="font-size: 13px; color: #64748b;">
                <i class="fas fa-sort-amount-down"></i> Urut dari denda terbanyak
            </div>
        </div>
        
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 60px;">Rank</th>
                        <th>Nama Santri</th>
                        <th class="text-center" style="width: 70px;">Izin</th>
                        <th class="text-center" style="width: 70px;">Sakit</th>
                        <th class="text-center" style="width: 70px;">Alpha</th>
                        <th class="text-center" style="width: 120px;">Total Denda</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="text-center">
                            <?php if($index + 1 == 1): ?>
                                <span class="badge badge-warning" style="font-size: 14px;">🥇 <?php echo e($index + 1); ?></span>
                            <?php elseif($index + 1 == 2): ?>
                                <span class="badge" style="background:#e5e7eb;color:#374151; font-size: 14px;">🥈 <?php echo e($index + 1); ?></span>
                            <?php elseif($index + 1 == 3): ?>
                                <span class="badge" style="background:#d97706;color:#fff; font-size: 14px;">🥉 <?php echo e($index + 1); ?></span>
                            <?php else: ?>
                                <span style="font-weight: 600; color: #64748b;"><?php echo e($index + 1); ?></span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 36px; height: 36px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 13px;">
                                    <?php echo e(strtoupper(substr($d['santri']->nama, 0, 1))); ?>

                                </div>
                                <div>
                                    <div style="font-weight: 600; color: #1e293b;"><?php echo e($d['santri']->nama); ?></div>
                                    <div style="font-size: 11px; color: #94a3b8;"><?php echo e($d['santri']->nis ?? 'N/A'); ?></div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="badge" style="background: #fef3c7; color: #92400e; font-weight: 600;"><?php echo e($d['izin']); ?>x</span>
                        </td>
                        <td class="text-center">
                            <span class="badge" style="background: #dbeafe; color: #1e40af; font-weight: 600;"><?php echo e($d['sakit']); ?>x</span>
                        </td>
                        <td class="text-center">
                            <span class="badge" style="background: #fee2e2; color: #991b1b; font-weight: 600;"><?php echo e($d['alpha']); ?>x</span>
                        </td>
                        <td class="text-center">
                            <div style="font-weight: 700; color: #dc2626; font-size: 15px;">
                                Rp <?php echo e(number_format($d['denda'], 0, ',', '.')); ?>

                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        <!-- Summary Footer -->
        <div style="margin-top: 20px; padding: 16px; background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); border-radius: 10px; border-left: 4px solid #d97706;">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
                <div>
                    <span style="font-size: 13px; color: #92400e; font-weight: 600;">
                        Total Santri dengan Denda: <strong><?php echo e(count($data)); ?></strong>
                    </span>
                </div>
                <div style="font-size: 14px; color: #78350f;">
                    <i class="fas fa-info-circle"></i> Denda: Izin × Rp 2.000, Sakit × Rp 2.000, Alpha × Rp 5.000
                </div>
            </div>
        </div>
    </div>
    <?php else: ?>
    <div class="empty-state">
        <i class="fas fa-smile" style="font-size: 64px; color: #10b981; margin-bottom: 24px;"></i>
        <h3 style="color: #059669; font-weight: 600;">Alhamdulillah!</h3>
        <p style="color: #64748b; font-size: 15px;">Tidak ada santri dengan denda pada bulan <?php echo e(\Carbon\Carbon::createFromDate($tahun, $bulan, 1)->locale('id')->monthName); ?> <?php echo e($tahun); ?>.</p>
        <p style="color: #94a3b8; font-size: 13px; margin-top: 8px;">Semua santri telah memiliki kehadiran yang baik.</p>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PROJEK BOSS\sistem-presensi\sistem-presensi\resources\views\rekap\denda.blade.php ENDPATH**/ ?>