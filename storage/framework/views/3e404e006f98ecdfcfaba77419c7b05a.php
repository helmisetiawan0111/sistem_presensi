<?php $__env->startSection('title', 'Pengaturan'); ?>

<?php $__env->startSection('content'); ?>
<?php if(session('status') === 'profile-updated'): ?>
    <div class="alert alert-success" style="margin-bottom: 20px;">
        <i class="fas fa-check-circle"></i> Profil berhasil diperbarui.
    </div>
<?php endif; ?>

<?php if(session('status') === 'password-updated'): ?>
    <div class="alert alert-success" style="margin-bottom: 20px;">
        <i class="fas fa-check-circle"></i> Kata sandi berhasil diubah.
    </div>
<?php endif; ?>

<?php if($user->isSantri() && $user->must_change_password): ?>
<div class="alert alert-danger" style="margin-bottom: 20px;">
    <i class="fas fa-exclamation-triangle"></i>
    Anda disarankan mengganti kata sandi sebelum melanjutkan.
    <a href="<?php echo e($user->isAdmin() ? route('password.update') : route('santri.password.update')); ?>" style="font-weight: 600;">Ganti sekarang</a>.
</div>
<?php endif; ?>

<!-- ==================== INFORMASI AKUN ==================== -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Informasi Akun</h3>
    </div>

    <!-- Username & NIS (read-only) -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px;">
        <div>
            <label class="form-label">Username</label>
            <div class="form-input" style="background: var(--light); color: var(--secondary);"><?php echo e($user->username ?? '-'); ?></div>
        </div>
        <?php if($user->nis): ?>
        <div>
            <label class="form-label">NIS</label>
            <div class="form-input" style="background: var(--light); color: var(--secondary);"><?php echo e($user->nis); ?></div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Form Nama -->
    <form method="post" action="<?php echo e(route('profile.update')); ?>">
        <?php echo csrf_field(); ?>
        <?php echo method_field('patch'); ?>

        <div class="form-group">
            <label class="form-label" for="name">Nama Lengkap</label>
            <input type="text" id="name" name="name" class="form-input" value="<?php echo e(old('name', $user->name)); ?>" required autofocus>
            <?php $__errorArgs = ['name'];
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

        <?php if($user->isAdmin()): ?>
        <div class="form-group">
            <label class="form-label" for="email">Email (untuk pemulihan akun)</label>
            <input type="email" id="email" name="email" class="form-input" value="<?php echo e(old('email', $user->email)); ?>" placeholder="email@domain.com">
            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="alert alert-danger" style="margin-top:8px; padding:10px;"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            <small style="color: var(--gray); font-size: 12px;">Email ini akan digunakan jika Anda lupa kata sandi.</small>
        </div>
        <?php endif; ?>

            <div style="margin-top: 24px; display: flex; gap: 12px;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    Simpan Perubahan
                </button>

                <?php if(auth()->guard()->check()): ?>
                    <?php if(auth()->user()->role === 'admin'): ?>
                        <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-secondary">
                    <?php elseif(auth()->user()->role === 'petugas'): ?>
                        <a href="<?php echo e(route('petugas.presensi.index')); ?>" class="btn btn-secondary">
                    <?php elseif(auth()->user()->role === 'santri'): ?>
                        <a href="<?php echo e(route('santri.dashboard')); ?>" class="btn btn-secondary">
                    <?php endif; ?>
                        <i class="fas fa-times"></i>
                        Batal
                    </a>
                <?php endif; ?>
            </div>
    </form>
</div>

