<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Lengkap Absensi - <?php echo e($namaBulan); ?> <?php echo e($tahun); ?></title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; }
        .header { text-align: center; margin-bottom: 20px; }
        .title { font-size: 18px; font-weight: bold; }
        .subtitle { font-size: 12px; color: #666; }
        h2 { font-size: 14px; margin-top: 30px; background: #4a90d9; color: white; padding: 8px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: center; }
        th { background-color: #4a90d9; color: white; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .summary { margin-top: 20px; padding: 10px; background: #f0f0f0; border-radius: 5px; }
        .footer { margin-top: 30px; text-align: right; font-size: 10px; }
        .page-break { page-break-after: always; }
        .rank-1 { background-color: #fbbf24 !important; font-weight: bold; }
        .rank-2 { background-color: #d1d5db !important; }
        .rank-3 { background-color: #cd7f32 !important; color: white; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">LAPORAN LENGKAP PRESENSI SANTRI</div>
        <div class="subtitle">Bulan: <?php echo e($namaBulan); ?> <?php echo e($tahun); ?></div>
        <div>Madrasah Diniyah Salafiyah PPTQ Al-Asy'ariyyah Pusat</div>
    </div>

    <!-- Bagian 1: Rekap Absensi Santri -->
    <h2>REKAP PRESENSI SANTRI</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Santri</th>
                <th>Khalaqoh</th>
                <th>Hadir</th>
                <th>Izin</th>
                <th>Sakit</th>
                <th>Alpha</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($index + 1); ?></td>
                <td style="text-align: left;"><?php echo e($d['santri']->nama); ?></td>
                <td><?php echo e($d['santri']->jenjang); ?></td>
                <td><?php echo e($d['hadir']); ?></td>
                <td><?php echo e($d['izin']); ?></td>
                <td><?php echo e($d['sakit']); ?></td>
                <td><?php echo e($d['alpha']); ?></td>
                <td><?php echo e($d['total']); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

    <div class="summary">
        <strong>Ringkasan <?php echo e($namaBulan); ?> <?php echo e($tahun); ?>:</strong>
        <table style="border: none; margin-top: 10px;">
            <tr>
                <td style="border: none;">Total Hadir:</td>
                <td style="border: none;"><strong><?php echo e($totalHadir); ?></strong></td>
                <td style="border: none;">Total Izin:</td>
                <td style="border: none;"><strong><?php echo e($totalIzin); ?></strong></td>
                <td style="border: none;">Total Sakit:</td>
                <td style="border: none;"><strong><?php echo e($totalSakit); ?></strong></td>
                <td style="border: none;">Total Alpha:</td>
                <td style="border: none;"><strong><?php echo e($totalAlpha); ?></strong></td>
            </tr>
        </table>
    </div>

    <!-- Bagian 2: Rekap Denda -->
    <h2>REKAP DENDA</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Santri</th>
                <th>Izin (Rp2.000)</th>
                <th>Sakit (Rp2.000)</th>
                <th>Alpha (Rp5.000)</th>
                <th>Total Denda</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($d['denda'] > 0): ?>
            <tr>
                <td><?php echo e($index + 1); ?></td>
                <td style="text-align: left;"><?php echo e($d['santri']->nama); ?></td>
                <td><?php echo e($d['izin'] * 2000); ?></td>
                <td><?php echo e($d['sakit'] * 2000); ?></td>
                <td><?php echo e($d['alpha'] * 5000); ?></td>
                <td>Rp <?php echo e(number_format($d['denda'], 0, ',', '.')); ?></td>
            </tr>
            <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <div class="summary">
        <strong>Total Denda Bulan Ini: Rp <?php echo e(number_format($totalDenda, 0, ',', '.')); ?></strong>
    </div>

    <!-- Bagian 3: Ranking -->
    <h2>RANKING KEHADIRAN TERBAIK</h2>
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
                    <?php if($index == 0): ?>                     1
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

    <div class="footer">
        Dicetak pada: <?php echo e($printedAt); ?>

    </div>
</body>
</html><?php /**PATH D:\PROJEK BOSS\sistem-presensi\sistem-presensi\resources\views/laporan/pdf-complete.blade.php ENDPATH**/ ?>