@php
    $badgeClass = 'badge-info';
    $iconClass = 'sakit';
    switch ($activity['status'] ?? '') {
        case 'hadir':
            $badgeClass = 'hadir';
            $iconClass = 'hadir';
            break;
        case 'alpha':
            $badgeClass = 'alpha';
            $iconClass = 'alpha';
            break;
        case 'izin':
            $badgeClass = 'izin';
            $iconClass = 'izin';
            break;
        case 'sakit':
            $badgeClass = 'sakit';
            $iconClass = 'sakit';
            break;
    }
@endphp

<div class="activity-item">
    <div class="activity-icon {{ $iconClass }}">
        <i class="fas fa-circle"></i>
    </div>
    <div>
        <div style="font-weight:500; color:#1e293b;">{{ $activity['nama_status'] ?? ucfirst($activity['status'] ?? '-') }}</div>
        <div style="font-size:0.8rem; color:#64748b;">
            {{ \Carbon\Carbon::parse($activity['tanggal'])->format('d M Y') }}
        </div>
    </div>
</div>