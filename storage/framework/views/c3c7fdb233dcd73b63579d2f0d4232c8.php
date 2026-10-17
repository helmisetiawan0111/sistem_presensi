<?php
    // Map icon class to stat-icon color class
    $colorMap = [
        'bg-success-soft' => 'green',
        'bg-danger-soft' => 'red',
        'bg-permission-soft' => 'yellow',
        'bg-sickness-soft' => 'blue',
        'bg-info-soft' => 'blue',
        'bg-warning-soft' => 'yellow',
    ];
    $statIconColor = $colorMap[$iconClass] ?? 'blue';
?>
<div class="stat-card">
    <div class="stat-icon stat-icon-<?php echo e($statIconColor); ?>">
        <i class="<?php echo e($icon); ?>"></i>
    </div>
    <div class="stat-content">
        <h3><?php echo e($number); ?></h3>
        <p><?php echo e($label); ?></p>
    </div>
</div><?php /**PATH D:\PROJEK BOSS\sistem-presensi\sistem-presensi\resources\views\components\stat-card.blade.php ENDPATH**/ ?>