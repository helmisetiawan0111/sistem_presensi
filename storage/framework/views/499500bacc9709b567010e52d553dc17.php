<?php $__env->startSection('title', 'Data Santri'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Data Santri</h3>
        <a href="<?php echo e(route('santri.create')); ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            Tambah Santri
        </a>
    </div>
    
    <form action="<?php echo e(route('santri.index')); ?>" method="GET" style="display: flex; gap: 12px; margin-bottom: 20px; flex-wrap: wrap;">
        <input type="text" name="search" placeholder="Cari nama atau NIS..." class="form-input" style="max-width: 280px;" value="<?php echo e($search ?? ''); ?>">
        
        <select name="jenjang" class="form-select" style="max-width: 180px;">
            <option value="">Semua Khalaqoh</option>
            <option value="Safinatunnajah" <?php echo e(($jenjang ?? '') === 'Safinatunnajah' ? 'selected' : ''); ?>>Safinatunnajah</option>
            <option value="Muqodimah" <?php echo e(($jenjang ?? '') === 'Muqodimah' ? 'selected' : ''); ?>>Muqodimah</option>
        </select>
        
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-search"></i>
            Cari
        </button>
        
        <?php if($search || $jenjang): ?>
        <a href="<?php echo e(route('santri.index')); ?>" class="btn btn-secondary">
            <i class="fas fa-times"></i>
            Reset
        </a>
        <?php endif; ?>
    </form>
    
    <?php if($santri->count() > 0): ?>
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIS</th>
                    <th>Nama</th>
                    <th>Jenjang</th>
                    <th>Kelas</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $santri; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($santri->firstItem() + $index); ?></td>
                    <td><span class="badge badge-primary"><?php echo e($s->nis); ?></span></td>
                    <td><strong><?php echo e($s->nama); ?></strong></td>
                    <td><span class="badge badge-info"><?php echo e($s->jenjang); ?></span></td>
                    <td><?php echo e($s->kelas ?? '-'); ?></td>
                    <td>
                        <?php if($s->status): ?>
                        <span class="badge badge-success">Aktif</span>
                        <?php else: ?>
                        <span class="badge badge-danger">Nonaktif</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div style="display: flex; gap: 8px;">
                            <a href="<?php echo e(route('santri.show', $s->id)); ?>" class="btn btn-sm btn-secondary" title="Lihat">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="<?php echo e(route('santri.edit', $s->id)); ?>" class="btn btn-sm btn-secondary" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="<?php echo e(route('santri.destroy', $s->id)); ?>" method="POST" style="display: inline;">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Yakin hapus data ini?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
        <div style="color: var(--secondary); font-size: 13px;">
            Menampilkan <?php echo e($santri->firstItem() ?? 0); ?> - <?php echo e($santri->lastItem() ?? 0); ?> dari <?php echo e($santri->total()); ?> data
        </div>
        <div class="pagination" style="display: flex; gap: 4px; align-items: center; flex-wrap: wrap;">
            <button type="button" class="btn btn-sm btn-secondary" 
                    style="cursor: pointer; opacity: <?php echo e($santri->onFirstPage() ? '0.4' : '1'); ?>; pointer-events: <?php echo e($santri->onFirstPage() ? 'none' : 'auto'); ?>;"
                    onclick="changePage(<?php echo e($santri->currentPage() - 1); ?>)">
                <i class="fas fa-chevron-left"></i> Sebelumnya
            </button>

            <?php for($i = 1; $i <= $santri->lastPage(); $i++): ?>
                <a href="javascript:void(0)" 
                   onclick="changePage(<?php echo e($i); ?>)"
                   style="display: flex; align-items: center; justify-content: center; width: 36px; height: 36px; border-radius: 10px; font-size: 13px; font-weight: 600; text-decoration: none; border: 1px solid var(--border); color: var(--dark); background: var(--white); transition: all 0.2s; cursor: pointer; <?php echo e($i === $santri->currentPage() ? 'background: var(--primary); color: white; border-color: var(--primary);' : ''); ?> <?php echo e($i !== $santri->currentPage() ? 'cursor: pointer;' : ''); ?>"
                ><?php echo e($i); ?></a>
            <?php endfor; ?>

            <button type="button" class="btn btn-sm btn-secondary" 
                    style="cursor: pointer; opacity: <?php echo e($santri->hasMorePages() ? '1' : '0.4'); ?>; pointer-events: <?php echo e($santri->hasMorePages() ? 'auto' : 'none'); ?>;"
                    onclick="changePage(<?php echo e($santri->currentPage() + 1); ?>)">
                Berikutnya <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>

    <form id="paginationForm" action="<?php echo e(route('santri.index')); ?>" method="GET">
        <input type="hidden" name="page" id="pageInput">
        <input type="hidden" name="search" value="<?php echo e($search ?? ''); ?>">
        <input type="hidden" name="jenjang" value="<?php echo e($jenjang ?? ''); ?>">
    </form>

    <script>
        function changePage(page) {
            document.getElementById('pageInput').value = page;
            document.getElementById('paginationForm').submit();
        }
    </script>
    <?php else: ?>
    <div class="empty-state">
        <i class="fas fa-users"></i>
        <h3>Belum Ada Data Santri</h3>
        <p>Silakan tambah data santri terlebih dahulu</p>
        <a href="<?php echo e(route('santri.create')); ?>" class="btn btn-primary" style="margin-top: 16px;">
            <i class="fas fa-plus"></i>
            Tambah Santri
        </a>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PROJEK BOSS\sistem-presensi\sistem-presensi\resources\views\santri\index.blade.php ENDPATH**/ ?>