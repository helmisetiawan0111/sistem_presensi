@extends('layouts.app')

@section('title', 'Jadwal Pelajaran')

@section('content')
<div class="card">
    <!-- Header -->
    <div class="card-header">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
            <div>
                <h3 class="card-title" style="margin-bottom: 4px;">
                    <i class="fas fa-calendar-alt"></i> Jadwal Pelajaran
                </h3>
                <p style="font-size: 12px; color: #64748b; margin: 0;">
                    <i class="fas fa-graduation-cap"></i> 
                    <strong>Safinatunnajah</strong> (Kelas 1) & 
                    <strong>Muqodimah</strong> (Kelas 2)
                </p>
            </div>
            <a href="{{ route('jam-pelajaran.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Jadwal
            </a>
        </div>
    </div>

    <!-- Filter -->
    <div style="padding: 20px; background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
        <form action="{{ route('jam-pelajaran.index') }}" method="GET" style="display: flex; gap: 12px; align-items: flex-end; flex-wrap: wrap;">
            <div style="min-width: 180px;">
                <label class="form-label">Filter Hari</label>
                <select name="hari" class="form-select" onchange="this.form.submit()">
                    <option value="">Semua Hari</option>
                    @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'] as $h)
                        <option value="{{ $h }}" {{ request('hari') == $h ? 'selected' : '' }}>{{ $h }}</option>
                    @endforeach
                </select>
            </div>
            @if(request('hari'))
            <div>
                <a href="{{ route('jam-pelajaran.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Reset
                </a>
            </div>
            @endif
        </form>
    </div>

    @if($jamPelajaran->count() > 0)
        @php
            $grouped = $jamPelajaran->groupBy('hari');
            $hariOrder = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'];
            $grouped = $grouped->sortBy(function($items, $key) use ($hariOrder) {
                return array_search($key, $hariOrder);
            });
        @endphp

        @foreach($grouped as $hari => $jamsByHari)
            @php
                $byKelas = $jamsByHari->groupBy('kelas');
                // Ensure order: Safinatunnajah first, then Muqodimah
                $orderedKelas = ['Safinatunnajah', 'Muqodimah'];
                $byKelas = $byKelas->sortBy(function($items, $key) use ($orderedKelas) {
                    return array_search($key, $orderedKelas);
                });
            @endphp

            @foreach($byKelas as $kelas => $jams)
                @php
                    if(is_null($kelas)) continue;
                    
                    $gradients = [
                        'Safinatunnajah' => 'linear-gradient(135deg, #059669 0%, #10b981 100%)',
                        'Muqodimah' => 'linear-gradient(135deg, #2563eb 0%, #3b82f6 100%)',
                    ];
                    $badgeColors = [
                        'Safinatunnajah' => 'badge-success',
                        'Muqodimah' => 'badge-info',
                    ];
                    $iconColor = $kelas == 'Safinatunnajah' ? '#10b981' : '#3b82f6';
                    $bgGradient = $gradients[$kelas] ?? $gradients['Safinatunnajah'];
                    $badgeClass = $badgeColors[$kelas] ?? 'badge-success';
                @endphp

                <div style="margin-bottom: 24px;">
                    <!-- Header Hari + Kelas -->
                    <div style="background: {{ $bgGradient }}; color: white; padding: 12px 20px; border-radius: 10px; margin-bottom: 12px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <i class="fas fa-calendar-day" style="font-size: 20px;"></i>
                            <div>
                                <span style="font-size: 18px; font-weight: 700;">{{ $hari }}</span>
                                <span style="font-size: 13px; background: rgba(255,255,255,0.25); padding: 4px 12px; border-radius: 20px; margin-left: 10px; font-weight: 600;">
                                    {{ $kelas }}
                                </span>
                            </div>
                        </div>
                        <span style="font-size: 13px; background: rgba(255,255,255,0.2); padding: 6px 14px; border-radius: 20px; font-weight: 600;">
                            {{ $jams->count() }} jam
                        </span>
                    </div>

                    <!-- Cards Grid -->
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 16px;">
                        @foreach($jams->sortBy('urutan') as $jam)
                            <div style="background: white; border: 1px solid #e2e8f0; border-radius: 10px; padding: 18px; transition: all 0.2s ease; box-shadow: 0 2px 4px rgba(0,0,0,0.04);"
                                 onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 16px rgba(0,0,0,0.1)';"
                                 onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0,0,0,0.04)';">
                                <!-- Header Card -->
                                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 14px;">
                                    <div>
                                        <div style="font-weight: 700; font-size: 16px; color: #1e293b; margin-bottom: 6px;">
                                            {{ $jam->nama }}
                                        </div>
<div style="font-size: 13px; color: #64748b; display: flex; align-items: center; gap: 6px;">
    <i class="fas fa-clock" style="color: #3b82f6;"></i>
    <span>{{ \Carbon\Carbon::parse($jam->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jam->jam_selesai)->format('H:i') }}</span>
</div>
                                    </div>
                                    <span class="badge {{ $badgeClass }}" style="font-size: 11px; padding: 6px 12px;">
                                        {{ $jam->status ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </div>

                                <!-- Ustadz -->
                                <div style="display: flex; align-items: center; gap: 10px; font-size: 14px; color: #475569; margin-bottom: 16px; padding: 10px; background: #f8fafc; border-radius: 6px;">
                                    <i class="fas fa-user-tie" style="color: {{ $iconColor }}; font-size: 16px;"></i>
                                    <span style="font-weight: 600;">{{ $jam->ustadz }}</span>
                                </div>

                                <!-- Actions -->
                                <div style="display: flex; justify-content: flex-end; gap: 8px; border-top: 1px solid #f1f5f9; padding-top: 12px;">
                                    <a href="{{ route('jam-pelajaran.edit', $jam->id) }}" class="btn btn-sm btn-secondary">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('jam-pelajaran.destroy', $jam->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="event.preventDefault(); Swal.fire({ title: 'Hapus jadwal?', text: 'Apakah Anda yakin ingin menghapus jadwal ini?', icon: 'warning', showCancelButton: true, confirmButtonColor: '#ef4444', cancelButtonColor: '#6c757d', confirmButtonText: 'Ya, hapus!', cancelButtonText: 'Batal' }).then((result) => { if (result.isConfirmed) { this.closest('form').submit(); } });">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @endforeach
    @else
    <div class="empty-state">
        <i class="fas fa-calendar-times" style="font-size: 72px; color: #cbd5e1; margin-bottom: 20px;"></i>
        <h3 style="color: #64748b; font-weight: 600;">Belum Ada Jadwal</h3>
        <p style="color: #94a3b8;">Silakan tambah jadwal pelajaran untuk mengatur waktu mengajar.</p>
        <a href="{{ route('jam-pelajaran.create') }}" class="btn btn-primary" style="margin-top: 24px;">
            <i class="fas fa-plus"></i> Tambah Jadwal Pertama
        </a>
    </div>
    @endif
</div>
@endsection
