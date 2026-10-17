<?php $__env->startSection('title', 'Detail Santri'); ?>

<?php $__env->startSection('content'); ?>
<div class="card" style="margin-bottom: 24px;">
    <div class="card-header">
        <h3 class="card-title">Detail Santri</h3>
        <div style="display: flex; gap: 8px;">
            <a href="<?php echo e(route('santri.edit', $santri->id)); ?>" class="btn btn-secondary">
                <i class="fas fa-edit"></i>
                Edit
            </a>
            <a href="<?php echo e(route('santri.index')); ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
        </div>
    </div>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
        <div>
            <p style="font-size: 12px; color: var(--gray); margin-bottom: 4px;">Nama</p>
            <p style="font-size: 18px; font-weight: 600;"><?php echo e($santri->nama); ?></p>
        </div>
        <div>
            <p style="font-size: 12px; color: var(--gray); margin-bottom: 4px;">NIS</p>
            <p style="font-size: 18px; font-weight: 600;"><?php echo e($santri->nis); ?></p>
        </div>
        <div>
            <p style="font-size: 12px; color: var(--gray); margin-bottom: 4px;">Khalaqoh</p>
            <p style="font-size: 18px; font-weight: 600;">
                <span class="badge badge-info"><?php echo e($santri->jenjang); ?></span>
            </p>
        </div>
        <div>
            <p style="font-size: 12px; color: var(--gray); margin-bottom: 4px;">Kelas</p>
            <p style="font-size: 18px; font-weight: 600;"><?php echo e($santri->kelas ?? '-'); ?></p>
        </div>
        <div>
            <p style="font-size: 12px; color: var(--gray); margin-bottom: 4px;">Status</p>
            <p style="font-size: 18px; font-weight: 600;">
                <?php if($santri->status): ?>
                <span class="badge badge-success">Aktif</span>
                <?php else: ?>
                <span class="badge badge-danger">Nonaktif</span>
                <?php endif; ?>
            </p>
        </div>
        <div>
            <p style="font-size: 12px; color: var(--gray); margin-bottom: 4px;">Alamat</p>
            <p style="font-size: 16px;"><?php echo e($santri->alamat ?? '-'); ?></p>
        </div>
        <div>
            <p style="font-size: 12px; color: var(--gray); margin-bottom: 4px;">No. HP</p>
            <p style="font-size: 16px;"><?php echo e($santri->no_hp ?? '-'); ?></p>
        </div>
        <div>
            <p style="font-size: 12px; color: var(--gray); margin-bottom: 4px;">Nama Orang Tua</p>
            <p style="font-size: 16px;"><?php echo e($santri->nama_orang_tua ?? '-'); ?></p>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-clipboard-check"></i>
            Riwayat Absensi
        </h3>
    </div>
    
    <?php if($absensi->count() > 0): ?>
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Hari</th>
                    <th>Urutan</th>
                    <th>Status</th>
                    <th>Denda</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $absensi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e(\Carbon\Carbon::parse($a->tanggal)->format('d M Y')); ?></td>
                    <td><?php echo e($a->hari); ?></td>
                    <td>
                        <?php if($a->jamPelajaran): ?>
                            Jam <?php echo e($a->jamPelajaran->urutan); ?>

                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($a->status === 'hadir'): ?>
                        <span class="badge badge-success">Hadir</span>
                        <?php elseif($a->status === 'izin'): ?>
                        <span class="badge badge-warning">Izin</span>
                        <?php elseif($a->status === 'sakit'): ?>
                        <span class="badge badge-info">Sakit</span>
                        <?php else: ?>
                        <span class="badge badge-danger">Alpha</span>
                        <?php endif; ?>
                    </td>
                    <td>Rp <?php echo e(number_format($a->denda, 0, ',', '.')); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    
    <div class="pagination">
        <?php echo e($absensi->links()); ?>

    </div>
    <?php else: ?>
    <div class="empty-state">
        <i class="fas fa-clipboard"></i>
        <h3>Belum Ada Riwayat Absensi</h3>
        <p>Belum ada data absensi untuk santri ini</p>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PROJEK BOSS\sistem-presensi\sistem-presensi\resources\views/santri/show.blade.php ENDPATH**/ ?>