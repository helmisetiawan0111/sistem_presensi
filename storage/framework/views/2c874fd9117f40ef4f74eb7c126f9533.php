<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Denda - <?php echo e($namaBulan); ?> <?php echo e($tahun); ?></title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
        th { background-color: #f0f0f0; }
        .header { text-align: center; margin-bottom: 20px; }
        .title { font-size: 18px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">LAPORAN DENDA</div>
        <div>Bulan: <?php echo e($namaBulan); ?> <?php echo e($tahun); ?></div>
        <div> Madrasah Diniyah Salafiyah PPTQ Al-Asy'ariyyah Pusat</div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Santri</th>
                <th>Izin</th>
                <th>Sakit</th>
                <th>Alpha</th>
                <th>Total Denda</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($index + 1); ?></td>
                <td><?php echo e($d['santri']->nama); ?></td>
                <td><?php echo e($d['izin']); ?></td>
                <td><?php echo e($d['sakit']); ?></td>
                <td><?php echo e($d['alpha']); ?></td>
                <td>Rp <?php echo e(number_format($d['denda'], 0, ',', '.')); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    
    <div style="margin-top: 20px;">
        <p><strong>Total Denda Bulan Ini: Rp <?php echo e(number_format($totalDenda, 0, ',', '.')); ?></strong></p>
    </div>
</body>
</html><?php /**PATH D:\PROJEK BOSS\sistem-presensi\sistem-presensi\resources\views/laporan/pdf-denda.blade.php ENDPATH**/ ?>