<!-- ==================== DATA SANTRI ==================== -->
<?php if($user->isSantri() && $user->santo): ?>
<div class="card" style="margin-top: 24px;">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-user-graduate" style="color: var(--primary); margin-right: 8px;"></i>Data Santri
        </h3>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
        <div>
            <label class="form-label">Kelas</label>
            <div class="form-input" style="background: var(--light);"><?php echo e($user->santo->kelas_name ?? '-'); ?></div>
        </div>
        <div>
            <label class="form-label">Jenjang</label>
            <div class="form-input" style="background: var(--light);"><?php echo e(ucfirst($user->santo->jenjang)); ?></div>
        </div>
        <div>
            <label class="form-label">Nama Orang Tua</label>
            <div class="form-input" style="background: var(--light);"><?php echo e($user->santo->nama_orang_tua); ?></div>
        </div>
        <div>
            <label class="form-label">Nomor HP</label>
            <div class="form-input" style="background: var(--light);"><?php echo e($user->santo->no_hp ?? '-'); ?></div>
        </div>
        <div>
            <label class="form-label">Alamat</label>
            <div class="form-input" style="background: var(--light);"><?php echo e($user->santo->alamat ?? '-'); ?></div>
        </div>
        <div>
            <label class="form-label">Tanggal Lahir</label>
            <div class="form-input" style="background: var(--light);"><?php echo e($user->santo->tanggal_lahir?->format('d M Y') ?? '-'); ?></div>
        </div>
        <div>
            <label class="form-label">Status</label>
            <div class="form-input" style="background: var(--light);">
                <?php if($user->santo->status): ?>
                    <span class="badge badge-success">Aktif</span>
                <?php else: ?>
                    <span class="badge badge-danger">Tidak Aktif</span>
                <?php endif; ?>
            </div>
        </div>
        <div>
            <label class="form-label">Persentase Kehadiran</label>
            <div class="form-input" style="background: var(--light); font-weight: 600; color: var(--primary);"><?php echo e($user->santo->persentase_kehadiran ?? 0); ?>%</div>
        </div>
    </div>

    <div style="margin-top: 16px; display: flex; gap: 12px; flex-wrap: wrap;">
        <div class="stat-card" style="padding: 12px 20px; background: #d1fae5; border-radius: 10px;">
            <span style="font-size: 13px; color: #065f46; font-weight: 600;">Hadir: <?php echo e($user->santo->total_hadir); ?>x</span>
        </div>
        <div class="stat-card" style="padding: 12px 20px; background: #fef3c7; border-radius: 10px;">
            <span style="font-size: 13px; color: #92400e; font-weight: 600;">Izin: <?php echo e($user->santo->total_izin); ?>x</span>
        </div>
        <div class="stat-card" style="padding: 12px 20px; background: #dbeafe; border-radius: 10px;">
            <span style="font-size: 13px; color: #1e40af; font-weight: 600;">Sakit: <?php echo e($user->santo->total_sakit); ?>x</span>
        </div>
        <div class="stat-card" style="padding: 12px 20px; background: #fee2e2; border-radius: 10px;">
            <span style="font-size: 13px; color: #991b1b; font-weight: 600;">Alpha: <?php echo e($user->santo->total_alpha); ?>x</span>
        </div>
        <div class="stat-card" style="padding: 12px 20px; background: var(--light); border-radius: 10px; border: 1px solid var(--border);">
            <span style="font-size: 13px; color: var(--dark); font-weight: 600;">Total: <?php echo e($user->santo->total_pertemuan); ?>x</span>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- ==================== UBAH KATA SANDI ==================== -->
<?php if(auth()->guard()->check()): ?>
<div class="card" style="margin-top: 24px;">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-lock" style="color: var(--warning); margin-right: 8px;"></i>Ubah Kata Sandi
        </h3>
    </div>

    <?php if($user->must_change_password && $user->isAdmin()): ?>
    <p style="margin-bottom:12px; font-size:12px; color:var(--warning);">
        <i class="fas fa-info-circle"></i> Harap isi password baru setelah melakukan reset.
    </p>
    <?php endif; ?>

    <form method="post" action="<?php echo e(route('password.update')); ?>">
        <?php echo csrf_field(); ?>
        <?php echo method_field('put'); ?>

        <?php if(!($user->must_change_password && $user->isAdmin())): ?>
        <div class="form-group">
            <label class="form-label" for="current_password">Kata Sandi Saat Ini</label>
            <input type="password" id="current_password" name="current_password" class="form-input" required autocomplete="current-password">
            <?php $__errorArgs = ['current_password', 'updatePassword'];
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
        <?php endif; ?>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
            <div class="form-group">
                <label class="form-label" for="password">Kata Sandi Baru</label>
                <input type="password" id="password" name="password" class="form-input" required autocomplete="new-password">
            </div>
            <div class="form-group">
                <label class="form-label" for="password_confirmation">Konfirmasi Kata Sandi</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" required autocomplete="new-password">
            </div>
        </div>

            <button type="submit" class="btn btn-primary" style="margin-top: 8px;">
                <i class="fas fa-lock"></i>
                Simpan Kata Sandi
            </button>
    </form>
</div>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PROJEK BOSS\sistem-presensi\sistem-presensi\resources\views/profile/edit.blade.php ENDPATH**/ ?>