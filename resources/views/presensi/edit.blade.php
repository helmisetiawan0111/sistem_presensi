@extends('layouts.app')

@section('title', 'Edit Presensi')

@section('content')
<div class="card" style="margin-bottom: 1rem;">
    <div class="card-body">
        <div class="mb-3">
            <h3 class="card-title">Edit Presensi - {{ $tanggal }} ({{ $hari }})</h3>
            <p><strong>Petugas:</strong> {{ Auth::user()->name }}</p>
        </div>
    </div>
</div>

<!-- Tanggal Selection -->
<div class="card">
    <div class="card-body">
        <form action="{{ request()->segment(1) == 'petugas' ? route('petugas.presensi.edit') : route('presensi.edit') }}" method="GET" style="display: flex; gap: 12px; align-items: flex-end; flex-wrap: wrap;">
            <div style="min-width: 180px;">
                <label class="form-label">Pilih Tanggal</label>
                <input type="date" class="form-control" name="tanggal" value="{{ $tanggal }}" onchange="this.form.submit()">
            </div>
        </form>
    </div>
</div>

<div class="card">
    <form action="{{ request()->segment(1) == 'petugas' ? route('petugas.presensi.update', $tanggal) : route('presensi.update', $tanggal) }}" method="POST" id="presensiForm">
        @csrf
        @method('PUT')
        <input type="hidden" name="jenjang" id="jenjangInput" value="{{ $jenjangFilter ?? 'safinatunnajah' }}">
        
        <!-- Jenjang Selection -->
        <div class="jenjang-container">
            <div onclick="selectJenjang('safinatunnajah')" id="card-safinatunnajah" 
                 class="jenjang-card {{ ($jenjangFilter ?? 'safinatunnajah') == 'safinatunnajah' ? 'active-safinatunnajah' : '' }}">
                <div class="jenjang-label safinatunnajah">SAFINATUNNAJAH</div>
                <div class="jenjang-sub">Kelas 1</div>
            </div>
            
            <div onclick="selectJenjang('muqodimah')" id="card-muqodimah" 
                 class="jenjang-card {{ $jenjangFilter == 'muqodimah' ? 'active-muqodimah' : '' }}">
                <div class="jenjang-label muqodimah">MUQODIMAH</div>
                <div class="jenjang-sub">Kelas 2</div>
            </div>
        </div>
        
        <!-- Jam Pelajaran -->
        <div class="form-group" style="margin-top: 1rem;">
            <label class="form-label">Pilih Jam Pelajaran</label>
            <select name="jam_pelajaran_id" id="jamPelajaranSelect" class="form-select">
                <option value="">-- Pilih Jam --</option>
                @if($jenjangFilter == 'safinatunnajah')
                    @foreach($jamPelajaran['safinatunnajah'] as $jam)
                        <option value="{{ $jam['id'] }}">
                            {{ $jam['nama'] }} ({{ $jam['jam_mulai'] }} - {{ $jam['jam_selesai'] }}) - {{ $jam['ustadz'] }}
                        </option>
                    @endforeach
                @endif
                @if($jenjangFilter == 'muqodimah')
                    @foreach($jamPelajaran['muqodimah'] as $jam)
                        <option value="{{ $jam['id'] }}">
                            {{ $jam['nama'] }} ({{ $jam['jam_mulai'] }} - {{ $jam['jam_selesai'] }}) - {{ $jam['ustadz'] }}
                        </option>
                    @endforeach
                @endif
            </select>
        </div>
        
        <!-- Presensi Table -->
        <div class="table-wrapper">
            <table class="presensi-table">
                <thead>
                    <tr>
                        <th class="th-name">Nama Santri</th>
                        <th class="th-jenjang">Jenjang</th>
                        <th class="th-status">Status Presensi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($santri as $s)
                        @php
                            $currentStatus = $existingAbsensi[$s->id] ?? null;
                        @endphp
                        <tr class="presensi-row">
                            <td class="td-name">{{ $s->nama }}</td>
                            <td class="td-jenjang">
                                <span class="badge {{ $s->jenjang == 'Safinatunnajah' ? 'badge-primary' : 'badge-success' }}">{{ $s->jenjang }}</span>
                            </td>
                            <td class="td-status">
                                <div class="status-options">
                                    <label class="status-option hadir {{ $currentStatus === 'hadir' ? 'selected' : '' }}"
                                           style="background: {{ $currentStatus === 'hadir' ? '#dcfce7' : 'white' }}; border-color: {{ $currentStatus === 'hadir' ? '#166534' : '#e5e7eb' }}; color: {{ $currentStatus === 'hadir' ? '#166534' : '#4b5563' }};">
                                        <input type="radio" name="presensi[{{ $s->id }}]" value="hadir" data-santri="{{ $s->id }}" class="presensi-radio" {{ $currentStatus === 'hadir' ? 'checked' : '' }}>
                                        <span>✓ Hadir</span>
                                    </label>
                                    <label class="status-option izin {{ $currentStatus === 'izin' ? 'selected' : '' }}"
                                           style="background: {{ $currentStatus === 'izin' ? '#fef3c7' : 'white' }}; border-color: {{ $currentStatus === 'izin' ? '#92400e' : '#e5e7eb' }}; color: {{ $currentStatus === 'izin' ? '#92400e' : '#4b5563' }};">
                                        <input type="radio" name="presensi[{{ $s->id }}]" value="izin" data-santri="{{ $s->id }}" class="presensi-radio" {{ $currentStatus === 'izin' ? 'checked' : '' }}>
                                        <span>⚠ Izin</span>
                                    </label>
                                    <label class="status-option sakit {{ $currentStatus === 'sakit' ? 'selected' : '' }}"
                                           style="background: {{ $currentStatus === 'sakit' ? '#f3e8ff' : 'white' }}; border-color: {{ $currentStatus === 'sakit' ? '#5b21b6' : '#e5e7eb' }}; color: {{ $currentStatus === 'sakit' ? '#5b21b6' : '#4b5563' }};">
                                        <input type="radio" name="presensi[{{ $s->id }}]" value="sakit" data-santri="{{ $s->id }}" class="presensi-radio" {{ $currentStatus === 'sakit' ? 'checked' : '' }}>
                                        <span>⚕ Sakit</span>
                                    </label>
                                    <label class="status-option alpha {{ $currentStatus === 'alpha' ? 'selected' : '' }}"
                                           style="background: {{ $currentStatus === 'alpha' ? '#fee2e2' : 'white' }}; border-color: {{ $currentStatus === 'alpha' ? '#991b1b' : '#e5e7eb' }}; color: {{ $currentStatus === 'alpha' ? '#991b1b' : '#4b5563' }};">
                                        <input type="radio" name="presensi[{{ $s->id }}]" value="alpha" data-santri="{{ $s->id }}" class="presensi-radio" {{ $currentStatus === 'alpha' ? 'checked' : '' }}>
                                        <span>✗ Alpha</span>
                                    </label>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div id="saveStatus" class="save-status"></div>
    </form>
