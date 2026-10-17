@php
    $active = $jadwal['active'] ?? false;
    $nama = strtolower($jadwal['nama'] ?? '');
    $icon = 'fa-book';
    if(str_contains($nama, 'shalat') || str_contains($nama, 'sholat')) $icon = 'fa-mosque';
    elseif(str_contains($nama, 'quran') || str_contains($nama, 'tilawah') || str_contains($nama, 'tahfidz')) $icon = 'fa-book-quran';
    elseif(str_contains($nama, 'fiqih') || str_contains($nama, 'fikih')) $icon = 'fa-scale-balanced';
    elseif(str_contains($nama, 'hadits')) $icon = 'fa-scroll';
    elseif(str_contains($nama, 'tajwid')) $icon = 'fa-spell-check';
    elseif(str_contains($nama, 'akhlaq') || str_contains($nama, 'adab')) $icon = 'fa-heart-handshake';
@endphp

<div class="schedule-card-item {{ $active ? 'active' : '' }}">
    @if($active)
        <span style="background:#10b981; color:white; padding:2px 8px; border-radius:12px; font-size:0.7rem; margin-bottom:0.5rem; display:inline-block;">
            <i class="fas fa-circle" style="font-size:0.4rem;"></i> Sedang Berlangsung
        </span>
    @endif
    <div class="schedule-time">{{ $jadwal['jam_mulai'] }} - {{ $jadwal['jam_selesai'] }}</div>
    <div class="schedule-name">{{ $jadwal['nama'] }}</div>
    @if(!empty($jadwal['ustadz']))
        <div class="schedule-ustadz">
            <i class="fas fa-chalkboard-teacher"></i> {{ $jadwal['ustadz'] }}
        </div>
    @endif
</div>