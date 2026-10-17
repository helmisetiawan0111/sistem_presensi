<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Ranking Kehadiran Santri</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 12px; text-align: center; }
        th { background-color: #f59e0b; color: white; }
        tr:nth-child(even) { background-color: #fef3c7; }
        .header { text-align: center; }
        .title { font-size: 20px; font-weight: bold; }
        .subtitle { font-size: 14px; color: #666; }
        .rank-1 { background-color: #fbbf24 !important; font-weight: bold; }
        .rank-2 { background-color: #d1d5db !important; }
        .rank-3 { background-color: #cd7f32 !important; color: white; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">RANKING KEHADIRAN SANTRI</div>
        <div class="subtitle">Bulan: <?php echo e($namaBulan ?? 'Sekarang'); ?> <?php echo e($tahun ?? date('Y')); ?></div>
        <div>Madrasah Diniyah Al Asy'ariyyah</div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Peringkat</th>
                <th>Nama Santri</th>
                <th>Jumlah Hadir</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $ranking; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr class="rank-<?php echo e($index + 1); ?>">
                <td>
                    <?php if($index == 0): ?> 1
                    <?php elseif($index == 1): ?> 2
                    <?php elseif($index == 2): ?> 3
                    <?php else: ?> <?php echo e($index + 1); ?>

                    <?php endif; ?>
                </td>
                <td style="text-align: left;"><?php echo e($r->santri->nama ?? 'Unknown'); ?></td>
                <td><strong><?php echo e($r->hadir_count); ?>x</strong></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</body>
</html><?php /**PATH D:\PROJEK BOSS\sistem-presensi\sistem-presensi\resources\views/laporan/pdf-ranking.blade.php ENDPATH**/ ?>