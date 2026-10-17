<?php $__env->startSection('title', 'Kelola Pengguna'); ?>

<?php $__env->startSection('content'); ?>
<div class="section-card">
    <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.25rem;">
        <i class="fas fa-users-cog" style="color: var(--primary); font-size: 1.1rem;"></i>
        <h5 style="margin: 0; font-weight: 600;">Kelola Pengguna</h5>
    </div>

    <div class="row g-3 mb-3 align-items-center">
        <div class="col-md-12">
            <form method="GET" action="<?php echo e(route('users.index')); ?>" class="d-flex gap-2">
                <input type="text" name="search" class="form-input" placeholder="Cari nama, NIS, username..." value="<?php echo e(request('search')); ?>" style="max-width: 320px; flex: 0 0 auto;">
                <input type="hidden" name="role" value="<?php echo e(request('role')); ?>">
                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
            </form>
        </div>
        <div class="col-md-12">
            <select name="role" class="form-select" onchange="syncFilter(this.value)" style="max-width: 320px;">
                <option value="">Semua Role</option>
                <option value="admin" <?php echo e(request('role') == 'admin' ? 'selected' : ''); ?>>Admin</option>
                <option value="petugas" <?php echo e(request('role') == 'petugas' ? 'selected' : ''); ?>>Petugas</option>
                <option value="santri" <?php echo e(request('role') == 'santri' ? 'selected' : ''); ?>>Santri</option>
            </select>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
    <script>
    function syncFilter(role) {
        const params = new URLSearchParams(window.location.search);
        if (role) params.set('role', role); else params.delete('role');
        window.location.search = params.toString();
    }
    </script>
    <?php $__env->stopPush(); ?>

    <?php if(session('success')): ?>
        <div class="alert alert-success"><i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> <?php echo e(session('error')); ?></div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Username / NIS</th>
                    <th>Role</th>
                    <th>Santri Terhubung</th>
                    <th style="width: 140px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $displayIdentifier = $user->nis ?? $user->username;
                    if (!$displayIdentifier || trim($displayIdentifier) === '') continue;
                ?>
                <tr>
                    <td>
                        <div style="font-weight: 600;"><?php echo e($user->name); ?></div>
                        <?php if($user->email): ?>
                        <small style="color: var(--gray);"><?php echo e($user->email); ?></small>
                        <?php endif; ?>
                    </td>
                    <td><?php echo e($displayIdentifier); ?></td>
                    <td>
                        <span class="badge <?php echo e($user->role === 'admin' ? 'badge-danger' : ($user->role === 'petugas' ? 'badge-warning' : 'badge-info')); ?>">
                            <?php echo e(ucfirst($user->role)); ?>

                        </span>
                    </td>
                    <td>
                        <?php if($user->santo): ?>
                            <span style="color: #059669;"><i class="fas fa-check-circle"></i> <?php echo e($user->santo->nama); ?></span>
                        <?php else: ?>
                            <span style="color: var(--gray);">-</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <form action="<?php echo e(route('users.reset-password', $user->id)); ?>" method="POST" style="display:inline;">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-warning btn-sm" onclick="return confirm('Reset password <?php echo e($user->name); ?> ke <?php echo e($displayIdentifier); ?>?')">
                                <i class="fas fa-key"></i> Reset
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" style="text-align: center; padding: 2rem; color: var(--gray);">
                        <i class="fas fa-users" style="font-size: 2rem; display: block; margin-bottom: 0.5rem; opacity: 0.5;"></i>
                        Tidak ada data pengguna.
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if($users->hasPages()): ?>
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-top: 20px;">
        <div style="color: var(--secondary); font-size: 13px;">
            Menampilkan <?php echo e($users->firstItem() ?? 0); ?> - <?php echo e($users->lastItem() ?? 0); ?> dari <?php echo e($users->total()); ?> data
        </div>
        <div class="pagination" style="display: flex; gap: 4px; align-items: center; flex-wrap: wrap;">
            <button type="button" class="btn btn-sm btn-secondary" 
                    style="cursor: pointer; opacity: <?php echo e($users->onFirstPage() ? '0.4' : '1'); ?>; pointer-events: <?php echo e($users->onFirstPage() ? 'none' : 'auto'); ?>;"
                    onclick="changeUserPage(<?php echo e($users->currentPage() - 1); ?>)">
                <i class="fas fa-chevron-left"></i> Sebelumnya
            </button>

            <?php for($i = 1; $i <= $users->lastPage(); $i++): ?>
                <a href="javascript:void(0)" 
                   onclick="changeUserPage(<?php echo e($i); ?>)"
                   style="display: flex; align-items: center; justify-content: center; width: 36px; height: 36px; border-radius: 10px; font-size: 13px; font-weight: 600; text-decoration: none; border: 1px solid var(--border); color: var(--dark); background: var(--white); transition: all 0.2s; cursor: pointer; <?php echo e($i === $users->currentPage() ? 'background: var(--primary); color: white; border-color: var(--primary);' : ''); ?> <?php echo e($i !== $users->currentPage() ? 'cursor: pointer;' : ''); ?>"
                ><?php echo e($i); ?></a>
            <?php endfor; ?>

            <button type="button" class="btn btn-sm btn-secondary" 
                    style="cursor: pointer; opacity: <?php echo e($users->hasMorePages() ? '1' : '0.4'); ?>; pointer-events: <?php echo e($users->hasMorePages() ? 'auto' : 'none'); ?>;"
                    onclick="changeUserPage(<?php echo e($users->currentPage() + 1); ?>)">
                Berikutnya <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>

    <form id="userPaginationForm" action="<?php echo e(route('users.index')); ?>" method="GET">
        <input type="hidden" name="page" id="userPageInput">
        <input type="hidden" name="search" value="<?php echo e(request('search')); ?>">
        <input type="hidden" name="role" value="<?php echo e(request('role')); ?>">
    </form>

    <script>
        function changeUserPage(page) {
            document.getElementById('userPageInput').value = page;
            document.getElementById('userPaginationForm').submit();
        }
    </script>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PROJEK BOSS\sistem-presensi\sistem-presensi\resources\views\admin\users\index.blade.php ENDPATH**/ ?>