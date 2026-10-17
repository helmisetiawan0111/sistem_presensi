<?php $__env->startSection('title', 'Dashboard Petugas'); ?>

<?php $__env->startSection('content'); ?>
<!-- Ringkasan Presensi Hari Ini -->
<div class="stats-grid" style="margin-bottom: 2rem; gap: 1.25rem;">
    <div class="stat-card" style="background: white; border-radius: 16px; padding: 1.5rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03); transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); border: 1px solid #f0f0f0; position: relative; overflow: hidden;">
        <div class="stat-icon blue" style="position: absolute; top: -10px; right: -10px; width: 80px; height: 80px; background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(59, 130, 246, 0.05) 100%); border-radius: 50%; opacity: 0.5;"></div>
        <div class="stat-content" style="position: relative; z-index: 1;">
            <h3 style="font-size: 36px; font-weight: 900; line-height: 1; margin: 0 0 8px 0; letter-spacing: -0.04em; background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; text-shadow: 0 2px 4px rgba(30, 64, 175, 0.1);"><?php echo e($totalSantri); ?></h3>
            <p style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: #64748b; margin: 0; line-height: 1.4;">Total Santri Harian</p>
        </div>
    </div>
    
    <div class="stat-card" style="background: white; border-radius: 16px; padding: 1.5rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03); transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); border: 1px solid #f0f0f0; position: relative; overflow: hidden;">
        <div class="stat-icon green" style="position: absolute; top: -10px; right: -10px; width: 80px; height: 80px; background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(16, 185, 129, 0.05) 100%); border-radius: 50%; opacity: 0.5;"></div>
        <div class="stat-content" style="position: relative; z-index: 1;">
            <h3 style="font-size: 36px; font-weight: 900; line-height: 1; margin: 0 0 8px 0; letter-spacing: -0.04em; background: linear-gradient(135deg, #047857 0%, #10b981 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; text-shadow: 0 2px 4px rgba(4, 120, 87, 0.1);"><?php echo e($totalHadir); ?></h3>
            <p style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: #64748b; margin: 0; line-height: 1.4;">Sudah Presensi</p>
        </div>
    </div>
    
    <div class="stat-card" style="background: white; border-radius: 16px; padding: 1.5rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03); transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); border: 1px solid #f0f0f0; position: relative; overflow: hidden;">
        <div class="stat-icon yellow" style="position: absolute; top: -10px; right: -10px; width: 80px; height: 80px; background: linear-gradient(135deg, rgba(245, 158, 11, 0.1) 0%, rgba(245, 158, 11, 0.05) 100%); border-radius: 50%; opacity: 0.5;"></div>
        <div class="stat-content" style="position: relative; z-index: 1;">
            <h3 style="font-size: 36px; font-weight: 900; line-height: 1; margin: 0 0 8px 0; letter-spacing: -0.04em; background: linear-gradient(135deg, #92400e 0%, #f59e0b 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; text-shadow: 0 2px 4px rgba(146, 64, 14, 0.1);"><?php echo e($totalBelum); ?></h3>
            <p style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: #64748b; margin: 0; line-height: 1.4;">Belum Presensi</p>
        </div>
    </div>
    
    <div class="stat-card" style="background: white; border-radius: 16px; padding: 1.5rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03); transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); border: 1px solid #f0f0f0; position: relative; overflow: hidden;">
        <div class="stat-icon <?php echo e($persentase >= 80 ? 'green' : ($persentase >= 60 ? 'yellow' : 'red')); ?>" style="position: absolute; top: -10px; right: -10px; width: 80px; height: 80px; background: linear-gradient(135deg, <?php echo e($persentase >= 80 ? 'rgba(16, 185, 129, 0.1)' : ($persentase >= 60 ? 'rgba(245, 158, 11, 0.1)' : 'rgba(239, 68, 68, 0.1)')); ?> 0%, <?php echo e($persentase >= 80 ? 'rgba(16, 185, 129, 0.05)' : ($persentase >= 60 ? 'rgba(245, 158, 11, 0.05)' : 'rgba(239, 68, 68, 0.05)')); ?> 100%); border-radius: 50%; opacity: 0.5;"></div>
        <div class="stat-content" style="position: relative; z-index: 1;">
            <h3 style="font-size: 36px; font-weight: 900; line-height: 1; margin: 0 0 8px 0; letter-spacing: -0.04em; background: <?php echo e($persentase >= 80 ? 'linear-gradient(135deg, #047857 0%, #10b981 100%)' : ($persentase >= 60 ? 'linear-gradient(135deg, #92400e 0%, #f59e0b 100%)' : 'linear-gradient(135deg, #991b1b 0%, #ef4444 100%)')); ?>; -webkit-background-clip: text; -webkit-text-fill-color: transparent; text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);"><?php echo e($persentase); ?>%</h3>
            <p style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: #64748b; margin: 0; line-height: 1.4;">Kelengkapan Presensi</p>
        </div>
    </div>
