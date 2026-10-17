<?php
    $active = $jadwal['active'] ?? false;
    $nama = strtolower($jadwal['nama'] ?? '');
    $icon = 'fa-book';
    if(str_contains($nama, 'shalat') || str_contains($nama, 'sholat')) $icon = 'fa-mosque';
    elseif(str_contains($nama, 'quran') || str_contains($nama, 'tilawah') || str_contains($nama, 'tahfidz')) $icon = 'fa-book-quran';
    elseif(str_contains($nama, 'fiqih') || str_contains($nama, 'fikih')) $icon = 'fa-scale-balanced';
    elseif(str_contains($nama, 'hadits')) $icon = 'fa-scroll';
    elseif(str_contains($nama, 'tajwid')) $icon = 'fa-spell-check';
    elseif(str_contains($nama, 'akhlaq') || str_contains($nama, 'adab')) $icon = 'fa-heart-handshake';
?>

<div class="schedule-card-item <?php echo e($active ? 'active' : ''); ?>">
    <?php if($active): ?>
        <span style="background:#10b981; color:white; padding:2px 8px; border-radius:12px; font-size:0.7rem; margin-bottom:0.5rem; display:inline-block;">
            <i class="fas fa-circle" style="font-size:0.4rem;"></i> Sedang Berlangsung
        </span>
    <?php endif; ?>
    <div class="schedule-time"><?php echo e($jadwal['jam_mulai']); ?> - <?php echo e($jadwal['jam_selesai']); ?></div>
    <div class="schedule-name"><?php echo e($jadwal['nama']); ?></div>
    <?php if(!empty($jadwal['ustadz'])): ?>
        <div class="schedule-ustadz">
            <i class="fas fa-chalkboard-teacher"></i> <?php echo e($jadwal['ustadz']); ?>

        </div>
    <?php endif; ?>
</div><?php /**PATH D:\PROJEK BOSS\sistem-presensi\sistem-presensi\resources\views\components\schedule-card.blade.php ENDPATH**/ ?>