</div>

<script>
const jamPelajaranSelect = document.getElementById('jamPelajaranSelect');
const saveStatus = document.getElementById('saveStatus');
const jenjangInput = document.getElementById('jenjangInput');

function selectJenjang(jenjang) {
    const currentUrl = new URL(window.location);
    currentUrl.searchParams.set('jenjang', jenjang);
    window.location.href = currentUrl.toString();
}

function showSaveStatus(message, type) {
    // Empty - tidak menampilkan pesan
}

document.querySelectorAll('.presensi-radio').forEach(radio => {
    radio.addEventListener('change', function() {
        // No auto-save in edit mode, require manual submit
    });
});
</script>

<style>
/* Style sama dengan presensi/index */
.jenjang-container {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 1rem;
}

.jenjang-card {
    flex: 1;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    border: 2px solid #e5e7eb;
    cursor: pointer;
    transition: all 0.3s;
    text-align: center;
    background: white;
    min-width: 140px;
}

.jenjang-card:hover {
    background: #f9fafb;
}

.active-safinatunnajah {
    background: #eff6ff;
    border-color: #3b82f6;
    box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.3);
}

.active-muqodimah {
    background: #ecfdf5;
    border-color: #10b981;
    box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.3);
}

.jenjang-label {
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 4px;
}

.jenjang-label.safinatunnajah {
    color: #1e40af;
}

.jenjang-label.muqodimah {
    color: #047857;
}

.jenjang-sub {
    font-size: 11px;
    color: #6b7280;
}

/* Table - Compact */
/* Table - Compact */
.table-wrapper {
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    border-radius: 8px;
    overflow: hidden;
}

.presensi-table {
    margin: 0;
    border-spacing: 0;
    border-collapse: collapse;
    width: 100%;
}

.presensi-table thead tr {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.presensi-table th {
    padding: 10px 12px;
    text-align: left;
    font-size: 13px;
    color: white;
    font-weight: 600;
}

.presensi-row {
    border-bottom: 1px solid #e2e8f0;
    transition: background 0.15s;
    height: 44px;
}

.presensi-row:hover {
    background: #f8fafc;
}

.td-name {
    padding: 0.5rem 0.75rem;
    font-weight: 500;
    color: #111827;
    font-size: 0.8rem;
}

.td-jenjang {
    padding: 0.5rem 0.75rem;
}

.td-status {
    padding: 0.5rem 0.75rem;
}

/* Status Options - Compact */
.status-options {
    display: flex;
    gap: 4px;
    align-items: center;
    flex-wrap: wrap;
}

.status-option {
    display: flex;
    align-items: center;
    gap: 2px;
    cursor: pointer;
    padding: 0.25rem 0.5rem; /* 3px 6px */
    border-radius: 3px;
    border: 1px solid #e5e7eb;
    transition: all 0.1s;
    font-size: 0.75rem; /* 12px */
    font-weight: 500;
    justify-content: center;
    min-width: 48px;
}

.status-option:hover {
    background: #f9fafb;
    transform: scale(1.02);
}

.save-status {
    margin-top: 0.75rem;
    font-size: 13px;
}

/* Style sama dengan presensi/index */
.jenjang-container {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 1rem;
}

.jenjang-card {
    flex: 1;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    border: 2px solid #e5e7eb;
    cursor: pointer;
    transition: all 0.3s;
    text-align: center;
    background: white;
    min-width: 140px;
}

.jenjang-card:hover {
    background: #f9fafb;
}

.active-safinatunnajah {
    background: #eff6ff;
    border-color: #3b82f6;
    box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.3);
}

