<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Rekap Presensi - <?php echo e($namaBulan); ?> <?php echo e($tahun); ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            padding: 20px;
            background: white;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #1e40af;
            padding-bottom: 10px;
        }
        .title {
            font-size: 20px;
            font-weight: 700;
            color: #1e40af;
            margin-bottom: 4px;
        }
        .subtitle {
            font-size: 14px;
            color: #64748b;
        }
        .info {
            margin-bottom: 20px;
            font-size: 13px;
            color: #475569;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }
        th, td {
            border: 1px solid #e2e8f0;
            padding: 8px;
            text-align: left;
        }
        th {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 10px;
        }
        td {
            background: white;
        }
        .rank-1 { color: #d97706; font-weight: 700; }
        .rank-2 { color: #6b7280; font-weight: 700; }
        .rank-3 { color: #b45309; font-weight: 700; }
        .text-center { text-align: center; }
        .badge {
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 600;
            display: inline-block;
        }
        .badge-success { background: #d1fae5; color: #065f46; }
        .badge-warning { background: #fef3c7; color: #92400e; }
        .badge-danger { background: #fee2e2; color: #991b1b; }
        .badge-info { background: #dbeafe; color: #1e40af; }
        .summary {
            margin-top: 20px;
            padding: 12px;
            background: #f8fafc;
            border-radius: 8px;
            font-size: 12px;
        }
        .summary-item {
            display: inline-block;
            margin-right: 20px;
            margin-bottom: 5px;
        }
        .footer {
            margin-top: 30px;
            font-size: 11px;
            color: #94a3b8;
            text-align: right;
        }
        @media print {
            body { padding: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">REKAP PRESENSI SANTRI</div>
        <div class="subtitle">Madrasah Diniyah Salafiyah Al Asy'ariyyah</div>
    </div>

    <div class="info">
        <strong>Bulan:</strong> <?php echo e($namaBulan); ?> <?php echo e($tahun); ?> &nbsp;&nbsp;
        <strong>Total Pertemuan:</strong> <?php echo e($totalPertemuan); ?>

    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center">#</th>
                <th>Nama Santri</th>
                <th class="text-center">Hadir</th>
                <th class="text-center">Izin</th>
                <th class="text-center">Sakit</th>
                <th class="text-center">Alpha</th>
                <th class="text-center">Total</th>
                <th class="text-center">%</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $rekapData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td class="text-center">
                    <?php if($index + 1 == 1): ?>
                        <span class="badge badge-warning">🥇</span>
                    <?php elseif($index + 1 == 2): ?>
                        <span class="badge" style="background:#e5e7eb;color:#374151;">🥈</span>
                    <?php elseif($index + 1 == 3): ?>
                        <span class="badge" style="background:#d97706;color:#fff;">🥉</span>
                    <?php else: ?>
                        <?php echo e($index + 1); ?>

                    <?php endif; ?>
                </td>
                <td><?php echo e($item['santri']->nama); ?></td>
                <td class="text-center"><span class="badge badge-success"><?php echo e($item['hadir']); ?></span></td>
                <td class="text-center"><span class="badge badge-warning"><?php echo e($item['izin']); ?></span></td>
                <td class="text-center"><span class="badge badge-info"><?php echo e($item['sakit']); ?></span></td>
                <td class="text-center"><span class="badge badge-danger"><?php echo e($item['alpha']); ?></span></td>
                <td class="text-center"><strong><?php echo e($item['total']); ?></strong></td>
                <td class="text-center"><?php echo e($item['persentase']); ?>%</td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

    <div class="summary">
        <strong>Ringkasan:</strong>
        <span class="summary-item">Total Hadir: <?php echo e($totalHadir); ?></span>
        <span class="summary-item">Total Izin: <?php echo e($totalIzin); ?></span>
        <span class="summary-item">Total Sakit: <?php echo e($totalSakit); ?></span>
        <span class="summary-item">Total Alpha: <?php echo e($totalAlpha); ?></span>
    </div>

    <div class="footer">
        Dicetak pada: <?php echo e(\Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY, HH:mm')); ?>

    </div>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
<?php /**PATH D:\PROJEK BOSS\sistem-presensi\sistem-presensi\resources\views\rekap\print-presensi.blade.php ENDPATH**/ ?>