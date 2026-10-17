<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Rekap Absensi Santri - <?php echo e($namaBulan); ?> <?php echo e($tahun); ?></title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: center; }
        th { background-color: #4a90d9; color: white; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .header { text-align: center; }
        .title { font-size: 20px; font-weight: bold; }
        .subtitle { font-size: 14px; color: #666; }
        .summary { margin-top: 20px; padding: 10px; background: #f0f0f0; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">REKAP PRESENSI SANTRI</div>
        <div class="subtitle">Bulan: <?php echo e($namaBulan); ?> <?php echo e($tahun); ?></div>
        <div>Madrasah Diniyah Salafiyah PPTQ Al-Asy'ariyyah Pusat</div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Santri</th>
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
        <strong>Ringkasan Bulan <?php echo e($namaBulan); ?> <?php echo e($tahun); ?>:</strong>
        <table style="margin-top: 10px; border: none;">
            <tr>
                <td style="border: none; text-align: right;">Total Hadir:</td>
                <td style="border: none; text-align: left;"><strong><?php echo e($totalHadir); ?></strong></td>
            </tr>
            <tr>
                <td style="border: none; text-align: right;">Total Izin:</td>
                <td style="border: none; text-align: left;"><strong><?php echo e($totalIzin); ?></strong></td>
            </tr>
            <tr>
                <td style="border: none; text-align: right;">Total Sakit:</td>
                <td style="border: none; text-align: left;"><strong><?php echo e($totalSakit); ?></strong></td>
            </tr>
            <tr>
                <td style="border: none; text-align: right;">Total Alpha:</td>
                <td style="border: none; text-align: left;"><strong><?php echo e($totalAlpha); ?></strong></td>
            </tr>
        </table>
    </div>
</body>
</html><?php /**PATH D:\PROJEK BOSS\sistem-presensi\sistem-presensi\resources\views\laporan\pdf-rekap.blade.php ENDPATH**/ ?>