</div>

<style>
@keyframes pulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.6; transform: scale(0.9); }
}
</style>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 1.5rem; margin-bottom: 1.5rem;">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-layer-group"></i>
                Statistik per Jenjang
            </h3>
        </div>
        <div class="card-body">
            <?php $__currentLoopData = $statistikJenjang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jenjang => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div style="margin-bottom: 1.5rem; padding: 1.25rem; background: <?php echo e($jenjang == 'Safinatunnajah' ? '#f0f9ff' : '#f0fdf4'); ?>; border-radius: 12px; border-left: 4px solid <?php echo e($jenjang == 'Safinatunnajah' ? '#3b82f6' : '#10b981'); ?>; transition: all 0.2s ease;" 
                 onmouseover="this.style.transform='translateX(4px)'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.05)';" 
                 onmouseout="this.style.transform='translateX(0)'; this.style.boxShadow='none';">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.75rem;">
                    <h4 style="margin: 0; font-size: 15px; font-weight: 800; color: #111827; letter-spacing: -0.025em;">
                        <?php echo e($jenjang); ?>

                    </h4>
                    <span class="badge" style="background: <?php echo e($data['persentase'] >= 90 ? '#10b981' : ($data['persentase'] >= 70 ? '#f59e0b' : '#ef4444')); ?>; color: white; font-weight: 700; padding: 6px 14px; border-radius: 9999px; font-size: 12px;">
                        <?php echo e($data['persentase']); ?>%
                    </span>
                </div>
                <div style="display: flex; gap: 1.5rem; font-size: 13px; color: #64748b; margin-bottom: 0.75rem;">
                    <span>Total: <strong style="color: #1f2937;"><?php echo e($data['total']); ?></strong> santri</span>
                    <span>Hadir: <strong style="color: #10b981;"><?php echo e($data['hadir']); ?></strong></span>
                    <span>Belum: <strong style="color: #ef4444;"><?php echo e($data['belum']); ?></strong></span>
                </div>
                <div style="position: relative; height: 6px; background: #e2e8f0; border-radius: 3px; overflow: hidden;">
                    <div style="position: absolute; top: 0; left: 0; height: 100%; width: <?php echo e($data['persentase']); ?>%; background: <?php echo e($data['persentase'] >= 80 ? 'linear-gradient(90deg, #10b981 0%, #34d399 100%)' : ($data['persentase'] >= 60 ? 'linear-gradient(90deg, #f59e0b 0%, #fbbf24 100%)' : 'linear-gradient(90deg, #ef4444 0%, #f87171 100%)')); ?>; border-radius: 3px; transition: width 0.5s ease; box-shadow: 0 2px 4px rgba(0,0,0,0.1);"></div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    <!-- Jadwal Hari Ini -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-calendar-day"></i>
                Jadwal Pelajaran Hari Ini
            </h3>
        </div>
        <div class="card-body">
            <?php if(count($jadwalHariIni['safinatunnajah']) > 0 || count($jadwalHariIni['muqodimah']) > 0): ?>
                <?php if(count($jadwalHariIni['safinatunnajah']) > 0): ?>
                <div style="margin-bottom: 1rem;">
                    <h4 style="font-size: 13px; font-weight: 600; color: #1e40af; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 6px;">
                        <span style="background: #3b82f6; color: white; padding: 2px 8px; border-radius: 4px; font-size: 10px;">SAFINATUNNAJAH</span>
                    </h4>
                    <?php $__currentLoopData = $jadwalHariIni['safinatunnajah']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jam): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 6px 10px; margin-bottom: 4px; background: #dbeafe; border-radius: 6px; font-size: 12px;">
                        <span><strong><?php echo e($jam['nama']); ?></strong></span>
                        <span style="color: #1e40af;"><?php echo e($jam['jam_mulai']); ?> - <?php echo e($jam['jam_selesai']); ?></span>
                        <span style="color: #1e40af;"><i class="fas fa-user-tie"></i> <?php echo e(Str::limit($jam['ustadz'], 15)); ?></span>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endif; ?>
                
                <?php if(count($jadwalHariIni['muqodimah']) > 0): ?>
                <div>
                    <h4 style="font-size: 13px; font-weight: 600; color: #047857; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 6px;">
                        <span style="background: #10b981; color: white; padding: 2px 8px; border-radius: 4px; font-size: 10px;">MUQODIMAH</span>
                    </h4>
                    <?php $__currentLoopData = $jadwalHariIni['muqodimah']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jam): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 6px 10px; margin-bottom: 4px; background: #dcfce7; border-radius: 6px; font-size: 12px;">
                        <span><strong><?php echo e($jam['nama']); ?></strong></span>
                        <span style="color: #047857;"><?php echo e($jam['jam_mulai']); ?> - <?php echo e($jam['jam_selesai']); ?></span>
                        <span style="color: #047857;"><i class="fas fa-user-tie"></i> <?php echo e(Str::limit($jam['ustadz'], 15)); ?></span>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="empty-state" style="padding: 20px;">
                    <i class="fas fa-calendar-times" style="font-size: 48px; color: #cbd5e1; margin-bottom: 12px;"></i>
                    <p style="color: #64748b; margin: 0;">Tidak ada jadwal pelajaran hari ini</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-bolt"></i>
            Aksi Cepat
        </h3>
    </div>
    <div class="card-body">
        <div style="display: flex; flex-wrap: wrap; gap: 1rem;">
            <a href="<?php echo e(route('petugas.presensi.index', ['tanggal' => now()->toDateString()])); ?>" class="btn" style="flex: 1; min-width: 200px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 14px 24px; border-radius: 12px; font-weight: 700; display: flex; align-items: center; justify-content: center; gap: 10px;">
                <i class="fas fa-clipboard-check"></i>
                Input Presensi Hari Ini
            </a>
            <a href="<?php echo e(route('petugas.presensi.edit', ['tanggal' => now()->toDateString()])); ?>" class="btn btn-secondary" style="flex: 1; min-width: 200px; background: white; color: #374151; border: 2px solid #e5e7eb; padding: 14px 24px; border-radius: 12px; font-weight: 700; display: flex; align-items: center; justify-content: center; gap: 10px;">
                <i class="fas fa-edit"></i>
                Edit Presensi
            </a>
            <a href="<?php echo e(route('petugas.presensi.index', ['tanggal' => \Carbon\Carbon::yesterday()->toDateString()])); ?>" class="btn btn-secondary" style="flex: 1; min-width: 200px; background: white; color: #374151; border: 2px solid #e5e7eb; padding: 14px 24px; border-radius: 12px; font-weight: 700; display: flex; align-items: center; justify-content: center; gap: 10px;">
                <i class="fas fa-calendar-day"></i>
                Presensi Kemarin
            </a>
        </div>
    </div>
