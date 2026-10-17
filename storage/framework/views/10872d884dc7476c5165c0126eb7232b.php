<?php $__env->startSection('title', 'Rekap Denda Saya'); ?>

<?php $__env->startPush('styles'); ?>
<style>
.total-card {
    background: linear-gradient(135deg, #d97706 0%, #f59e0b 100%);
    color: white;
    border-radius: 16px;
    padding: 1.5rem;
    text-align: center;
    margin-bottom: 1.5rem;
}

.total-card .amount {
    font-size: 2rem;
    font-weight: 700;
}

.total-card .label {
    font-size: 0.85rem;
    opacity: 0.9;
}

.stat-card-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.stat-card {
    background: #f8fafc;
    border-radius: 12px;
    padding: 1rem;
    text-align: center;
    border: 1px solid #e2e8f0;
    transition: all 0.25s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.06);
}

.stat-card .icon {
    font-size: 1.25rem;
    margin-bottom: 0.5rem;
}

.stat-card .icon.text-warning { color: #f59e0b; }
.stat-card .icon.text-danger { color: #ef4444; }
.stat-card .icon.text-info { color: #0891b2; }

.stat-card .number {
    font-size: 1rem;
    font-weight: 600;
    color: #1e293b;
}

.stat-card .label {
    font-size: 0.75rem;
    color: #64748b;
}

.denda-table th {
    background: #f8fafc;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
}

.denda-table td {
    font-size: 0.85rem;
}

.table-row-header {
    font-weight: 500;
}

.table-row-subtext {
    font-size: 0.75rem;
    color: #64748b;
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <!-- Total Denda Card -->
    <div class="total-card">
        <div class="label">Total Denda Keseluruhan</div>
        <div class="amount">Rp <?php echo e(number_format($totalDenda, 0, ',', '.')); ?></div>
    </div>

    <!-- Statistik Kecil -->
    <div class="stat-card-grid">
        <div class="stat-card">
            <div class="icon text-warning"><i class="fas fa-calendar-alt"></i></div>
            <div class="number">Rp <?php echo e(number_format($totalDendaBulan, 0, ',', '.')); ?></div>
            <div class="label">Bulan Ini</div>
        </div>
        <div class="stat-card">
            <div class="icon text-danger"><i class="fas fa-times-circle"></i></div>
            <div class="number"><?php echo e($jumlahAlpha); ?></div>
            <div class="label">Alpha</div>
        </div>
        <div class="stat-card">
            <div class="icon text-warning"><i class="fas fa-clipboard-check"></i></div>
            <div class="number"><?php echo e($jumlahIzin); ?></div>
            <div class="label">Izin</div>
        </div>
        <div class="stat-card">
            <div class="icon text-info"><i class="fas fa-notes-medical"></i></div>
            <div class="number"><?php echo e($jumlahSakit); ?></div>
            <div class="label">Sakit</div>
        </div>
    </div>

    <div class="section-card">
        <h5 class="mb-3"><i class="fas fa-history"></i> Riwayat Denda</h5>

        <!-- Filter -->
        <form method="GET" action="<?php echo e(route('santri.fine')); ?>">
            <div class="row g-2">
                <div class="col-md-2 col-6">
                    <label class="form-label">Bulan</label>
                    <select name="bulan" class="form-select">
                        <option value="">Semua Bulan</option>
                        <?php $__currentLoopData = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($value); ?>" <?php echo e(request()->input('bulan') == $value ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-2 col-6">
                    <label class="form-label">Tahun</label>
                    <select name="tahun" class="form-select">
                        <option value="">Semua Tahun</option>
                        <?php $currentYear = \Carbon\Carbon::now()->year; ?>
                        <?php for($y = $currentYear - 2; $y <= $currentYear + 1; $y++): ?>
                            <option value="<?php echo e($y); ?>" <?php echo e(request()->input('tahun') == $y ? 'selected' : ''); ?>><?php echo e($y); ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>
            <div class="row g-2 mt-3">
                <div class="col-auto d-grid">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter"></i> <span class="d-none d-sm-inline">Filter</span>
                    </button>
                </div>
                <div class="col-auto d-grid">
                    <a href="<?php echo e(route('santri.fine')); ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-undo"></i> <span class="d-none d-sm-inline">Reset</span>
                    </a>
                </div>
            </div>
        </form>

        <!-- Tabel Riwayat Denda -->
        <?php if($absensi->isEmpty()): ?>
            <div class="empty-state">
                <div class="empty-icon"><i class="fas fa-folder-open"></i></div>
                <p class="empty-text">Tidak ada data denda untuk filter yang dipilih.</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="data-table denda-table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Nominal Denda</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $absensi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <div class="table-row-header"><?php echo e(\Carbon\Carbon::parse($row->tanggal)->format('d M Y')); ?></div>
                                    <div class="table-row-subtext"><?php echo e(\Carbon\Carbon::parse($row->tanggal)->locale('id')->dayName); ?></div>
                                </td>
                                <td>
                                    <span class="badge-status <?php echo e($row->status); ?>">
                                        <?php echo e(ucfirst($row->status)); ?>

                                    </span>
                                </td>
                                <td>
                                    <div style="font-weight:600; color:#1e293b;">
                                        <?php if($row->denda > 0): ?>
                                            Rp <?php echo e(number_format($row->denda, 0, ',', '.')); ?>

                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td><?php echo e($row->keterangan ?? '-'); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            <div class="pagination">
                <?php echo e($absensi->links()); ?>

            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PROJEK BOSS\sistem-presensi\sistem-presensi\resources\views\santri\fine.blade.php ENDPATH**/ ?>