.active-muqodimah {
    background: #ecfdf5;
    border-color: #10b981;
    box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.3);
}

.jenjang-label {
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 4px;
}

.jenjang-label.safinatunnajah {
    color: #1e40af;
}

.jenjang-label.muqodimah {
    color: #047857;
}

.jenjang-sub {
    font-size: 11px;
    color: #6b7280;
}

/* Table - Compact */
.table-wrapper {
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    border-radius: 8px;
    overflow: hidden;
}

.presensi-table {
    margin: 0;
    border-spacing: 0;
    border-collapse: collapse;
    width: 100%;
}

.presensi-table thead tr {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.presensi-table th {
    padding: 10px 12px;
    text-align: left;
    font-size: 13px;
    color: white;
    font-weight: 600;
}

.presensi-row {
    border-bottom: 1px solid #f1f5f9;
    transition: background 0.2s;
}

.presensi-row:hover {
    background: #f8fafc;
}

.td-name {
    padding: 8px 12px;
    font-weight: 500;
    color: #1f2937;
    font-size: 13px;
}

.td-jenjang {
    padding: 8px 12px;
}

.td-status {
    padding: 8px 12px;
}

/* Status Options - Compact */
.status-options {
    display: flex;
    gap: 6px;
    align-items: center;
    flex-wrap: wrap;
}

.status-option {
    display: flex;
    align-items: center;
    gap: 4px;
    cursor: pointer;
    padding: 4px 8px;
    border-radius: 4px;
    border: 1px solid #e5e7eb;
    transition: all 0.2s;
    font-size: 12px;
    font-weight: 500;
    justify-content: center;
    min-width: 70px;
}

.status-option:hover {
    background: #f9fafb;
}

.save-status {
    margin-top: 0.75rem;
    font-size: 13px;
}

.jenjang-card:hover {
    background: #f8fafc;
    transform: translateY(-1px);
}

.active-safinatunnajah {
    background: #eff6ff;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59,130,246,0.1), 0 4px 6px -1px rgba(59, 130, 246, 0.15);
}

.active-muqodimah {
    background: #ecfdf5;
    border-color: #10b981;
    box-shadow: 0 0 0 3px rgba(16,185,129,0.1), 0 4px 6px -1px rgba(16, 185, 129, 0.15);
}

/* Active indicator check */
.jenjang-card.active-safinatunnajah::after,
.jenjang-card.active-muqodimah::after {
    content: "✓";
    position: absolute;
    top: 0.5rem;
    right: 0.75rem;
    font-size: 1rem;
    color: currentColor;
    opacity: 0.9;
}

.jenjang-label {
    font-size: 0.8125rem; /* 13px */
    font-weight: 600;
    margin-bottom: 0.25rem;
    line-height: 1.2;
}

.jenjang-label.safinatunnajah {
    color: #1e40af;
}

.jenjang-label.muqodimah {
    color: #047857;
}

.jenjang-sub {
    font-size: 0.75rem; /* 12px */
    color: #6b7280;
    line-height: 1.3;
}

.table-wrapper {
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    border-radius: 8px;
    overflow: hidden;
}

.presensi-table {
    margin: 0;
    border-spacing: 0;
    border-collapse: collapse;
    width: 100%;
}

.presensi-table thead tr {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.presensi-table th {
    padding: 10px 12px;
    text-align: left;
    font-size: 13px;
    color: white;
    font-weight: 600;
}

.presensi-row {
    border-bottom: 1px solid #f1f5f9;
    transition: background 0.2s;
}

.presensi-row:hover {
    background: #f8fafc;
}

.td-name {
    padding: 8px 12px;
    font-weight: 500;
    color: #1f2937;
    font-size: 13px;
}

.td-jenjang {
    padding: 8px 12px;
}

.td-status {
    padding: 8px 12px;
}

.status-options {
    display: flex;
    gap: 6px;
    align-items: center;
    flex-wrap: wrap;
}

.status-option {
    display: flex;
    align-items: center;
    gap: 4px;
    cursor: pointer;
    padding: 4px 8px;
    border-radius: 4px;
    border: 1px solid #e5e7eb;
    transition: all 0.2s;
    font-size: 12px;
    font-weight: 500;
    justify-content: center;
    min-width: 70px;
}

.status-option:hover {
    background: #f9fafb;
}

.save-status {
    margin-top: 0.75rem;
    font-size: 13px;
}
</style>
@endsection