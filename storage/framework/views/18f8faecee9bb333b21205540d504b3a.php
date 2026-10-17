<?php $__env->startSection('title', 'Laporan'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-file-alt"></i> Laporan Presensi
        </h3>
        <div style="display: flex; gap: 8px; align-items: center;">
            <span style="font-size: 13px; color: #64748b;">
                <i class="fas fa-calendar-alt"></i> <?php echo e(\Carbon\Carbon::createFromDate($tahun, $bulan, 1)->locale('id')->monthName); ?> <?php echo e($tahun); ?>

            </span>
        </div>
    </div>

    <!-- Filter Section -->
    <div style="background: #f8fafc; padding: 20px; border-radius: 12px; margin-bottom: 24px; border: 1px solid #e2e8f0;">
        <form action="<?php echo e(route('laporan.presensi')); ?>" method="GET" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; align-items: end;">
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

    <!-- PDF Actions -->
    <div style="display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 24px; padding: 16px; background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border-radius: 12px; border: 1px solid #e2e8f0;">
        <div style="flex: 1; min-width: 200px;">
            <h4 style="font-size: 14px; font-weight: 600; color: #1e293b; margin-bottom: 8px;">
                <i class="fas fa-file-pdf" style="color: #dc2626;"></i> Export PDF
            </h4>
            <p style="font-size: 12px; color: #64748b; margin-bottom: 12px;">Cetak laporan dalam format PDF</p>
            <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                <a href="<?php echo e(route('laporan.pdf-rekap', ['bulan' => $bulan, 'tahun' => $tahun])); ?>" class="btn btn-sm btn-secondary" target="_blank">
                    <i class="fas fa-chart-bar"></i> Rekap
                </a>
                <a href="<?php echo e(route('laporan.pdf-denda', ['bulan' => $bulan, 'tahun' => $tahun])); ?>" class="btn btn-sm btn-secondary" target="_blank">
                    <i class="fas fa-money-check-alt"></i> Denda
                </a>
                <a href="<?php echo e(route('laporan.pdf-ranking', ['bulan' => $bulan, 'tahun' => $tahun])); ?>" class="btn btn-sm btn-secondary" target="_blank">
                    <i class="fas fa-trophy"></i> Ranking
                </a>
                <a href="<?php echo e(route('laporan.pdf-complete', ['bulan' => $bulan, 'tahun' => $tahun])); ?>" class="btn btn-sm btn-primary" target="_blank">
                    <i class="fas fa-file-alt"></i> Lengkap
                </a>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <?php if(count($data) > 0): ?>
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th>Nama Santri</th>
                    <th class="text-center">Hadir</th>
                    <th class="text-center">Izin</th>
                    <th class="text-center">Sakit</th>
                    <th class="text-center">Alpha</th>
                    <th class="text-center">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td class="text-center"><?php echo e($index + 1); ?></td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 32px; height: 32px; background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 12px;">
                                <?php echo e(strtoupper(substr($d['santri']->nama, 0, 1))); ?>

                            </div>
                            <span style="font-weight: 500;"><?php echo e($d['santri']->nama); ?></span>
                        </div>
                    </td>
                    <td class="text-center"><span class="badge badge-success"><?php echo e($d['hadir']); ?></span></td>
                    <td class="text-center"><span class="badge badge-warning"><?php echo e($d['izin']); ?></span></td>
                    <td class="text-center"><span class="badge badge-info"><?php echo e($d['sakit']); ?></span></td>
                    <td class="text-center"><span class="badge badge-danger"><?php echo e($d['alpha']); ?></span></td>
                    <td class="text-center"><strong><?php echo e($d['total']); ?></strong></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
    <div class="empty-state">
        <i class="fas fa-search" style="font-size: 48px; color: #cbd5e1; margin-bottom: 16px;"></i>
        <h3>Tidak Ada Data</h3>
        <p>Tidak ada data presensi untuk bulan dan tahun yang dipilih.</p>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PROJEK BOSS\sistem-presensi\sistem-presensi\resources\views/laporan/presensi.blade.php ENDPATH**/ ?>