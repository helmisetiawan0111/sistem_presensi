<?php $__env->startSection('title', 'Tambah Santri'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Tambah Data Santri</h3>
    </div>
    
    <form action="<?php echo e(route('santri.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        
        <div class="form-group">
            <label class="form-label">NIS *</label>
            <input type="text" name="nis" class="form-input" required value="<?php echo e(old('nis')); ?>">
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
            <input type="text" name="nama" class="form-input" required value="<?php echo e(old('nama')); ?>">
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
            <textarea name="alamat" class="form-input"><?php echo e(old('alamat')); ?></textarea>
        </div>
        
        <div class="form-group">
            <label class="form-label">No. HP</label>
            <input type="text" name="no_hp" class="form-input" value="<?php echo e(old('no_hp')); ?>">
        </div>
        
        <div class="form-group">
            <label class="form-label">Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" class="form-input" value="<?php echo e(old('tanggal_lahir')); ?>">
        </div>
        
        <div class="form-group">
            <label class="form-label">Nama Orang Tua</label>
            <input type="text" name="nama_orang_tua" class="form-input" value="<?php echo e(old('nama_orang_tua')); ?>">
        </div>
        
        <div class="form-group">
            <label class="form-label">Khalaqoh *</label>
            <select name="jenjang" class="form-select" required>
                <option value="">Pilih Khalaqoh</option>
                <option value="Safinatunnajah" <?php echo e(old('jenjang') === 'Safinatunnajah' ? 'selected' : ''); ?>>Safinatunnajah</option>
                <option value="Muqodimah" <?php echo e(old('jenjang') === 'Muqodimah' ? 'selected' : ''); ?>>Muqodimah</option>
            </select>
            <?php $__errorArgs = ['jenjang'];
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
            <label class="form-label">Kelas</label>
            <select name="kelas" class="form-select">
                <option value="">Pilih Kelas</option>
                <option value="Kelas 1" <?php echo e(old('kelas') === 'Kelas 1' ? 'selected' : ''); ?>>Kelas 1</option>
                <option value="Kelas 2" <?php echo e(old('kelas') === 'Kelas 2' ? 'selected' : ''); ?>>Kelas 2</option>
            </select>
        </div>
        
        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="<?php echo e(route('santri.index')); ?>" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PROJEK BOSS\sistem-presensi\sistem-presensi\resources\views\santri\create.blade.php ENDPATH**/ ?>