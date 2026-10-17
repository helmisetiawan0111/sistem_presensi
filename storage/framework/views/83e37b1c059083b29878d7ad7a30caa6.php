<?php $__env->startSection('title', 'Jadwal Pelajaran'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <!-- Header -->
    <div class="card-header">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
            <div>
                <h3 class="card-title" style="margin-bottom: 4px;">
                    <i class="fas fa-calendar-alt"></i> Jadwal Pelajaran
                </h3>
                <p style="font-size: 12px; color: #64748b; margin: 0;">
                    <i class="fas fa-graduation-cap"></i> 
                    <strong>Safinatunnajah</strong> (Kelas 1) & 
                    <strong>Muqodimah</strong> (Kelas 2)
                </p>
            </div>
            <a href="<?php echo e(route('jam-pelajaran.create')); ?>" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Jadwal
            </a>
        </div>
    </div>

    <!-- Filter -->
    <div style="padding: 20px; background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
        <form action="<?php echo e(route('jam-pelajaran.index')); ?>" method="GET" style="display: flex; gap: 12px; align-items: flex-end; flex-wrap: wrap;">
            <div style="min-width: 180px;">
                <label class="form-label">Filter Hari</label>
                <select name="hari" class="form-select" onchange="this.form.submit()">
                    <option value="">Semua Hari</option>
                    <?php $__currentLoopData = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($h); ?>" <?php echo e(request('hari') == $h ? 'selected' : ''); ?>><?php echo e($h); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <?php if(request('hari')): ?>
            <div>
                <a href="<?php echo e(route('jam-pelajaran.index')); ?>" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Reset
                </a>
            </div>
            <?php endif; ?>
        </form>
    </div>

    <?php if($jamPelajaran->count() > 0): ?>
        <?php
            $grouped = $jamPelajaran->groupBy('hari');
            $hariOrder = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'];
            $grouped = $grouped->sortBy(function($items, $key) use ($hariOrder) {
                return array_search($key, $hariOrder);
            });
        ?>

        <?php $__currentLoopData = $grouped; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hari => $jamsByHari): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $byKelas = $jamsByHari->groupBy('kelas');
                // Ensure order: Safinatunnajah first, then Muqodimah
                $orderedKelas = ['Safinatunnajah', 'Muqodimah'];
                $byKelas = $byKelas->sortBy(function($items, $key) use ($orderedKelas) {
                    return array_search($key, $orderedKelas);
                });
            ?>

            <?php $__currentLoopData = $byKelas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kelas => $jams): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    if(is_null($kelas)) continue;
                    
                    $gradients = [
                        'Safinatunnajah' => 'linear-gradient(135deg, #059669 0%, #10b981 100%)',
                        'Muqodimah' => 'linear-gradient(135deg, #2563eb 0%, #3b82f6 100%)',
                    ];
                    $badgeColors = [
                        'Safinatunnajah' => 'badge-success',
                        'Muqodimah' => 'badge-info',
                    ];
                    $iconColor = $kelas == 'Safinatunnajah' ? '#10b981' : '#3b82f6';
                    $bgGradient = $gradients[$kelas] ?? $gradients['Safinatunnajah'];
                    $badgeClass = $badgeColors[$kelas] ?? 'badge-success';
                ?>

                <div style="margin-bottom: 24px;">
                    <!-- Header Hari + Kelas -->
                    <div style="background: <?php echo e($bgGradient); ?>; color: white; padding: 12px 20px; border-radius: 10px; margin-bottom: 12px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <i class="fas fa-calendar-day" style="font-size: 20px;"></i>
                            <div>
                                <span style="font-size: 18px; font-weight: 700;"><?php echo e($hari); ?></span>
                                <span style="font-size: 13px; background: rgba(255,255,255,0.25); padding: 4px 12px; border-radius: 20px; margin-left: 10px; font-weight: 600;">
                                    <?php echo e($kelas); ?>

                                </span>
                            </div>
                        </div>
                        <span style="font-size: 13px; background: rgba(255,255,255,0.2); padding: 6px 14px; border-radius: 20px; font-weight: 600;">
                            <?php echo e($jams->count()); ?> jam
                        </span>
                    </div>

                    <!-- Cards Grid -->
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 16px;">
                        <?php $__currentLoopData = $jams->sortBy('urutan'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jam): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div style="background: white; border: 1px solid #e2e8f0; border-radius: 10px; padding: 18px; transition: all 0.2s ease; box-shadow: 0 2px 4px rgba(0,0,0,0.04);"
                                 onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 16px rgba(0,0,0,0.1)';"
                                 onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0,0,0,0.04)';">
                                <!-- Header Card -->
                                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 14px;">
                                    <div>
                                        <div style="font-weight: 700; font-size: 16px; color: #1e293b; margin-bottom: 6px;">
                                            <?php echo e($jam->nama); ?>

                                        </div>
<div style="font-size: 13px; color: #64748b; display: flex; align-items: center; gap: 6px;">
    <i class="fas fa-clock" style="color: #3b82f6;"></i>
    <span><?php echo e(\Carbon\Carbon::parse($jam->jam_mulai)->format('H:i')); ?> - <?php echo e(\Carbon\Carbon::parse($jam->jam_selesai)->format('H:i')); ?></span>
</div>
                                    </div>
                                    <span class="badge <?php echo e($badgeClass); ?>" style="font-size: 11px; padding: 6px 12px;">
                                        <?php echo e($jam->status ? 'Aktif' : 'Nonaktif'); ?>

                                    </span>
                                </div>

                                <!-- Ustadz -->
                                <div style="display: flex; align-items: center; gap: 10px; font-size: 14px; color: #475569; margin-bottom: 16px; padding: 10px; background: #f8fafc; border-radius: 6px;">
                                    <i class="fas fa-user-tie" style="color: <?php echo e($iconColor); ?>; font-size: 16px;"></i>
                                    <span style="font-weight: 600;"><?php echo e($jam->ustadz); ?></span>
                                </div>

                                <!-- Actions -->
                                <div style="display: flex; justify-content: flex-end; gap: 8px; border-top: 1px solid #f1f5f9; padding-top: 12px;">
                                    <a href="<?php echo e(route('jam-pelajaran.edit', $jam->id)); ?>" class="btn btn-sm btn-secondary">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="<?php echo e(route('jam-pelajaran.destroy', $jam->id)); ?>" method="POST" style="display: inline;">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus jadwal ini?')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php else: ?>
    <div class="empty-state">
        <i class="fas fa-calendar-times" style="font-size: 72px; color: #cbd5e1; margin-bottom: 20px;"></i>
        <h3 style="color: #64748b; font-weight: 600;">Belum Ada Jadwal</h3>
        <p style="color: #94a3b8;">Silakan tambah jadwal pelajaran untuk mengatur waktu mengajar.</p>
        <a href="<?php echo e(route('jam-pelajaran.create')); ?>" class="btn btn-primary" style="margin-top: 24px;">
            <i class="fas fa-plus"></i> Tambah Jadwal Pertama
        </a>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PROJEK BOSS\sistem-presensi\sistem-presensi\resources\views\jam-pelajaran\index.blade.php ENDPATH**/ ?>