<?php $__env->startSection('title', 'Pengaturan'); ?>

<?php $__env->startSection('content'); ?>
<div class="card" style="margin-top: 24px;">
    <div class="card-header">
        <h3 class="card-title" style="color: var(--danger);">⚠️ Reset Data Presensi</h3>
    </div>
    <p style="color: var(--gray); margin-bottom: 16px;">
        Tindakan ini akan menghapus <strong>SEMUA</strong> data presensi secara permanen. Tindakan ini tidak dapat dibatalkan.
    </p>
    <form action="<?php echo e(route('pengaturan.reset-presensi')); ?>" method="POST" id="reset-presensi-form">
        <?php echo csrf_field(); ?>
        <div class="form-group">
            <div style="display: flex; align-items: center; gap: 10px; padding: 12px; background: #fef2f2; border-radius: 8px; border: 1px solid #fecaca;">
                <input type="checkbox" id="confirm_presensi" name="confirmation" value="YA" required style="width: 20px; height: 20px; accent-color: var(--danger);">
                <label for="confirm_presensi" style="margin: 0; font-weight: 500; color: var(--danger);">
                    Saya yakin ingin menghapus semua data presensi
                </label>
            </div>
            <?php $__errorArgs = ['confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="alert alert-danger" style="margin-top:8px; padding:10px;"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <button type="submit" class="btn btn-primary" id="btn-reset-presensi" disabled style="background-color: var(--danger); border-color: var(--danger);">
            <i class="fas fa-trash"></i> Reset Data Presensi
        </button>
    </form>
</div>

<div class="card" style="margin-top: 24px; border-color: var(--danger);">
    <div class="card-header">
        <h3 class="card-title" style="color: var(--danger);">🗑️ Reset Data Santri</h3>
    </div>
    <p style="color: var(--gray); margin-bottom: 16px;">
        Hapus <strong>SEMUA</strong> data santri secara permanen. Tindakan ini tidak dapat dibatalkan.
    </p>
    <form action="<?php echo e(route('pengaturan.reset-santri')); ?>" method="POST" id="reset-santri-form">
        <?php echo csrf_field(); ?>
        <div class="form-group">
            <div style="display: flex; align-items: center; gap: 10px; padding: 12px; background: #fef2f2; border-radius: 8px; border: 1px solid #fecaca;">
                <input type="checkbox" id="confirm_santri" name="confirmation" value="YA" required style="width: 20px; height: 20px; accent-color: var(--danger);">
                <label for="confirm_santri" style="margin: 0; font-weight: 500; color: var(--danger);">
                    Saya yakin ingin menghapus semua data santri
                </label>
            </div>
            <?php $__errorArgs = ['confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="alert alert-danger" style="margin-top:8px; padding:10px;"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <button type="submit" class="btn btn-secondary" id="btn-reset-santri" disabled style="border-color: var(--danger); color: var(--danger);">
            <i class="fas fa-users-slash"></i> Reset Data Santri
        </button>
    </form>
</div>

<script>
// Enable/disable tombol reset berdasarkan checkbox
document.getElementById('confirm_presensi').addEventListener('change', function() {
    document.getElementById('btn-reset-presensi').disabled = !this.checked;
});

document.getElementById('confirm_santri').addEventListener('change', function() {
    document.getElementById('btn-reset-santri').disabled = !this.checked;
});

// Konfirmasi sebelum submit
document.getElementById('reset-presensi-form').addEventListener('submit', function(e) {
    if (!confirm('PERHATIAN: Anda akan menghapus SEMUA data presensi. Tindakan ini TIDAK DAPAT DIBATALKAN. Lanjutkan?')) {
        e.preventDefault();
    }
});

document.getElementById('reset-santri-form').addEventListener('submit', function(e) {
    if (!confirm('PERHATIAN: Anda akan menghapus SEMUA data santri. Tindakan ini TIDAK DAPAT DIBATALKAN. Lanjutkan?')) {
        e.preventDefault();
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PROJEK BOSS\sistem-presensi\sistem-presensi\resources\views\pengaturan\index.blade.php ENDPATH**/ ?>