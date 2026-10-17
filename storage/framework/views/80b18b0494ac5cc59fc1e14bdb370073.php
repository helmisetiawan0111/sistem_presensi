<?php $__env->startSection('title', 'Ranking Kehadiran'); ?>

<?php $__env->startPush('styles'); ?>
<style>
.ranking-header {
    text-align: center;
    padding: 1rem 0;
    margin-bottom: 1.5rem;
}

.ranking-header h5 {
    font-size: 1rem;
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 0.5rem;
}

.ranking-header .period {
    font-size: 0.85rem;
    color: #64748b;
}

.ranking-position-card {
    background: linear-gradient(135deg, #059669, #0d9488);
    color: white;
    border-radius: 16px;
    padding: 1.5rem;
    text-align: center;
    margin-bottom: 1.5rem;
}

.ranking-position-card .position-number {
    font-size: 3rem;
    font-weight: 700;
    line-height: 1;
}

.ranking-position-card .position-label {
    font-size: 0.9rem;
    opacity: 0.9;
    margin-top: 0.5rem;
}

.ranking-table th {
    background: #f8fafc;
    font-size: 0.75rem;
    text-transform: uppercase;
}

.ranking-table td {
    font-size: 0.85rem;
}

.ranking-table tr.highlight {
    background: #f0fdf4;
}

.ranking-table tr.highlight td {
    border-left: 3px solid #059669;
}

.position-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    font-weight: 600;
    font-size: 0.85rem;
}

.position-badge.gold { background: #fde047; color: #78350f; }
.position-badge.silver { background: #cbd5e1; color: #1e293b; }
.position-badge.bronze { background: #f97316; color: #78350f; }

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
    <div class="section-card">
        <div class="ranking-header">
            <h5><i class="fas fa-trophy"></i> Ranking Kehadiran Santri</h5>
            <div class="period">Periode: <?php echo e(\Carbon\Carbon::now()->locale('id')->monthName); ?> <?php echo e(\Carbon\Carbon::now()->year); ?></div>
        </div>

        <?php if(empty($santris)): ?>
            <div class="empty-state">
                <div class="empty-icon"><i class="fas fa-trophy"></i></div>
                <p class="empty-text">Belum ada data ranking untuk bulan ini.</p>
            </div>
        <?php else: ?>
            <!-- Posisi Saya -->
            <div class="ranking-position-card">
                <div class="position-number"><?php echo e($myPosition ?? '-'); ?></div>
                <div class="position-label">Posisi Anda saat ini</div>
            </div>

            <!-- Tabel Ranking -->
            <div class="table-responsive">
                <table class="data-table ranking-table">
                    <thead>
                        <tr>
                            <th style="width:60px;">Ranking</th>
                            <th>Nama</th>
                            <th>NIS</th>
                            <th>Kelas</th>
                            <th style="width:120px;">Hadir</th>
                            <th style="width:120px;">Persentase</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $santris; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $santri): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="<?php echo e($santri['is_me'] ? 'highlight' : ''); ?>">
                                <td>
                                    <?php if($santri['position'] == 1): ?>
                                        <span class="position-badge gold"><i class="fas fa-crown"></i></span>
                                    <?php elseif($santri['position'] == 2): ?>
                                        <span class="position-badge silver">2</span>
                                    <?php elseif($santri['position'] == 3): ?>
                                        <span class="position-badge bronze">3</span>
                                    <?php else: ?>
                                        <span class="position-badge"><?php echo e($santri['position']); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div style="font-weight:500;<?php echo e($santri['is_me'] ? ' color:#059669;' : ''); ?>"><?php echo e($santri['nama']); ?></div>
                                    <?php if($santri['is_me']): ?>
                                        <small style="color:#059669;"><i class="fas fa-star"></i> Anda</small>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($santri['nis']); ?></td>
                                <td><?php echo e($santri['kelas'] ?? '-'); ?></td>
                                <td><?php echo e($santri['hadir_count']); ?></td>
                                <td><?php echo e($santri['persentase']); ?>%</td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PROJEK BOSS\sistem-presensi\sistem-presensi\resources\views\santri\ranking.blade.php ENDPATH**/ ?>