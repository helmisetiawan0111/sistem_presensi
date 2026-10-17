<?php $__env->startSection('title', 'Edit Santri'); ?>

<?php $__env->startSection('content'); ?>
<?php
    $user = $santri->user;
?>

<!-- Tab Navigation -->
<div style="display: flex; gap: 0.5rem; margin-bottom: 1.5rem; border-bottom: 1px solid #e2e8f0; padding-bottom: 0.5rem; align-items: center; flex-wrap: wrap;">
    <span class="btn btn-primary" style="border-radius: 8px 8px 0 0; pointer-events: none;">
        <i class="fas fa-user-graduate"></i> Data Santri
    </span>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit Data Santri</h3>
    </div>
    
    <form action="<?php echo e(route('santri.update', $santri->id)); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        
        <div class="form-group">
            <label class="form-label">NIS *</label>
            <input type="text" name="nis" class="form-input" required value="<?php echo e($santri->nis); ?>">
            <?php $__errorArgs = ['nis'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p style="color: var(--danger); font-size: 0.875rem; margin-top: 0.25rem;"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        
        <div class="form-group">
            <label class="form-label">Nama *</label>
            <input type="text" name="nama" class="form-input" required value="<?php echo e($santri->nama); ?>">
            <?php $__errorArgs = ['nama'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p style="color: var(--danger); font-size: 0.875rem; margin-top: 0.25rem;"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        
        <div class="form-group">
            <label class="form-label">Alamat</label>
            <textarea name="alamat" class="form-input"><?php echo e($santri->alamat); ?></textarea>
        </div>
        
        <div class="form-group">
            <label class="form-label">No. HP</label>
            <input type="text" name="no_hp" class="form-input" value="<?php echo e($santri->no_hp); ?>">
        </div>
        
        <div class="form-group">
            <label class="form-label">Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" class="form-input" value="<?php echo e($santri->tanggal_lahir); ?>">
        </div>
        
        <div class="form-group">
            <label class="form-label">Nama Orang Tua</label>
            <input type="text" name="nama_orang_tua" class="form-input" value="<?php echo e($santri->nama_orang_tua); ?>">
        </div>
        
        <div class="form-group">
            <label class="form-label">Khalaqoh *</label>
            <select name="jenjang" class="form-select" required>
                <option value="Safinatunnajah" <?php echo e($santri->jenjang === 'Safinatunnajah' ? 'selected' : ''); ?>>Safinatunnajah</option>
                <option value="Muqodimah" <?php echo e($santri->jenjang === 'Muqodimah' ? 'selected' : ''); ?>>Muqodimah</option>
            </select>
        </div>
        
        <div class="form-group">
            <label class="form-label">Kelas</label>
            <select name="kelas" class="form-select">
                <option value="">Pilih Kelas</option>
                <option value="Kelas 1" <?php echo e($santri->kelas === 'Kelas 1' ? 'selected' : ''); ?>>Kelas 1</option>
                <option value="Kelas 2" <?php echo e($santri->kelas === 'Kelas 2' ? 'selected' : ''); ?>>Kelas 2</option>
            </select>
        </div>
        
        <div class="form-group">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                <option value="1" <?php echo e($santri->status ? 'selected' : ''); ?>>Aktif</option>
                <option value="0" <?php echo e(!$santri->status ? 'selected' : ''); ?>>Nonaktif</option>
            </select>
        </div>
        
        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="<?php echo e(route('santri.index')); ?>" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PROJEK BOSS\sistem-presensi\sistem-presensi\resources\views\santri\edit.blade.php ENDPATH**/ ?>