</div>

<!-- Santri Belum Presensi -->
<?php if($santriBelumPresensi->count() > 0): ?>
<div class="card">
    <div class="card-header" style="background: #fef2f2; border-bottom: 1px solid #fecaca; display: flex; justify-content: space-between; align-items: center;">
        <h3 class="card-title" style="color: #991b1b; margin: 0; display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-exclamation-triangle"></i>
            Santri Belum Presensi Hari Ini
        </h3>
         <span class="badge" style="background: #ef4444; color: white; font-weight: 700; padding: 8px 16px; border-radius: 9999px; font-size: 14px;"><?php echo e($totalBelumPresensi); ?></span>
    </div>
    <div class="card-body" style="padding: 0;">
        <div style="overflow-x: auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Santri</th>
                        <th>Jenjang</th>
                        <th>Kelas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $santriBelumPresensi->take(10); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $santri): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td style="text-align: center;">
                            <span style="display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 28px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 50%; font-weight: 700; font-size: 13px;"><?php echo e($index + 1); ?></span>
                        </td>
                        <td style="font-weight: 600;"><?php echo e($santri->nama); ?></td>
                        <td>
                            <span class="badge" style="background: <?php echo e($santri->jenjang == 'Safinatunnajah' ? 'linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%)' : 'linear-gradient(135deg, #10b981 0%, #34d399 100%)'); ?>; color: white; font-weight: 700; padding: 6px 12px; border-radius: 9999px; font-size: 11px;">
                                <?php echo e($santri->jenjang); ?>

                            </span>
                        </td>
                        <td><?php echo e($santri->kelas ?? '-'); ?></td>
                        <td>
                            <a href="<?php echo e(route('petugas.presensi.index', ['jenjang' => strtolower($santri->jenjang == 'Safinatunnajah' ? 'safinatunnajah' : 'muqodimah')])); ?>" class="btn" style="background: linear-gradient(135deg, #ef4444 0%, #f87171 100%); color: white; border: none; padding: 8px 16px; border-radius: 8px; font-weight: 600; font-size: 12px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                                <i class="fas fa-edit"></i> Presensi
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php if($santriBelumPresensi->count() > 10): ?>
    <div style="padding: 16px; text-align: center; background: #fef2f2; border-top: 1px solid #fecaca; color: #991b1b; font-size: 13px; font-weight: 500;">
        Menampilkan 10 dari <?php echo e($santriBelumPresensi->count()); ?> santri belum presensi.
        <a href="<?php echo e(route('petugas.presensi.index')); ?>" style="color: #ef4444; font-weight: 700; text-decoration: none; margin-left: 4px;">Lihat semua →</a>
    </div>
    <?php endif; ?>
