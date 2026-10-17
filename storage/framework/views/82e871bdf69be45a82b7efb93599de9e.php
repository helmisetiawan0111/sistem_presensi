<?php $__env->startSection('title', 'Ranking Kehadiran'); ?>

<?php $__env->startSection('content'); ?>
<div class="card" style="margin-bottom: 1.5rem;">
    <form action="<?php echo e(route('rekap.ranking')); ?>" method="GET" style="display: flex; gap: 1rem; align-items: flex-end;">
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
        <button type="submit" class="btn btn-primary">Filter</button>
    </form>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Ranking Kehadiran Santri</h3>
    </div>
    
    <?php if(count($data) > 0): ?>
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>Rank</th>
                    <th>Nama</th>
                    <th>Hadir</th>
                    <th>Izin</th>
                    <th>Sakit</th>
                    <th>Alpha</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td>
                        <?php if($d['rank'] == 1): ?>
                        <span class="badge" style="background: gold; color: black;">🥇 1</span>
                        <?php elseif($d['rank'] == 2): ?>
                        <span class="badge" style="background: silver; color: black;">🥈 2</span>
                        <?php elseif($d['rank'] == 3): ?>
                        <span class="badge" style="background: #cd7f32; color: white;">🥉 3</span>
                        <?php else: ?>
                        <?php echo e($d['rank']); ?>

                        <?php endif; ?>
                    </td>
                    <td><?php echo e($d['santri']->nama); ?></td>
                    <td><span class="badge badge-success"><?php echo e($d['hadir']); ?></span></td>
                    <td><span class="badge badge-warning"><?php echo e($d['izin']); ?></span></td>
                    <td><span class="badge badge-info"><?php echo e($d['sakit']); ?></span></td>
                    <td><span class="badge badge-danger"><?php echo e($d['alpha']); ?></span></td>
                    <td><?php echo e($d['total']); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
    <div class="empty-state">
        <p>Tidak ada data absensi</p>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PROJEK BOSS\sistem-presensi\sistem-presensi\resources\views\rekap\ranking.blade.php ENDPATH**/ ?>