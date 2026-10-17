<?php $__env->startSection('title', 'Riwayat Presensi Saya'); ?>

<?php $__env->startPush('styles'); ?>
<style>
.table-row-header {
    font-weight: 500;
}

.table-row-subtext {
    font-size: 0.75rem;
    color: #64748b;
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="section-card mb-3">
        <h5 class="mb-3"><i class="fas fa-search"></i> Filter Pencarian</h5>
        <form method="GET" action="<?php echo e(route('santri.attendance')); ?>">
            <div class="row g-2">
                <div class="col-md-2 col-sm-4 col-6">
                    <label class="form-label">Bulan</label>
                    <select name="bulan" class="form-select">
                        <option value="">Semua Bulan</option>
                        <?php $__currentLoopData = $months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($value); ?>" <?php echo e(request()->input('bulan') == $value ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-2 col-sm-4 col-6">
                    <label class="form-label">Tahun</label>
                    <select name="tahun" class="form-select">
                        <option value="">Semua Tahun</option>
                        <?php $__currentLoopData = $years; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($year); ?>" <?php echo e(request()->input('tahun') == $year ? 'selected' : ''); ?>><?php echo e($year); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-2 col-sm-4 col-6">
                    <label class="form-label">Status</label>
                    <select name="cari" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="hadir" <?php echo e(request()->input('cari') == 'hadir' ? 'selected' : ''); ?>>Hadir</option>
                        <option value="alpha" <?php echo e(request()->input('cari') == 'alpha' ? 'selected' : ''); ?>>Alpha</option>
                        <option value="izin" <?php echo e(request()->input('cari') == 'izin' ? 'selected' : ''); ?>>Izin</option>
                        <option value="sakit" <?php echo e(request()->input('cari') == 'sakit' ? 'selected' : ''); ?>>Sakit</option>
                    </select>
                </div>
            </div>
            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Cari
                </button>
                <a href="<?php echo e(route('santri.attendance')); ?>" class="btn btn-warning">
                    <i class="fas fa-undo"></i> Reset
                </a>
            </div>
        </form>
    </div>

    <div class="section-card">
        <?php if($absensi->isEmpty()): ?>
            <div class="empty-state">
                <div class="empty-icon"><i class="fas fa-folder-open"></i></div>
                <p class="empty-text">Tidak ada data presensi untuk filter yang dipilih.</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Jam Pelajaran</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $absensi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <div class="table-row-header"><?php echo e(\Carbon\Carbon::parse($row->tanggal)->format('d M Y')); ?></div>
                                    <div class="table-row-subtext"><?php echo e(\Carbon\Carbon::parse($row->tanggal)->locale('id')->dayName); ?></div>
                                </td>
                                <td>
                                    <?php if($row->jamPelajaran): ?>
                                        <?php echo e($row->jamPelajaran->nama); ?>

                                        <div class="table-row-subtext">
                                            <?php echo e($row->jamPelajaran->jam_mulai_formatted); ?> - <?php echo e($row->jamPelajaran->jam_selesai_formatted); ?>

                                        </div>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge-status <?php echo e($row->status); ?>">
                                        <i class="fas fa-circle me-1" style="font-size:0.5rem;"></i>
                                        <?php echo e(ucfirst($row->status)); ?>

                                    </span>
                                </td>
                                <td><?php echo e($row->keterangan ?? '-'); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            <div class="pagination">
                <?php echo e($absensi->links()); ?>

            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PROJEK BOSS\sistem-presensi\sistem-presensi\resources\views/santri/attendance.blade.php ENDPATH**/ ?>