</div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-info-circle"></i>
            Informasi
        </h3>
    </div>
    <div class="card-body">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
            <div style="padding: 1rem; background: #f0f9ff; border-radius: 12px; border: 1px solid #bae6fd; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(59, 130, 246, 0.15)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                <h4 style="margin: 0 0 6px; font-size: 13px; font-weight: 800; color: #1e40af; text-transform: uppercase; letter-spacing: 0.05em; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-calendar-alt"></i> Hari Ini
                </h4>
                <p style="margin: 0; font-size: 15px; font-weight: 700; color: #0f172a; letter-spacing: -0.025em;">
                    <?php echo e($hariIni); ?>, <?php echo e($today); ?>

                </p>
            </div>
            
            <div style="padding: 1rem; background: #f0fdf4; border-radius: 12px; border: 1px solid #bbf7d0; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(16, 185, 129, 0.15)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                <h4 style="margin: 0 0 6px; font-size: 13px; font-weight: 800; color: #047857; text-transform: uppercase; letter-spacing: 0.05em; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-user-check"></i> Kelengkapan
                </h4>
                <p style="margin: 0; font-size: 15px; font-weight: 700; color: #0f172a; letter-spacing: -0.025em;">
                    Kehadiran: <span style="color: <?php echo e($persentase >= 80 ? '#047857' : ($persentase >= 60 ? '#92400e' : '#ef4444')); ?>;"><?php echo e($persentase); ?>%</span> (Target: 100%)
                </p>
            </div>
            
            <div style="padding: 1rem; background: #fffbeb; border-radius: 12px; border: 1px solid #fde68a; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(245, 158, 11, 0.15)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                <h4 style="margin: 0 0 6px; font-size: 13px; font-weight: 800; color: #92400e; text-transform: uppercase; letter-spacing: 0.05em; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-clock"></i> Update Terakhir
                </h4>
                <p style="margin: 0; font-size: 15px; font-weight: 700; color: #0f172a; letter-spacing: -0.025em;">
                    <?php echo e($lastUpdate ?? 'Belum ada presensi'); ?>

                </p>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-refresh data setiap 2 menit
setInterval(function() {
    location.reload();
}, 120000);

// Highlight statistik berdasarkan persentase
document.addEventListener('DOMContentLoaded', function() {
    // Tambahkan animasi simple untuk stat-card
    const statCards = document.querySelectorAll('.stat-card');
    statCards.forEach((card, index) => {
        card.style.animationDelay = (index * 0.1) + 's';
        card.classList.add('animate-fade-in');
    });
});
</script>

<style>
/* Premium Typography for Dashboard */
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap');

body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
}

/* Enhanced Card Styles */
.card {
    border: none;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.card:hover {
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
}

.card-header {
    border-bottom: 1px solid transparent;
    transition: all 0.3s ease;
}

.card:hover .card-header {
    border-bottom-color: #e2e8f0;
}

/* Stat Cards with Premium Effects */
.stat-card {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    backdrop-filter: blur(10px);
    position: relative;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 100%);
    border-radius: 16px;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.stat-card:hover::before {
    opacity: 1;
}

.stat-card:hover {
    transform: translateY(-4px) scale(1.02);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.15);
}

/* Buttons */
.btn {
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.btn::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.3);
    transform: translate(-50%, -50%);
    transition: width 0.6s, height 0.6s;
}

.btn:active::after {
    width: 300px;
    height: 300px;
}

/* Table Improvements */
.data-table {
    border-collapse: separate;
    border-spacing: 0;
    width: 100%;
}

.data-table thead th {
    font-weight: 700;
    text-transform: uppercase;
    font-size: 11px;
    letter-spacing: 0.08em;
    border-bottom: 2px solid #e2e8f0;
    padding: 12px;
    text-align: left;
}

.data-table tbody tr {
    transition: all 0.2s ease;
    border-bottom: 1px solid #f3f4f6;
}

.data-table tbody tr:hover {
    background: #f9fafb;
}

.data-table td {
    padding: 12px;
}

/* Badges */
.badge {
    font-weight: 700;
    letter-spacing: 0.025em;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: all 0.2s ease;
}

.badge:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
}

/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

.animate-fade-in {
    animation: fadeInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards;
    opacity: 0;
}

/* Smooth scroll */
html {
    scroll-behavior: smooth;
}

/* Focus accessibility */
.btn:focus,
.card:focus {
    outline: 2px solid #667eea;
    outline-offset: 2px;
}

/* Responsive */
@media (max-width: 768px) {
    .stat-card .stat-content h3 {
        font-size: 24px !important;
    }
    
    .stat-card .stat-content p {
        font-size: 10px !important;
    }
    
    .card-header p {
        font-size: 18px !important;
    }
}</style>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PROJEK BOSS\sistem-presensi\sistem-presensi\resources\views/petugas/dashboard.blade.php ENDPATH**/ ?>